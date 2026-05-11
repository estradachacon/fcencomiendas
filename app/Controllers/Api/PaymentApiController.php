<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PagoModel;

class PaymentApiController extends BaseController
{
    public function paySellerByAccount()
    {
        helper(['transaction', 'bitacora']);

        $db   = db_connect();
        $data = $this->request->getJSON(true);

        if (
            empty($data['seller_id']) ||
            empty($data['packages'])  ||
            empty($data['cuenta_id']) ||
            empty($data['user_id'])
        ) {
            return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
        }

        $sellerId  = (int) $data['seller_id'];
        $packages  = $data['packages'];
        $accountId = (int) $data['cuenta_id'];
        $userId    = (int) $data['user_id'];

        // ── 1. Calcular totales ───────────────────────────────────────────
        $totalSalida  = 0.0;
        $totalEntrada = 0.0;
        $packagesDB   = [];

        foreach ($packages as $pkg) {
            $rawId       = (string) $pkg['id'];
            $esSoloFlete = str_starts_with($rawId, 'flete-');
            $packageId   = (int) str_replace('flete-', '', $rawId);

            $row = $db->table('packages')
                ->where('id', $packageId)
                ->where('vendedor', $sellerId)
                ->get()->getRowArray();

            if (!$row) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Paquete inválido: #' . $rawId,
                ]);
            }

            $monto     = (float)($row['monto'] ?? 0);
            $pendiente = (float)($row['flete_pendiente'] ?? 0);

            if ($esSoloFlete) {
                $totalEntrada += $pendiente;
            } else {
                $totalSalida  += $monto;
                $totalEntrada += $pendiente;
            }

            $packagesDB[] = [
                'id'                    => $packageId,
                'monto'                 => $esSoloFlete ? 0.0 : $monto,
                'pendiente'             => $pendiente,
                'estatus'               => $row['estatus'] ?? null,
                'tipo'                  => $esSoloFlete ? 'solo_flete' : ($pendiente > 0 ? 'con_descuento_flete' : 'normal'),
                'flete_pagado_antes'    => (float)($row['flete_pagado'] ?? 0),
                'flete_pendiente_antes' => $pendiente,
                'es_solo_flete'         => $esSoloFlete,
            ];
        }

        // ── 2. Validar cuenta ─────────────────────────────────────────────
        $account = $db->table('accounts')->where('id', $accountId)->get()->getRowArray();

        if (!$account) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cuenta no encontrada']);
        }

        $totalNeto = $totalSalida - $totalEntrada;

        // ── 3. Transacción DB ─────────────────────────────────────────────
        $db->transStart();

        $pagoModel = new PagoModel();
        $pagoId    = $pagoModel->insert([
            'seller_id'   => $sellerId,
            'total_bruto' => $totalSalida,
            'total_flete' => $totalEntrada,
            'total_neto'  => $totalNeto,
            'metodo'      => 'cuenta',
            'cuenta_id'   => $accountId,
            'anulado'     => 0,
            'created_by'  => $userId,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        foreach ($packagesDB as $p) {
            $db->table('package_payments')->insert([
                'pago_id'               => $pagoId,
                'seller_id'             => $sellerId,
                'package_id'            => $p['id'],
                'tipo'                  => $p['tipo'],
                'monto_pagado'          => $p['monto'],
                'flete_descontado'      => $p['pendiente'],
                'flete_pagado_antes'    => $p['flete_pagado_antes'],
                'flete_pendiente_antes' => $p['flete_pendiente_antes'],
                'flete_pagado'          => $p['flete_pagado_antes'] + $p['pendiente'],
                'metodo'                => 'cuenta',
                'revertido'             => 0,
                'created_at'            => date('Y-m-d H:i:s'),
            ]);

            $builder = $db->table('packages')->where('id', $p['id']);

            if ($p['es_solo_flete']) {
                $builder
                    ->set('flete_pagado',   "COALESCE(flete_pagado,0) + {$p['pendiente']}", false)
                    ->set('flete_pendiente', 0)
                    ->set('metodo_remu',     'cuenta')
                    ->set('remu_user_id',    $userId);
            } else {
                $builder
                    ->set('amount_paid',            $p['monto'])
                    ->set('flete_pagado',            "COALESCE(flete_pagado,0) + {$p['pendiente']}", false)
                    ->set('flete_pendiente',         0)
                    ->set('metodo_remu',             'cuenta')
                    ->set('remunerado_con_cuenta',   $accountId)
                    ->set('remu_user_id',            $userId);

                if ($p['estatus'] === 'entregado') {
                    $builder
                        ->set('estatus',    'finalizado')
                        ->set('estatus2',   'remunerado')
                        ->set('fecha_remu', date('Y-m-d H:i:s'));
                }
            }

            $builder->update();
        }

        $db->table('accounts')
            ->where('id', $accountId)
            ->set('balance', "balance - {$totalSalida} + {$totalEntrada}", false)
            ->update();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al procesar el pago']);
        }

        // ── 4. Registrar movimientos ──────────────────────────────────────
        $ids = implode(', ', array_column($packagesDB, 'id'));

        if ($totalSalida > 0) {
            registrarSalida(
                $accountId,
                $totalSalida,
                "Remuneración vendedor ID {$sellerId}",
                "Pago de paquetes: ID {$ids}",
                null
            );
        }

        if ($totalEntrada > 0) {
            registrarEntrada(
                $accountId,
                $totalEntrada,
                "Cobro fletes vendedor ID {$sellerId}, paquetes: ID {$ids}",
                "Descuento por flete pendiente",
                null
            );
        }

        registrar_bitacora(
            'Pago a vendedor ID ' . $sellerId,
            'Remuneraciones por cuenta (app)',
            'Salida: L' . number_format($totalSalida, 2) .
                ' | Entrada fletes: L' . number_format($totalEntrada, 2) .
                ' | Neto: L' . number_format($totalNeto, 2),
            $userId
        );

        return $this->response->setJSON([
            'success'    => true,
            'total_paid' => $totalNeto,
            'pago_id'    => $pagoId,
        ]);
    }
}

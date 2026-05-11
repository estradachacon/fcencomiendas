<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PermisoRolModel;

class SyncController extends BaseController
{
    public function saveToken()
    {
        $token = $this->request->getPost('token');

        if (!$token) {
            return $this->response->setJSON([
                'success' => false
            ]);
        }

        $db = db_connect();

        $db->table('device_tokens')->insert([
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'success' => true
        ]);
    }
    public function users()
    {
        $userModel = new UserModel();
        $permisoModel = new PermisoRolModel();

        $users = $userModel->findAll();

        $data = [];

        foreach ($users as $user) {

            $permisosRaw = $permisoModel->getPermisosPorRol($user['role_id']);

            $permisos = [];

            foreach ($permisosRaw as $p) {
                $permisos[$p['nombre_accion']] = (bool)$p['habilitado'];
            }

            $fotoUrl = null;
            if (!empty($user['foto'])) {
                $fotoUrl = base_url('upload/perfiles/' . $user['foto']);
            }

            $data[] = [
                'id' => (int)$user['id'],
                'username' => $user['user_name'],
                'email' => $user['email'],
                'password_hash' => $user['user_password'],
                'role_id' => $user['role_id'],
                'branch_id' => $user['branch_id'],
                'foto' => $user['foto'],
                'foto_url' => $fotoUrl,
                'permisos' => $permisos
            ];
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }

    public function packages()
    {
        $db = db_connect();

        $perPage = (int)($this->request->getGet('per_page') ?? 50);
        $page    = max(1, (int)($this->request->getGet('page') ?? 1));
        $offset  = ($page - 1) * $perPage;

        $branchId = $this->request->getGet('branch_id');
        $estatus  = $this->request->getGet('estatus');
        $desde    = $this->request->getGet('desde');
        $hasta    = $this->request->getGet('hasta');
        $q        = $this->request->getGet('q');

        $builder = $db->table('packages p')
            ->select('
                p.id,
                p.cliente,
                p.tipo_servicio,
                p.fecha_ingreso,
                p.estatus,
                p.estatus2,
                p.monto,
                p.flete_total,
                p.flete_pagado,
                p.flete_pendiente,
                p.fragil,
                p.comentarios,
                p.foto,
                p.reenvios,
                p.destino_personalizado,
                p.fecha_pack_entregado,
                p.fecha_entrega_personalizado,
                p.fecha_entrega_puntofijo,
                p.branch,
                p.colonia_id,
                p.external_location_id,
                p.created_at,
                p.updated_at,
                s.seller AS seller_name,
                s.id     AS vendedor_id,
                sp.point_name AS puntofijo_nombre,
                b.branch_name,
                el.nombre AS external_location_nombre
            ')
            ->join('sellers s',           's.id = p.vendedor',                'left')
            ->join('settled_points sp',   'sp.id = p.id_puntofijo',           'left')
            ->join('branches b',          'b.id = p.branch',                  'left')
            ->join('external_locations el', 'el.id = p.external_location_id', 'left')
            ->orderBy('p.id', 'DESC');

        if (!empty($branchId)) {
            $builder->where('p.branch', $branchId);
        }
        if (!empty($estatus)) {
            $builder->groupStart()
                ->where('p.estatus', $estatus)
                ->orWhere('p.estatus2', $estatus)
                ->groupEnd();
        }
        if (!empty($desde)) {
            $builder->where('DATE(p.fecha_ingreso) >=', $desde);
        }
        if (!empty($hasta)) {
            $builder->where('DATE(p.fecha_ingreso) <=', $hasta);
        }
        if (!empty($q)) {
            $builder->groupStart()
                ->like('p.cliente', $q)
                ->orLike('CAST(p.id AS CHAR)', $q)
                ->groupEnd();
        }

        $total   = $builder->countAllResults(false);
        $rows    = $builder->limit($perPage, $offset)->get()->getResultArray();

        $data = array_map(fn($r) => [
            'id'                          => (int)$r['id'],
            'cliente'                     => $r['cliente'],
            'vendedor_id'                 => (int)$r['vendedor_id'],
            'seller_name'                 => $r['seller_name'] ?? '',
            'tipo_servicio'               => $r['tipo_servicio'],
            'fecha_ingreso'               => $r['fecha_ingreso'],
            'estatus'                     => $r['estatus'],
            'estatus2'                    => $r['estatus2'],
            'monto'                       => (float)$r['monto'],
            'flete_total'                 => (float)$r['flete_total'],
            'flete_pagado'                => (float)$r['flete_pagado'],
            'flete_pendiente'             => (float)$r['flete_pendiente'],
            'fragil'                      => (bool)$r['fragil'],
            'comentarios'                 => $r['comentarios'],
            'foto'                        => $r['foto'],
            'reenvios'                    => (int)$r['reenvios'],
            'destino_personalizado'       => $r['destino_personalizado'],
            'puntofijo_nombre'            => $r['puntofijo_nombre'] ?? '',
            'branch'                      => $r['branch'],
            'branch_name'                 => $r['branch_name'] ?? '',
            'external_location_nombre'    => $r['external_location_nombre'] ?? '',
            'fecha_pack_entregado'        => $r['fecha_pack_entregado'],
            'fecha_entrega_personalizado' => $r['fecha_entrega_personalizado'],
            'fecha_entrega_puntofijo'     => $r['fecha_entrega_puntofijo'],
            'created_at'                  => $r['created_at'],
            'updated_at'                  => $r['updated_at'],
        ], $rows);

        return $this->response->setJSON([
            'success'  => true,
            'data'     => $data,
            'total'    => (int)$total,
            'page'     => $page,
            'per_page' => $perPage,
            'pages'    => (int)ceil($total / $perPage),
        ]);
    }

    public function packageDetail(int $id)
    {
        $db = db_connect();

        $row = $db->table('packages p')
            ->select('
                p.*,
                s.seller                    AS seller_name,
                u.user_name                 AS creador_nombre,
                ru.user_name                AS remu_user_nombre,
                sp.point_name               AS puntofijo_nombre,
                ac.name                     AS pago_cuenta_nombre,
                col.nombre                  AS colonia_nombre,
                mun.nombre                  AS municipio_nombre,
                dep.nombre                  AS departamento_nombre,
                el.nombre                   AS external_location_nombre
            ')
            ->join('sellers s',             's.id  = p.vendedor',               'left')
            ->join('users u',               'u.id  = p.user_id',                'left')
            ->join('users ru',              'ru.id = p.remu_user_id',           'left')
            ->join('settled_points sp',     'sp.id = p.id_puntofijo',           'left')
            ->join('accounts ac',           'ac.id = p.pago_cuenta',            'left')
            ->join('colonias col',          'col.id = p.colonia_id',            'left')
            ->join('municipios mun',        'mun.id = col.municipio_id',        'left')
            ->join('departamentos dep',     'dep.id = mun.departamento_id',     'left')
            ->join('external_locations el', 'el.id  = p.external_location_id',  'left')
            ->where('p.id', (int)$id)
            ->get()
            ->getRowArray();

        if (!$row) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Paquete no encontrado',
            ]);
        }

        // Foto URL
        $fotoUrl = null;
        if (!empty($row['foto'])) {
            $fotoUrl = base_url('upload/paquetes/' . $row['foto']);
        }

        // Destino y fecha de entrega según tipo_servicio
        $tipoServicio = (int)$row['tipo_servicio'];
        $destino      = null;
        $ubicacion    = null;
        $fechaEntrega = null;

        switch ($tipoServicio) {
            case 1:
                $destino      = $row['puntofijo_nombre'];
                $fechaEntrega = $row['fecha_entrega_puntofijo'];
                break;
            case 2:
                $destino      = $row['destino_personalizado'];
                $fechaEntrega = $row['fecha_entrega_personalizado'];
                $partes = array_filter([
                    $row['departamento_nombre'],
                    $row['municipio_nombre'],
                    $row['colonia_nombre'],
                ]);
                $ubicacion = implode(' → ', $partes) ?: null;
                break;
            case 3:
                $destino      = $row['lugar_recolecta_paquete'];
                $fechaEntrega = $row['fecha_entrega_personalizado'];
                break;
            case 4:
                $destino      = $row['external_location_nombre'];
                $fechaEntrega = null;
                break;
        }

        $data = [
            'id'                       => (int)$row['id'],
            'cliente'                  => $row['cliente'],
            'seller_name'              => $row['seller_name']         ?? '',
            'creador_nombre'           => $row['creador_nombre']       ?? '',
            'remu_user_nombre'         => $row['remu_user_nombre']     ?? '',
            'tipo_servicio'            => $tipoServicio,
            'estatus'                  => $row['estatus'],
            'estatus2'                 => $row['estatus2'],
            'monto'                    => (float)$row['monto'],
            'flete_total'              => (float)$row['flete_total'],
            'flete_pagado'             => (float)$row['flete_pagado'],
            'flete_pendiente'          => (float)$row['flete_pendiente'],
            'amount_paid'              => (float)($row['amount_paid'] ?? 0),
            'toggle_pago_parcial'      => $row['toggle_pago_parcial'],
            'fragil'                   => (bool)$row['fragil'],
            'comentarios'              => $row['comentarios'],
            'foto_url'                 => $fotoUrl,
            'reenvios'                 => (int)$row['reenvios'],
            'destino'                  => $destino,
            'ubicacion'                => $ubicacion,
            'fecha_entrega'            => $fechaEntrega,
            'fecha_ingreso'            => $row['fecha_ingreso'],
            'fecha_pack_entregado'     => $row['fecha_pack_entregado'],
            'pago_cuenta_nombre'       => $row['pago_cuenta_nombre']  ?? '',
            'metodo_remu'              => $row['metodo_remu'],
            'fecha_remu'               => $row['fecha_remu'],
            'cliente_pago_directo'     => $row['cliente_pago_directo'],
            'fecha_cliente_pago'       => $row['fecha_cliente_pago'],
            'motivo_no_cobro'          => $row['motivo_no_cobro'],
            'nocobrar_pack_cancelado'  => $row['nocobrar_pack_cancelado'],
            'flete_rendido'            => (int)($row['flete_rendido'] ?? 0),
            'branch'                   => $row['branch'],
            'created_at'               => $row['created_at'],
            'updated_at'               => $row['updated_at'],
        ];

        return $this->response->setJSON([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function sellers()
    {
        $q  = trim($this->request->getGet('q') ?? '');
        $db = db_connect();

        $builder = $db->table('sellers')->select('id, seller AS name');
        if ($q !== '') {
            $builder->like('seller', $q);
        }

        $rows = $builder->orderBy('seller', 'ASC')->limit(30)->get()->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data'    => array_map(fn($r) => ['id' => (int)$r['id'], 'name' => $r['name']], $rows),
        ]);
    }

    public function packagesBySeller(int $sellerId)
    {
        $db   = db_connect();
        $rows = $db->table('packages')
            ->select('id, cliente,
                COALESCE(monto, 0)           AS monto,
                COALESCE(flete_pendiente, 0) AS flete_pendiente,
                foto, fecha_pack_entregado, fecha_ingreso')
            ->where('vendedor', (int)$sellerId)
            ->where('estatus', 'entregado')
            ->where('monto >', 0)
            ->orderBy('fecha_ingreso', 'ASC')
            ->get()->getResultArray();

        $data = array_map(function ($r) {
            return [
                'id'                  => (int)$r['id'],
                'cliente'             => $r['cliente'],
                'monto'               => (float)$r['monto'],
                'flete_pendiente'     => (float)$r['flete_pendiente'],
                'foto_url'            => !empty($r['foto']) ? base_url('upload/paquetes/' . $r['foto']) : null,
                'fecha_pack_entregado'=> $r['fecha_pack_entregado'],
                'fecha_ingreso'       => $r['fecha_ingreso'],
            ];
        }, $rows);

        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }

    public function fletesPendientes(int $sellerId)
    {
        $db   = db_connect();
        $rows = $db->table('packages')
            ->select('id, cliente, flete_pendiente, foto, estatus, fecha_ingreso, monto')
            ->where('vendedor', (int)$sellerId)
            ->where('flete_rendido', 0)
            ->where('COALESCE(flete_pendiente,0) >', 0)
            ->groupStart()
                ->where('estatus !=', 'entregado')
                ->orWhere('monto <=', 0)
            ->groupEnd()
            ->orderBy('fecha_ingreso', 'ASC')
            ->get()->getResultArray();

        $data = array_map(function ($r) {
            return [
                'id'              => (int)$r['id'],
                'cliente'         => $r['cliente'],
                'flete_pendiente' => (float)$r['flete_pendiente'],
                'foto_url'        => !empty($r['foto']) ? base_url('upload/paquetes/' . $r['foto']) : null,
                'estatus'         => $r['estatus'],
                'fecha_ingreso'   => $r['fecha_ingreso'],
            ];
        }, $rows);

        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }

    public function accounts()
    {
        $db   = db_connect();
        $rows = $db->table('accounts')
            ->select('id, name, balance, type')
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->get()->getResultArray();

        $data = array_map(fn($r) => [
            'id'      => (int)$r['id'],
            'name'    => $r['name'],
            'balance' => (float)$r['balance'],
            'type'    => $r['type'],
        ], $rows);

        return $this->response->setJSON(['success' => true, 'data' => $data]);
    }
}

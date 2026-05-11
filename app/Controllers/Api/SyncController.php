<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PermisoRolModel;
use App\Models\PackageModel;

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

            $data[] = [
                'id' => (int)$user['id'],
                'username' => $user['user_name'],
                'email' => $user['email'],
                'password_hash' => $user['user_password'],
                'role_id' => $user['role_id'],
                'branch_id' => $user['branch_id'],
                'foto' => $user['foto'],
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

        $data = array_map(function ($r) {
            return [
                'id'                         => (int)$r['id'],
                'cliente'                    => $r['cliente'],
                'vendedor_id'                => (int)$r['vendedor_id'],
                'seller_name'                => $r['seller_name'] ?? '',
                'tipo_servicio'              => $r['tipo_servicio'],
                'fecha_ingreso'              => $r['fecha_ingreso'],
                'estatus'                    => $r['estatus'],
                'estatus2'                   => $r['estatus2'],
                'monto'                      => (float)$r['monto'],
                'flete_total'                => (float)$r['flete_total'],
                'flete_pagado'               => (float)$r['flete_pagado'],
                'flete_pendiente'            => (float)$r['flete_pendiente'],
                'fragil'                     => (bool)$r['fragil'],
                'comentarios'                => $r['comentarios'],
                'foto'                       => $r['foto'],
                'reenvios'                   => (int)$r['reenvios'],
                'destino_personalizado'      => $r['destino_personalizado'],
                'puntofijo_nombre'           => $r['puntofijo_nombre'] ?? '',
                'branch'                     => $r['branch'],
                'branch_name'                => $r['branch_name'] ?? '',
                'external_location_nombre'   => $r['external_location_nombre'] ?? '',
                'fecha_pack_entregado'       => $r['fecha_pack_entregado'],
                'fecha_entrega_personalizado'=> $r['fecha_entrega_personalizado'],
                'fecha_entrega_puntofijo'    => $r['fecha_entrega_puntofijo'],
                'created_at'                 => $r['created_at'],
                'updated_at'                 => $r['updated_at'],
            ];
        }, $rows);

        return $this->response->setJSON([
            'success'  => true,
            'data'     => $data,
            'total'    => (int)$total,
            'page'     => $page,
            'per_page' => $perPage,
            'pages'    => (int)ceil($total / $perPage),
        ]);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class SesionUsuarioModel extends Model
{
    protected $table         = 'sesiones_usuario';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['user_id', 'tipo', 'ip_address', 'user_agent', 'notas'];
    protected $useTimestamps = false;

    public function getSesionesConUsuario(?int $userId = null, int $limit = 200): array
    {
        $builder = $this->db->table('sesiones_usuario s')
            ->select('s.*, u.user_name, u.email')
            ->join('users u', 'u.id = s.user_id', 'left')
            ->orderBy('s.created_at', 'DESC')
            ->limit($limit);

        if ($userId) {
            $builder->where('s.user_id', $userId);
        }

        return $builder->get()->getResultArray();
    }

    public function registrar(int $userId, string $tipo, ?string $notas = null): void
    {
        $request = service('request');
        $this->insert([
            'user_id'    => $userId,
            'tipo'       => $tipo,
            'ip_address' => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent()->getAgentString(),
            'notas'      => $notas,
        ]);
    }
}

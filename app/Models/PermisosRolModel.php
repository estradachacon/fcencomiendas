<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisosRolModel extends Model
{
    protected $table = 'permisos_rol';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_id', 'nombre_accion', 'habilitado'];

    /**
     * Obtiene una lista simple de los permisos habilitados para un rol.
     */
    public function getPermissionsForRole(int $roleId): array
    {
        $permisos = $this->select('nombre_accion')
                         ->where('role_id', $roleId)
                         ->where('habilitado', 1)
                         ->findAll();

        // Convertir el array de objetos a un array simple de strings
        return array_column($permisos, 'nombre_accion');
    }
}

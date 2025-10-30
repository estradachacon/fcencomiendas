<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['user_name', 'email', 'user_password', 'role_id'];

    /**
     * Busca un usuario por email o nombre de usuario y su rol.
     */
    public function getUserByCredentials($username)
    {
        // Asumiendo que 'username' puede ser el 'email' o un campo 'usuario' si lo tienes
        // Aquí asumiremos que el campo de login es 'email' para el ejemplo.
        return $this->select('users.*, roles.nombre as role_name')
            ->join('roles', 'roles.id = users.role_id')
            // Busca por el campo de nombre de usuario
            ->where('user_name', $username)
            // O busca por el campo de email
            ->orWhere('email', $username)
            ->first();
    }
}
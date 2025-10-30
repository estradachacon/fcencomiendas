<?php namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'id';
    
    // Campos que pueden ser llenados con el método save()
    protected $allowedFields = [
        'user_id', 
        'tipo_accion', 
        'modulo_afectado', 
        'descripcion', 
        'registro_id_afectado',
        // 'created_at' se maneja automáticamente si usas Timestamps o manualmente en el controlador
    ];

    // Usar Timestamps si quieres que CodeIgniter maneje el created_at
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // No necesitamos updated_at para logs
}
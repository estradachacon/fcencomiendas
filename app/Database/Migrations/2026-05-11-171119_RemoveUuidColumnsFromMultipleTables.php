<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveUuidColumnsFromMultipleTables extends Migration
{
    private array $tables = [
        'accounts',
        'branches',
        'cashier',
        'cashier_movements',
        'cashier_sessions',
        'content_groups',
        'content_images',
        'device_tokens',
        'external_locations',
        'notifications',
        'notifications_read',
        'packages',
        'permisos_rol',
        'reversal_requests',
        'roles',
        'routes',
        'saldo_resumen',
    ];

    public function up()
    {
        foreach ($this->tables as $table) {

            // Verificar si existe la columna
            if ($this->db->fieldExists('uuid', $table)) {

                // Intentar borrar índice unique
                try {
                    $this->db->query("
                        ALTER TABLE `{$table}`
                        DROP INDEX `idx_uuid_{$table}`
                    ");
                } catch (\Throwable $e) {
                    // Ignorar si no existe el índice
                }

                // Eliminar columna
                $this->forge->dropColumn($table, 'uuid');
            }
        }
    }

    public function down()
    {
        //
    }
}
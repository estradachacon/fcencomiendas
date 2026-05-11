<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUuidToTables extends Migration
{
    // Tablas que recibirán UUID
    private array $tables = [
        'accounts',
        'bitacora_sistema',
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
        'package_payments',
        'pagos',
        'permisos_rol',
        'reversal_requests',
        'roles',
        'routes',
        'saldo_resumen',
    ];

    public function up()
    {
        foreach ($this->tables as $table) {
            // Verificar que la tabla existe y no tiene ya el campo uuid
            if ($this->db->tableExists($table) && !$this->db->fieldExists('uuid', $table)) {
                $this->forge->addColumn($table, [
                    'uuid' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 36,
                        'null'       => true,
                        'after'      => 'id',  // lo pone justo después del id
                    ],
                ]);

                // Llenar UUIDs a registros existentes
                $this->db->query("
                    UPDATE {$table} 
                    SET uuid = UUID() 
                    WHERE uuid IS NULL
                ");

                // Ahora sí ponerlo como único y NOT NULL
                $this->db->query("
                    ALTER TABLE {$table} 
                    MODIFY uuid VARCHAR(36) NOT NULL,
                    ADD UNIQUE INDEX idx_uuid_{$table} (uuid)
                ");
            }
        }
    }

    public function down()
    {
        foreach ($this->tables as $table) {
            if ($this->db->tableExists($table) && $this->db->fieldExists('uuid', $table)) {
                $this->forge->dropColumn($table, 'uuid');
            }
        }
    }
}
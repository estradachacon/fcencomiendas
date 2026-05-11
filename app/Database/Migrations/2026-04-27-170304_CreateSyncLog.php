<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSyncLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'record_uuid' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'table_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'action' => [
                'type'       => 'ENUM',
                'constraint' => ['INSERT', 'UPDATE', 'DELETE'],
                'null'       => false,
            ],
            'payload' => [
                'type' => 'JSON',
                'null' => false,
            ],
            'synced' => [
                'type'    => 'TINYINT',
                'default' => 0,
                'null'    => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('synced'); // índice para el cron
        $this->forge->addKey('created_at'); // índice para recuperación por fecha
        $this->forge->createTable('sync_log');
    }

    public function down()
    {
        $this->forge->dropTable('sync_log', true);
    }
}
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveUuidFromBitacoraSistema extends Migration
{
    public function up()
    {
        // Eliminar índice si existe
        $this->db->query("
            ALTER TABLE bitacora_sistema
            DROP INDEX idx_uuid_bitacora_sistema
        ");

        // Eliminar columna uuid
        $this->forge->dropColumn('bitacora_sistema', 'uuid');
    }

    public function down()
    {
        // Restaurar columna uuid
        $fields = [
            'uuid' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
            ],
        ];

        $this->forge->addColumn('bitacora_sistema', $fields);

        // Restaurar índice unique
        $this->db->query("
            ALTER TABLE bitacora_sistema
            ADD UNIQUE KEY idx_uuid_bitacora_sistema (uuid)
        ");
    }
}
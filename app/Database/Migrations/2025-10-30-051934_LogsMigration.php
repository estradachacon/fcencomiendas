<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogsMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // Clave foránea al usuario que realizó la acción
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 5, // Debe coincidir con el constraint de la tabla 'users'
                'unsigned'   => true,
                'null'       => true, // Permitir nulos si es una acción del sistema (ej: tarea programada)
            ],
            // Tipo de acción: Login, Update, Delete, Create, Autorizar, Error
            'tipo_accion' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            // Módulo afectado: users, paquetes, pagos, logs, etc.
            'modulo_afectado' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            // Descripción detallada de la acción
            'descripcion' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            // ID del registro afectado (ej: ID del paquete borrado)
            'registro_id_afectado' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        
        // Relación con la tabla de usuarios
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        
        $this->forge->createTable('logs');
    }

    public function down()
    {
        $this->forge->dropTable('logs');
    }
}
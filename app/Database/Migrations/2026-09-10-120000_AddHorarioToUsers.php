<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHorarioToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'horario_inicio' => [
                'type' => 'TIME',
                'null' => true,
                'after' => 'foto',
            ],
            'horario_fin' => [
                'type' => 'TIME',
                'null' => true,
                'after' => 'horario_inicio',
            ],
            'horario_activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'horario_fin',
            ],
            'forzar_cierre' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'horario_activo',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['horario_inicio', 'horario_fin', 'horario_activo', 'forzar_cierre']);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddQrCodeToPackages extends Migration
{
    public function up()
    {
        $this->forge->addColumn('packages', [
            'qr_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'unique'     => true,
                'after'      => 'user_id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('packages', 'qr_code');
    }
}

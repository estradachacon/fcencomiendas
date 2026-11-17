<?php

namespace App\Database\Migrations;

use App\Libraries\Base62Converter;
use CodeIgniter\Database\Migration;

class QrCodeCaseSensitive extends Migration
{
    public function up()
    {
        // Base62 distingue mayúsculas; con collation *_ci '000IUR' y '000Iur' chocaban en el índice único.
        $this->db->query('ALTER TABLE packages MODIFY qr_code VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL');

        // Paquetes que quedaron sin QR porque el UPDATE falló por el choque.
        $rows = $this->db->table('packages')->select('id')->where('qr_code', null)->get()->getResultArray();
        foreach ($rows as $row) {
            $qr = str_pad(Base62Converter::encode((int) $row['id']), 6, '0', STR_PAD_LEFT);
            $this->db->table('packages')->where('id', $row['id'])->update(['qr_code' => $qr]);
        }
    }

    public function down()
    {
        $this->db->query('ALTER TABLE packages MODIFY qr_code VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL');
    }
}

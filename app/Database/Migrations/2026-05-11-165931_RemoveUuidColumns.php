<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveUuidColumns extends Migration
{
    public function up()
    {
        // pagos
        if ($this->db->fieldExists('uuid', 'pagos')) {

            try {
                $this->db->query("
                    ALTER TABLE pagos
                    DROP INDEX idx_uuid_pagos
                ");
            } catch (\Throwable $e) {
                // ignorar si no existe
            }

            $this->forge->dropColumn('pagos', 'uuid');
        }

        // package_payments
        if ($this->db->fieldExists('uuid', 'package_payments')) {

            try {
                $this->db->query("
                    ALTER TABLE package_payments
                    DROP INDEX idx_uuid_package_payments
                ");
            } catch (\Throwable $e) {
                // ignorar si no existe
            }

            $this->forge->dropColumn('package_payments', 'uuid');
        }

        // bitacora_sistema
        if ($this->db->fieldExists('uuid', 'bitacora_sistema')) {

            try {
                $this->db->query("
                    ALTER TABLE bitacora_sistema
                    DROP INDEX idx_uuid_bitacora_sistema
                ");
            } catch (\Throwable $e) {
                // ignorar si no existe
            }

            $this->forge->dropColumn('bitacora_sistema', 'uuid');
        }
    }

    public function down()
    {
        //
    }
}
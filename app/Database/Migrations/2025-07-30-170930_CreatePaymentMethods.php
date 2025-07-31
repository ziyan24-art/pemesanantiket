<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentMethods extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_bank'   => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'no_rek'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'status'      => [
                'type'           => 'ENUM',
                'constraint'     => ['aktif', 'nonaktif'],
                'default'        => 'aktif',
            ],
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('payment_methods');
    }

    public function down()
    {
        $this->forge->dropTable('payment_methods');
    }
}

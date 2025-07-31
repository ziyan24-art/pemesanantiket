<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRuteTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'rute'            => ['type' => 'VARCHAR', 'constraint' => 100],
            'jam_berangkat'   => ['type' => 'TIME'],
            'perkiraan_tiba'  => ['type' => 'TIME'],
            'nama_speedboat'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'seat_quota'      => ['type' => 'INT', 'default' => 30], // jumlah kursi
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('rute');
    }

    public function down()
    {
        $this->forge->dropTable('rute');
    }
}

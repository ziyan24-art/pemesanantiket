<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPriceToRute extends Migration
{
    public function up()
    {
        $this->forge->addColumn('rute', [
            'price' => [
                'type'       => 'INT',
                'constraint' => 11,
                'after'      => 'nama_speedboat',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rute', 'price');
    }
}

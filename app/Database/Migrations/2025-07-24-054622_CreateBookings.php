<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'user_id'      => ['type' => 'INT', 'unsigned' => true],
            'route_id'     => ['type' => 'INT', 'unsigned' => true],
            'quantity'     => ['type' => 'INT', 'default' => 1],
            'total_price'  => ['type' => 'INT'],
            'created_at'   => [
                'type' => 'DATETIME',
                'null' => true, // biarkan null, akan diisi otomatis jika model pakai timestamps
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('bookings');
    }

    public function down()
    {
        $this->forge->dropTable('bookings');
    }
}

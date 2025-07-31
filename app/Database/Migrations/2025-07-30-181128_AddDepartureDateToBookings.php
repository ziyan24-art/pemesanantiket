<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDepartureDateToBookings extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bookings', [
            'departure_date' => [
                'type'       => 'DATE',
                'null'       => true,
                'after'      => 'route_id', // taruh setelah route_id
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bookings', 'departure_date');
    }
}

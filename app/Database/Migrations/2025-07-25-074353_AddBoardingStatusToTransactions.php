<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBoardingStatusToTransactions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transactions', [
            'boarding_status' => [
                'type'       => 'ENUM',
                'constraint' => ['belum', 'naik'],
                'default'    => 'belum',
                'after'      => 'transaction_code', // opsional
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', 'boarding_status');
    }
}

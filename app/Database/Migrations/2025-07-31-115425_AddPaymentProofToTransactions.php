<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentProofToTransactions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transactions', [
            'payment_proof' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'transaction_code', // diletakkan setelah transaction_code
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', 'payment_proof');
    }
}

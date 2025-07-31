<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'auto_increment' => true],
            'booking_id'       => ['type' => 'INT', 'unsigned' => true],
            'payment_method'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'status'           => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'paid'],
                'default'    => 'pending',
            ],
            'transaction_code' => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true], // ✅ perbaikan di sini
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}

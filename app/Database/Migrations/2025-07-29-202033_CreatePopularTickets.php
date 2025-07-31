<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePopularTickets extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'route'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'price'      => ['type' => 'INT'],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('popular_tickets');
    }

    public function down()
    {
        $this->forge->dropTable('popular_tickets');
    }
}

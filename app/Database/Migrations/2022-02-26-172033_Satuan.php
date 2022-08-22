<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satuan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'satid' => [
                'type' => 'int',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'satnama' => [
                'type' => 'varchar',
                'constraint' => '50'
            ]
        ]);
        $this->forge->addKey('satid');
        $this->forge->createTable('satuan');
    }

    public function down()
    {
        $this->forge->dropTable('satuan');
    }
}

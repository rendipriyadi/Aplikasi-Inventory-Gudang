<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'katid' => [
                'type' => 'int',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'katnama' => [
                'type' => 'varchar',
                'constraint' => '50'
            ]
        ]);
        $this->forge->addKey('katid');
        $this->forge->createTable('kategori');
    }

    public function down()
    {
        $this->forge->dropTable('kategori');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'brgkode' => [
                'type' => 'char',
                'constraint' => '10',
            ],
            'brgnama' => [
                'type' => 'varchar',
                'constraint' => '100'
            ],
            'brgkatid' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'brgsatid' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'brgharga' => [
                'type' => 'double',
            ],
            'brggambar' => [
                'type' => 'varchar',
                'constraint' => 200
            ],
            'brgstok' => [
                'type' => 'int',
                'constraint' => 11
            ]
        ]);

        $this->forge->addPrimaryKey('brgkode');
        $this->forge->addForeignKey('brgkatid', 'kategori', 'katid');
        $this->forge->addForeignKey('brgsatid', 'satuan', 'satid');

        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}

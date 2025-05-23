<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MenuItemsTable extends Migration
{
public function up()
{
    $this->forge->addField([
        'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
        'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
        'description' => ['type' => 'TEXT', 'null' => true],
        'price'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        'category'    => ['type' => 'VARCHAR', 'constraint' => 50],
        'status'      => ['type' => 'TINYINT', 'default' => 1],
        'created_at'  => ['type' => 'DATETIME', 'null' => true],
        'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('menu_items');
}

    public function down()
    {
        $this->forge->dropTable('menu_items');
    }
}

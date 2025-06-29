<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=> 'INT','unsigned'=> true,'auto_increment' => true],
            'name' => ['type'=> 'VARCHAR','constraint' => 100],
            'description' => ['type' => 'TEXT','null' => true],
            'created_at' => ['type' => 'DATETIME','null' => true],
            'updated_at' => ['type' => 'DATETIME','null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories', true);
    }
}



<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageToMenuItems extends Migration
{
    public function up()
    {
        $this->forge->addColumn('menu_items', [
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'category' // optional: place it after 'category'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('menu_items', 'image');
    }

}

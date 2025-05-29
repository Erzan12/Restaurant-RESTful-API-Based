<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Main Dish', 'description' => 'Heavier meals'],
            ['name' => 'Side Dish', 'description' => 'Complements the main dish'],
            ['name' => 'Dessert', 'description' => 'Sweet course'],
            ['name' => 'Snack', 'description' => 'Light food'],
            ['name' => 'Drinks', 'description' => 'Beverages'],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}
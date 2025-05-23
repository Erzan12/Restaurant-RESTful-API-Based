<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu_items';
    protected $allowedFields = ['name', 'description', 'price', 'category', 'status'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'name', 'email', 'password'
    ];


    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created';
    protected $updatedField  = 'modified';
    protected $deletedField  = 'deleted_at';

    // Model Based Validation
    protected $validationRules      = [
        'id'            =>  'max_length[15]',
        'name'          =>  'required|is_unique[users.name]',
        'email'         =>  'required|valid_email|is_unique[users.email]',
        'password'      =>  'required|min_length[6]'
    ];
    protected $validationMessages   = [
        'name'          =>  [ 'required'  => 'The name field is required',
                              'is_unique' => 'The name must be unique'],
        'email'         =>  [ 'required'  => 'The email field is required',
                              'is_unique' => 'The email must be unique'],
        'password'      =>  [ 'required'  => 'The password field is required',
                              'min_length'=> 'The password lenght should atleast be 6 characters']    
    ];

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
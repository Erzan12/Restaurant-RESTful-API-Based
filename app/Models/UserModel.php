<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'name', 'email', 'password', 'password_field', 'modified_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created';
    protected $updatedField  = 'modified_at';
    protected $deletedField  = 'deleted_at';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    // Model Based Validation
    protected $validationRules      = [
        'id'                =>  'max_length[15]',
        'name'              =>  'required|is_unique[users.name]',
        'email'             =>  'required|valid_email|is_unique[users.email]',
        'password'          =>  'required|min_length[6]',
        'password_confirm'  =>  'required|matches[password]'
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

    protected $beforeInsert = ['hashPassword'];
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
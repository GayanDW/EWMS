<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model {

    protected $table = 'category';
    protected $primaryKey = 'Category_ID';
    protected $allowedFields = ['Item_Category', 'deleted_at'];

}

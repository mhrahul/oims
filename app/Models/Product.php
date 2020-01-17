<?php

namespace App\Models;

use App\Models\CompanyStock;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['sku', 'pname', 'unit'];

    public function companyStock()
    {
        return $this->hasMany(companyStock::class, 'pid', 'id');
    }
}

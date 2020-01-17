<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class CompanyStock extends Model
{
    protected $table = 'company_stocks';

    public function product()
    {
        return $this->belongsTo(Product::class, 'pid');
    }
}

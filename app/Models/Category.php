<?php

namespace App\Models;

use Dotenv\Repository\Adapter\GuardedWriter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Guid\Guid;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'cat_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'cat_id', 'id');
    }
}




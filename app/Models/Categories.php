<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    /**
     * Explicitly define the table name because the model name is plural.
     */
    protected $table = 'categories';

    protected $fillable = [
        'category_name',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}


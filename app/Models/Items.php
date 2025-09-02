<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Items extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'item_code',
        'item_name',
        'category_id',
        'condition_id',
        'quantity',
        'location',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class); 
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
}

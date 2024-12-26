<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'description',
        'image'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function transactionDetails(){
        return $this->hasMany(TransactionDetail::class);
    }
}

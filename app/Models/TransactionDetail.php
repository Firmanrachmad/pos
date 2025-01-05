<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaction_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'price',
        'quantity',
        'subtotal'
    ];

    public function transaction(){
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}

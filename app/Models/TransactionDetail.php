<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id',
        'product_name',
        'quantity',
        'price',
        'subtotal'
    ];

    public function transaction(){
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }
}

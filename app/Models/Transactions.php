<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_date',
        'total_amount',
        'payment_status',
        'payment_method',
        'payment',
        'change',
        'note'
    ];

    public function transactionDetails(){
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_date',
        'due_date',
        'total_amount',
        'payment_status'
    ];

    public function transactionDetails(){
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'transaction_id');
    }

    public function transactionStatusHistories(){
        return $this->hasMany(TransactionStatusHistory::class, 'transaction_id');
    }
    
}

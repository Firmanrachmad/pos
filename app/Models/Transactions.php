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
        'transaction_number',
        'due_date',
        'total_amount',
        'payment_status',
        'customer_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->transaction_number = self::generateTransactionNumber();
        });
    }

    private static function generateTransactionNumber()
    {
        $year = date('Y');
        $month = date('m');
        $lastTransaction = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest('id')
            ->first();
        $nextId = $lastTransaction ? $lastTransaction->id + 1 : 1;

        $minLength = 5;
        return "TRX{$year}{$month}" . str_pad($nextId, $minLength, '0', STR_PAD_LEFT);
    }

    public function transactionDetails(){
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'transaction_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
}

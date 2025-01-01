<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id',
        'payment_date',
        'payment_method',
        'payment',
        'change',
        'note'

    ];

    public function transaction(){
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }
}

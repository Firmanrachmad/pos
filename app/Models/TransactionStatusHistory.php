<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionStatusHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaction_status_histories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'transaction_id',
        'status_date',
        'status'
    ];

    public function transaction(){
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }

}

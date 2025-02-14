<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public function transactions(){
        return $this->hasMany(Transactions::class, 'customer_id');
    }
}

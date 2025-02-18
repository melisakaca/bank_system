<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'iban',
        'currency',
        'balance',
        'status',
        'client_id',
    ];

    
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    
    public function cards()
    {
        return $this->hasMany(Card::class, 'bank_account_id');
    }
}

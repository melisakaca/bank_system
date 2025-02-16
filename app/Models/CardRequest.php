<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'bank_account_id',
        'monthly_salary',
        'status',
        'reason',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    use HasFactory;
    protected $table = 'financial_transactions';
    protected $fillable = ['user_id', 'date', 'description', 'type', 'amount'];
}

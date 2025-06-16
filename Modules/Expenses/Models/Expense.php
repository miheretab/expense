<?php

namespace Modules\Expenses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Expense extends Model
{
    use HasUuids;

    protected $table = 'expenses';

    protected $keyType = 'string'; // UUID is string

    public $incrementing = false;

    protected $fillable = [
        'title',
        'amount',
        'category', //'food','transport','entertainment','bills','health','other'
        'expense_date',
        'notes',
        'user_id', // Assuming you have a user_id for tracking who created the expense
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    /**
     * Get the user that owns the expense.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

<?php

namespace Modules\Expenses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true; // adjust as needed for auth
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:food,health,transport,utilities,entertainment,others',
            'expense_date' => 'required|date',
            'notes' => 'nullable|string',
            // Assuming user_id is optional and can be provided for tracking
            'user_id' => 'nullable|exists:users,id', // Adjust the table name as needed
        ];
    }
}

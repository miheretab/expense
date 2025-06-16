<?php

namespace Modules\Expenses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return true; // adjust as needed for auth
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|numeric|min:0',
            'category' => 'sometimes|required|in:food,transport,utilities,entertainment,others',
            'expense_date' => 'sometimes|required|date',
            'notes' => 'nullable|string',
        ];
    }
}

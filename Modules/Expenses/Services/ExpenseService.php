<?php

namespace Modules\Expenses\Services;

use Modules\Expenses\Models\Expense;
use Illuminate\Database\Eloquent\Collection;
use Modules\Expenses\Events\ExpenseCreated;

class ExpenseService
{
    public function listExpenses(array $filters = []): Collection
    {
        $query = Expense::query();

        if (!empty($filters['category'])) {
            $query->whereIn('category', explode(",", $filters['category']));
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('expense_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('expense_date', '<=', $filters['date_to']);
        }

        return $query->orderBy('expense_date', 'desc')->get();
    }

    public function createExpense(array $data): Expense
    {
        $expense = Expense::create($data);

        // Fire the event
        \Log::info('Test listener triggered');
        event(new ExpenseCreated($expense));

        return $expense;
    }

    public function updateExpense(string $id, array $data): ?Expense
    {
        $expense = Expense::find($id);
        if (!$expense) {
            return null;
        }
        $expense->update($data);
        return $expense;
    }

    public function deleteExpense(string $id): bool
    {
        $expense = Expense::find($id);
        if (!$expense) {
            return false;
        }
        return $expense->delete();
    }

    public function findExpense(string $id): ?Expense
    {
        return Expense::find($id);
    }
}

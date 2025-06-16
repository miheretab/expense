<?php

namespace Modules\Expenses\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Expenses\Http\Requests\StoreExpenseRequest;
use Modules\Expenses\Http\Requests\UpdateExpenseRequest;
use Modules\Expenses\Http\Resources\ExpenseResource;
use Modules\Expenses\Services\ExpenseService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{
    protected ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * @group Expenses
     * Get a list of all expenses
     *
     * Optional filters:
     * @queryParam category string Filter by category. Example: food,health
     * @queryParam date_from date Filter start date. Example: 2024-01-01
     * @queryParam date_to date Filter end date. Example: 2024-12-31
     *
     * @response 200 [
     *   {
     *     "id": "uuid",
     *     "title": "Pizza",
     *     "amount": "15.00",
     *     "category": "food",
     *     ...
     *   }
     * ]
     */
    public function index(): JsonResponse
    {
        $filters = request()->only(['category', 'date_from', 'date_to']);
        $expenses = $this->expenseService->listExpenses($filters);

        return response()->json(ExpenseResource::collection($expenses), Response::HTTP_OK);
    }

    /**
     * @group Expenses
     * Create a new expense
     *
     * @bodyParam title string required Example: Pizza
     * @bodyParam amount number required Example: 25.50
     * @bodyParam category string required One of: food,health,transport,entertainment,utilities,others
     * @bodyParam expense_date date required Example: 2024-06-01
     * @bodyParam notes string optional Example: With colleagues
     *
     * @response 201 {
     *   "id": "uuid",
     *   "title": "Pizza",
     *   ...
     * }
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = $this->expenseService->createExpense($request->validated());

        return response()->json($expense, Response::HTTP_CREATED);
    }

    /**
     * @group Expenses
     * Get a specific expense by ID
     *
     * @urlParam id string required The UUID of the expense. Example: a18a8e55-7c20-4e93-a8d7-55b3b5b2a9d7
     *
     * @response 200 {
     *   "id": "a18a8e55-7c20-4e93-a8d7-55b3b5b2a9d7",
     *   "title": "Pizza",
     *   "amount": "45.00",
     *   "category": "food",
     *   "expense_date": "2024-06-15",
     *   "notes": "Dinner with family",
     *   "created_at": "2024-06-15T20:10:00",
     *   "updated_at": "2024-06-15T20:10:00"
     * }
     *
     * @response 404 {
     *   "message": "Expense not found"
     * }
     */
    public function show(string $id): JsonResponse
    {
        $expense = $this->expenseService->findExpense($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($expense, Response::HTTP_OK);
    }

    /**
     * @group Expenses
     * Update an existing expense
     *
     * @urlParam id string required The UUID of the expense. Example: a18a8e55-7c20-4e93-a8d7-55b3b5b2a9d7
     *
     * @bodyParam title string optional Example: Burger
     * @bodyParam amount number optional Example: 30.00
     * @bodyParam category string optional One of: food,transport,utilities
     * @bodyParam expense_date date optional Example: 2024-06-20
     * @bodyParam notes string optional Example: Changed location
     *
     * @response 200 {
     *   "id": "a18a8e55-7c20-4e93-a8d7-55b3b5b2a9d7",
     *   "title": "Burger",
     *   "amount": "30.00",
     *   ...
     * }
     *
     * @response 404 {
     *   "message": "Expense not found"
     * }
     */
    public function update(UpdateExpenseRequest $request, string $id): JsonResponse
    {
        $expense = $this->expenseService->updateExpense($id, $request->validated());

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($expense, Response::HTTP_OK);
    }

    /**
     * @group Expenses
     * Delete an expense
     *
     * @urlParam id string required The UUID of the expense to delete. Example: a18a8e55-7c20-4e93-a8d7-55b3b5b2a9d7
     *
     * @response 204 No content
     *
     * @response 404 {
     *   "message": "Expense not found"
     * }
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->expenseService->deleteExpense($id);

        if (!$deleted) {
            return response()->json(['message' => 'Expense not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

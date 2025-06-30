<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Expenses\Models\Expense;

class ExpensesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_expense()
    {
        $payload = [
            'title' => 'Test Expense',
            'amount' => 100.50,
            'category' => 'food',
            'expense_date' => now()->toDateString(),
            'notes' => 'Test note'
        ];

        $response = $this->postJson('/api/expenses', $payload);
        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Test Expense']);

        $this->assertDatabaseHas('expenses', ['title' => 'Test Expense']);
    }

    public function test_fetch_expense()
    {
        $getResponse = $this->getJson('/api/expenses');
        $getResponse->assertStatus(200)->assertJsonStructure([['id', 'title']]);
    }
}

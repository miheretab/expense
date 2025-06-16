<?php

namespace Modules\Expenses\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ExpenseCreatedNotification extends Notification
{
    protected $expense;

    public function __construct($expense)
    {
        $this->expense = $expense;
    }

    public function via($notifiable)
    {
        return ['database']; // Only database channel for now it can be 'mail' too
    }

    public function toDatabase($notifiable)
    {
        return [
            'expense_id' => $this->expense->id,
            'title' => $this->expense->title,
            'amount' => $this->expense->amount,
            'expense_date' => $this->expense->expense_date,
            'message' => "New expense created: {$this->expense->title}"
        ];
    }
}

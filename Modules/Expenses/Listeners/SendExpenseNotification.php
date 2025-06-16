<?php

namespace Modules\Expenses\Listeners;

use Modules\Expenses\Events\ExpenseCreated;
use Modules\Expenses\Notifications\ExpenseCreatedNotification;

class SendExpenseNotification
{
    public function handle(ExpenseCreated $event)
    {
        \Log::info('ExpenseCreated event caught!', [
            'expense_id' => $event->expense->id,
            'title' => $event->expense->title,
            'user' => $event->expense->user,
        ]);
        $user = $event->expense->user;  // assuming expense belongsTo user

        if ($user) {
            $user->notify(new ExpenseCreatedNotification($event->expense));
        }
    }
}

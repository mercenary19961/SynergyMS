<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Invoice;
use App\Notifications\InvoicePaid;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all the users for whom we have invoices
        $userIds = [
            2, 16, 17, 18, 19, 20
        ];

        foreach ($userIds as $userId) {
            $user = User::find($userId);

            if ($user) {
                // Fetch the invoices for the current user
                $invoices = Invoice::where('user_id', $userId)->take(3)->get();

                // Loop over each invoice and create a notification
                foreach ($invoices as $invoice) {
                    $user->notify(new InvoicePaid($invoice));
                }
            }
        }
    }
}

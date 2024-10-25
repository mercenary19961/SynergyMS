<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = [
            [
                'user_id' => 2,
                'amount' => 1500.75,
                'status' => 'paid',
                'due_date' => Carbon::now()->subDays(30),
            ],
            [
                'user_id' => 2,
                'amount' => 750.00,
                'status' => 'unpaid',
                'due_date' => Carbon::now()->addDays(10),
            ],
            [
                'user_id' => 2,
                'amount' => 500.00,
                'status' => 'unpaid',
                'due_date' => Carbon::now()->addDays(10),
            ],
            [
                'user_id' => 2,
                'amount' => 1000.75,
                'status' => 'unpaid',
                'due_date' => Carbon::now()->addDays(30),
            ],
            [
                'user_id' => 16,
                'amount' => 500.50,
                'status' => 'unpaid',
                'due_date' => Carbon::now()->addDays(10),
            ],
            [
                'user_id' => 17,
                'amount' => 2500.00,
                'status' => 'pending',
                'due_date' => Carbon::now()->addDays(5),
            ],
            [
                'user_id' => 18,
                'amount' => 3200.25,
                'status' => 'paid',
                'due_date' => Carbon::now()->subDays(60),
            ],
            [
                'user_id' => 19,
                'amount' => 1800.00,
                'status' => 'unpaid',
                'due_date' => Carbon::now()->addDays(15),
            ],
            [
                'user_id' => 20,
                'amount' => 1250.50,
                'status' => 'paid',
                'due_date' => Carbon::now()->subDays(10),
            ],
        ];

        foreach ($invoices as $invoiceData) {
            Invoice::create($invoiceData);
        }
    }
}

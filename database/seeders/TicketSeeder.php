<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Billing','Bug','Feature Request','General'];
        for ($i = 1; $i <= 25; $i++) {
            Ticket::create([
                'subject' => "Sample Ticket $i",
                'body' => "This is the body for ticket $i",
                'status' => 'new',
                'category' => $categories[array_rand($categories)],
                'confidence' => rand(50,100)/100,
            ]);
        }
    }
}

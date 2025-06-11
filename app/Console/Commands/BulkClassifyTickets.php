<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Jobs\ClassifyTicket;

class BulkClassifyTickets extends Command
{
    protected $signature = 'tickets:bulk-classify';
    protected $description = 'Queue classification for all unclassified tickets';

    public function handle(): int
    {
        Ticket::whereNull('category')->orWhere('status','new')->each(function($ticket){
            ClassifyTicket::dispatch($ticket);
        });
        $this->info('Jobs dispatched');
        return self::SUCCESS;
    }
}

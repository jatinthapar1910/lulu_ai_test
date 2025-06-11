<?php

namespace App\Http\Controllers;

use App\Jobs\ClassifyTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::query();
        if ($search = $request->query('search')) {
            $query->where('subject', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
        }
        return $query->orderByDesc('id')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);
        $ticket = Ticket::create($data + ['status' => 'new']);
        return $ticket;
    }

    public function classify(Ticket $ticket)
    {
        ClassifyTicket::dispatch($ticket);
        return response()->json(['queued' => true]);
    }
}

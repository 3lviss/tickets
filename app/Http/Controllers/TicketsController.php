<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketsController extends Controller
{
    public function index(Request $request): Response
    {
        $tickets = Ticket::latest('updated_at')
                 ->paginate(10);

        return Inertia::render('Tickets/Index', [
            'tickets' => $tickets,
            'search' => $request->input('search', ''),
            'status' => $request->input('status', ''),
            'priority' => $request->input('priority', ''),
        ]);
    }
}

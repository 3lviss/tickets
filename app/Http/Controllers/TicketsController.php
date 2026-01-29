<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
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

    public function create(): Response
    {
        return Inertia::render('Tickets/Create');
    }

    public function store(TicketRequest $request): RedirectResponse
    {
        Ticket::create($request->validated());

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
    }

    public function show(Ticket $ticket): Response
    {
        return Inertia::render('Tickets/Show', ['ticket' => $ticket]);
    }

    public function update(TicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $ticket->update($request->validated());

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket updated successfully!');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully!');
    }
}

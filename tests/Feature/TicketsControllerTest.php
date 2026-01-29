<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test displaying list of tickets with pagination
     */
    public function test_index_displays_paginated_tickets(): void
    {
        Ticket::factory(15)->create();

        $response = $this->get('/tickets');

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Tickets/Index')
                ->has('tickets.data', 10)
        );
    }

    /**
     * Test displaying list of tickets with search filter
     */
    public function test_index_filters_tickets_by_search(): void
    {
        Ticket::factory()->create(['title' => 'Bug in login']);
        Ticket::factory()->create(['title' => 'Feature request']);

        $response = $this->get('/tickets?search=Bug');

        $response->assertInertia(fn ($page) =>
            $page
                ->component('Tickets/Index')
                ->has('tickets.data', 1)
                ->where('tickets.data.0.title', 'Bug in login')
        );
    }

    /**
     * Test displaying a single ticket
     */
    public function test_show_displays_single_ticket(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->get("/tickets/{$ticket->id}");

        $response->assertStatus(200);
        
        $response->assertInertia(fn ($page) =>
            $page
                ->component('Tickets/Show')
                ->where('ticket.id', $ticket->id)
                ->where('ticket.title', $ticket->title)
        );
    }

    /**
     * Test creating a new ticket
     */
    public function test_store_creates_new_ticket(): void
    {
        $data = [
            'title' => 'Fix database migration',
            'description' => 'There is an issue with the latest migration',
            'status' => 'open',
            'priority' => 'high',
        ];

        $response = $this->post('/tickets', $data);

        $response->assertRedirect('/tickets');

        $this->assertDatabaseHas('tickets', [
            'title' => 'Fix database migration',
            'status' => 'open',
            'priority' => 'high',
        ]);

        $response->assertSessionHas('success', 'Ticket created successfully!');
    }

    /**
     * Test updating an existing ticket
     */
    public function test_update_modifies_ticket(): void
    {
        $ticket = Ticket::factory()->create([
            'title' => 'Original title',
            'status' => 'open',
        ]);

        $updateData = [
            'title' => 'Updated title',
            'description' => $ticket->description,
            'status' => 'in_progress',
            'priority' => $ticket->priority->value,
        ];

        $response = $this->put("/tickets/{$ticket->id}", $updateData);

        $response->assertRedirect("/tickets/{$ticket->id}");

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => 'Updated title',
            'status' => 'in_progress',
        ]);

        $response->assertSessionHas('success', 'Ticket updated successfully!');
    }

    /**
     * Test deleting a ticket
     */
    public function test_destroy_deletes_ticket(): void
    {
        $ticket = Ticket::factory()->create();

        $response = $this->delete("/tickets/{$ticket->id}");

        $response->assertRedirect('/tickets');

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);

        $response->assertSessionHas('success', 'Ticket deleted successfully!');
    }

    /**
     * Test validation: title is required when creating
     */
    public function test_store_validation_requires_title(): void
    {
        $data = [
            'title' => '',
            'description' => 'Some description',
            'status' => 'open',
            'priority' => 'medium',
        ];

        $response = $this->post('/tickets', $data);

        $response->assertSessionHasErrors('title');

        $this->assertDatabaseCount('tickets', 0);
    }

    /**
     * Test validation: invalid status value is rejected
     */
    public function test_update_validation_rejects_invalid_status(): void
    {
        $ticket = Ticket::factory()->create();

        $updateData = [
            'title' => $ticket->title,
            'description' => $ticket->description,
            'status' => 'invalid_status',
            'priority' => $ticket->priority->value,
        ];

        $response = $this->put("/tickets/{$ticket->id}", $updateData);

        $response->assertSessionHasErrors('status');
        
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => $ticket->status->value,
        ]);
    }
}

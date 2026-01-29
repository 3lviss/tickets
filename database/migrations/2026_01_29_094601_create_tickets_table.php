<?php

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', TicketStatus::cases())->default(TicketStatus::OPEN);
            $table->enum('priority', TicketPriority::cases())->default(TicketPriority::LOW);
            $table->timestamps();

            if (config('database.default') !== 'sqlite') {
                $table->fullText(['title', 'description']);
            }
            $table->index('status');
            $table->index('priority');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

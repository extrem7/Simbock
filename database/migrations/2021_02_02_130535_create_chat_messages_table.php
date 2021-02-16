<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained('chats')->cascadeOnDelete();
            $table->foreignId('volunteer_id')->nullable()->constrained('volunteers')->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();

            $table->text('text');
            $table->timestamp('created_at')->nullable();
            $table->boolean('is_viewed')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
}

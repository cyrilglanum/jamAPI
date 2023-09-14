<?php

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
        Schema::create('messenger_messages', function (Blueprint $table) {
            $table->id();
            $table->longText('body');
            $table->longText('headers');
            $table->string('queue_name');
            $table->datetime('available_at');
            $table->datetime('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messenger_messages');
    }
};

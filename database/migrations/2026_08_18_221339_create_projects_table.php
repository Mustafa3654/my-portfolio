<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            // Drives the filter chips on the work grid.
            $table->string('category')->default('apps'); // apps | commerce | tools
            $table->string('kind')->default('Web app');  // human label shown on the card

            $table->text('summary');
            $table->string('stack')->nullable();

            // live | in-use | beta | wip | private — see x-status-pill
            $table->string('status')->default('live');

            // Subdomain only. The root domain lives in config/portfolio.php,
            // so moving domains is a one-line change.
            $table->string('host')->nullable();
            $table->string('repo')->nullable();

            // Spotlight case study. Null for ordinary grid entries.
            $table->boolean('is_spotlight')->default(false);
            $table->string('tagline')->nullable();
            $table->text('problem')->nullable();
            $table->text('solution')->nullable();
            $table->json('points')->nullable();
            $table->json('tech')->nullable();
            $table->json('flow')->nullable();
            $table->boolean('media_first')->default(false);

            // Show on the hero deployment board?
            $table->boolean('on_board')->default(false);
            $table->string('board_summary')->nullable();

            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

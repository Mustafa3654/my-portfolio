<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Single row. Everything the hero, about, contact card and footer read.
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('role');
            $table->string('location')->nullable();
            $table->string('availability')->nullable();  // e.g. "Open to work & contracts"
            $table->boolean('is_available')->default(true);

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_tel')->nullable();

            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();

            $table->string('employer')->nullable();
            $table->string('root_domain')->nullable(); // project subdomains hang off this

            // Hero
            $table->text('headline')->nullable();       // one line per row
            $table->unsignedTinyInteger('accent_line')->default(0);
            $table->text('bio')->nullable();

            // About / contact
            $table->text('about')->nullable();
            $table->string('contact_heading')->nullable();
            $table->text('contact_body')->nullable();

            $table->json('stats')->nullable();          // [{label, value}]

            $table->timestamps();
        });

        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('organisation');
            $table->string('place')->nullable();
            $table->string('starts')->nullable();       // free text, e.g. "Dec 2024"
            $table->string('ends')->nullable();         // free text, e.g. "Aug 2026"
            $table->json('points')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('award');
            $table->string('organisation');
            $table->string('starts')->nullable();
            $table->string('ends')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // The "Practice" section — constraints, not proficiency bars.
        Schema::create('capabilities', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('title');
            $table->text('body');
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capabilities');
        Schema::dropIfExists('education');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('profiles');
    }
};

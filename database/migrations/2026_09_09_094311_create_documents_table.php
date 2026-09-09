<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // cv | certificate
            $table->string('type')->default('certificate');

            $table->string('title');
            $table->string('issuer')->nullable();     // awarding body / organisation
            $table->string('date_label')->nullable(); // free text, e.g. "July 2026"
            $table->string('reference')->nullable();  // credential ID, kept verifiable

            // Path on the `documents` disk, e.g. "mustafa-cv.pdf".
            $table->string('file')->nullable();

            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

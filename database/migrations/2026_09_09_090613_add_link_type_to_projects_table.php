<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // How this project's live URL is built:
            //   subdomain -> host + config('portfolio.domain')  e.g. wassili.mustafa.dev
            //   domain    -> the domain column verbatim         e.g. wassili.com
            //   none      -> not deployed, no live button
            $table->string('link_type')->default('subdomain')->after('kind');

            // Full hostname for projects that own their domain.
            $table->string('domain')->nullable()->after('host');
        });

        // Backfill: rows with a host were subdomains, the rest aren't deployed.
        DB::table('projects')->whereNull('host')->update(['link_type' => 'none']);
        DB::table('projects')->whereNotNull('host')->update(['link_type' => 'subdomain']);
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['link_type', 'domain']);
        });
    }
};

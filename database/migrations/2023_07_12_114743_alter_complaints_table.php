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
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('county_iso')->after("deleted_at")->nullable();
            $table->json('sent_to_institutions')->nullable();
            $table->json('sent_to_emails')->nullable();
            $table->dateTime('sent_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('county_iso');
            $table->dropColumn('sent_to_institutions');
            $table->dropColumn('sent_to_emails');
            $table->dropColumn('sent_at');
        });
    }
};

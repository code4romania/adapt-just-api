<?php

use Database\Seeders\LocationsDummyDataSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('county_name')->nullable();
            $table->string('city_name')->nullable();
        });

        Artisan::call('db:seed', [
            '--class' => LocationsDummyDataSeeder::class,
            '--force'     => true
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('county_name');
            $table->dropColumn('city_name');
        });
    }
};

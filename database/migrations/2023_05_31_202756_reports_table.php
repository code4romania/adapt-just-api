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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('name');
            $table->string('label');
            $table->string('email');
            $table->string('county_iso')->nullable();
            $table->string('county_name')->nullable();
            $table->string('county_label')->nullable();
            $table->string('city_name')->nullable();
            $table->string('city_label')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('size');
            $table->string('path')->nullable();
            $table->string('extension')->nullable();
            $table->string('mime')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('register_number')->nullable();
            $table->string('victim');
            $table->string('type');
            $table->string('name')->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->string('location_name')->nullable();

            $table->foreignId('location_to_id')->nullable()->constrained('locations');
            $table->string('location_to_name')->nullable();
            $table->string('location_to_type')->nullable();
            $table->json('details')->nullable();
            $table->text('reason')->nullable();
            $table->string('proof_type')->nullable();

            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('complaint_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->nullable()->constrained('complaints');
            $table->foreignId('upload_id')->nullable()->constrained('uploads');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
        Schema::dropIfExists('uploads');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('complaint_uploads');
    }
};

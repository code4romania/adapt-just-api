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
            $table->string('cnp')->after("name")->nullable();
            $table->foreignId('id_card_upload_id')->nullable()->constrained('uploads');
            $table->foreignId('signature_upload_id')->nullable()->constrained('uploads');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('cnp');
            $table->dropForeign('id_card_upload_id');
            $table->dropForeign('signature_upload_id');
        });
    }
};

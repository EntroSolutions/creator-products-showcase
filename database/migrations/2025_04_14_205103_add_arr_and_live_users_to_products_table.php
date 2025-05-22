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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('arr', 10, 2)->default(0)->after('mrr');
            $table->integer('live_users')->default(0)->after('arr');
            $table->string('website_url')->nullable()->after('live_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['arr', 'live_users', 'website_url']);
        });
    }
};

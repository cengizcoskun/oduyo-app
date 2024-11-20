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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('bank_name')->nullable();
            $table->bigInteger('merchant_id')->nullable();
            $table->string('prov_user_id')->nullable();
            $table->string('provision_password')->nullable();
            $table->bigInteger('terminal_id')->nullable();
            $table->bigInteger('store_key')->nullable();
            $table->string('pos_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_settings', function (Blueprint $table) {
            $table->dropColumn('bank_name');
            $table->dropColumn('merchant_id');
            $table->dropColumn('prov_user_id');
            $table->dropColumn('provision_password');
            $table->dropColumn('terminal_id');
            $table->dropColumn('store_key');
            $table->dropColumn('pos_url');
        });
    }
};

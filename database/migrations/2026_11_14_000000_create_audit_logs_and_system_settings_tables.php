<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * audit_logs: who did what and when (sign-ins, user creation, backups, ...), shown in
     * Admin > User & System Management > System Audit Logs.
     * system_settings: simple key/value settings (the auto-backup schedule).
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->comment('users.user_id; NULL for failed sign-ins or system actions.');
            $table->string('username', 50)->nullable();
            $table->string('action', 40)->comment('e.g. login, login_failed, logout, user_created, backup_manual, backup_auto');
            $table->text('description');
            $table->string('ip_address', 45)->nullable();
            $table->dateTime('created_at')->useCurrent();

            $table->index('created_at');
            $table->index('action');
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->string('setting_key', 60)->primary();
            $table->text('setting_value')->nullable();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('audit_logs');
    }
};

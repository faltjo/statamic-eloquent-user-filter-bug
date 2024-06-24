<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StatamicAuthTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('super')->default(false);
            $table->string('avatar')->nullable();
            $table->json('preferences')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('password')->nullable()->change();
        });

        Schema::create('role_custom_user', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->constrained('custom_users')->cascadeOnDelete();
            $table->string('role_id');
        });

        Schema::create('group_custom_user', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->constrained('custom_users')->cascadeOnDelete();
            $table->string('group_id');
        });

        Schema::create('password_activation_tokens', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down()
     {
         Schema::table('custom_users', function (Blueprint $table) {
             $table->dropColumn(['super', 'avatar', 'preferences', 'last_login']);
             $table->string('password')->nullable(false)->change();
         });

         Schema::dropIfExists('role_custom_user');
         Schema::dropIfExists('group_custom_user');

         Schema::dropIfExists('password_activation_tokens');
     }
}

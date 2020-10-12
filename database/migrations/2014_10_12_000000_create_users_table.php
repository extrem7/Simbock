<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2014_10_12_000000_create_users_table.php */
    public function up()
    {
        $types = array_keys(User::$types);
        Schema::create('users', function (Blueprint $table) use ($types) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();

            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('type', $types)->default(User::VOLUNTEER);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

            $table->string('title')->nullable();
            $table->foreignId('sector_id')->constrained();
            $table->string('description')->nullable();
            $table->foreignId('size_id')->constrained('job_company_sizes');

            $table->string('address');
            $table->string('address_2')->nullable();
            $table->foreignId('city_id')->constrained('us_cities');
            $table->char('state_id', 2);
            $table->string('zip');

            $table->string('phone')->nullable();
            $table->string('email');
            $table->json('social')->nullable();

            $table->foreign('state_id')->references('id')->on('us_states');
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_09_16_171841_create_companies_table.php */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('title')->nullable();
            $table->foreignId('sector_id')->constrained();
            $table->text('description')->nullable();
            $table->foreignId('size_id')->constrained('job_company_sizes');

            $table->string('address');
            $table->string('address_2')->nullable();
            $table->foreignId('city_id')->constrained('us_cities');
            $table->char('zip', 5);

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('social')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
}

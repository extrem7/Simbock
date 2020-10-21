<?php

use App\Models\Vacancy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_09_20_120134_create_vacancies_table.php */
    public function up()
    {
        $statuses = array_keys(Vacancy::$statuses);

        Schema::create('vacancies', function (Blueprint $table) use ($statuses) {
            $table->id();
            $table->foreignId('company_id')->constrained();

            $table->string('title');
            $table->foreignId('sector_id')->constrained('sectors');
            $table->foreignId('city_id')->constrained('us_cities');
            $table->foreignId('type_id')->constrained('job_types');
            $table->text('description');
            $table->string('excerpt');

            $table->boolean('is_relocation')->default(false);
            $table->boolean('is_remote_work')->default(false);
            $table->string('address')->nullable();

            $table->string('company_title')->nullable();
            $table->string('company_description')->nullable();

            $table->enum('status', $statuses)->default(Vacancy::DRAFT);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacancies');
    }
}

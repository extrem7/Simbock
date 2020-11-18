<?php

use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerHasLanguagesTable extends Migration
{
    /* php artisan migrate:refresh --path=/database/migrations/2020_09_23_155402_create_volunteer_has_languages_table.php */
    public function up()
    {
        $fluencies = array_keys(Language::$fluencies);
        Schema::create('volunteer_has_languages', function (Blueprint $table) use ($fluencies) {
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->enum('fluency', $fluencies);
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_has_languages');
    }
}

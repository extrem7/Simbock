<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteerHasBookmarksTable extends Migration
{
    public function up()
    {
        Schema::create('volunteer_has_bookmarks', function (Blueprint $table) {
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();
            $table->foreignId('vacancy_id')->constrained('vacancies')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('volunteer_has_bookmarks');
    }
}

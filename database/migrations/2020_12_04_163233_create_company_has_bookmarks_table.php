<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyHasBookmarksTable extends Migration
{
    public function up(): void
    {
        Schema::create('company_has_bookmarks', function (Blueprint $table) {
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('volunteer_id')->constrained('volunteers')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_has_bookmarks');
    }
}

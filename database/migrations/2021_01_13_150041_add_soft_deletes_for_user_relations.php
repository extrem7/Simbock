<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesForUserRelations extends Migration
{
    public function up(): void
    {
        Schema::table('companies', fn(Blueprint $table) => $table->softDeletes());
        Schema::table('volunteers', fn(Blueprint $table) => $table->softDeletes());
    }

    public function down(): void
    {
        Schema::table('companies', fn(Blueprint $table) => $table->dropSoftDeletes());
        Schema::table('volunteers', fn(Blueprint $table) => $table->dropSoftDeletes());
    }
}

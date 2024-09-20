<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('number')->nullable(false)->change();
        });
    }
};
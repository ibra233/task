<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industry_of_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
            ->constrained()->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('industry_id')
            ->constrained('industries')->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

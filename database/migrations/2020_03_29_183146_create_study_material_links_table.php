<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyMaterialLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_material_links', function (Blueprint $table) {
            $table->id();
            $table->string('link', 1023);
            $table->unsignedInteger('study_material_id')->index();
            $table->timestamps();

            $table->foreign('study_material_id')
                  ->references('id')
                  ->on('study_materials')
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
        Schema::dropIfExists('study_material_links');
    }
}

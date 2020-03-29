<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_materials', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedSmallInteger('study_material_type_id')->index();
            $table->unsignedTinyInteger('author_type_id')->index();
            $table->string('name', 255);
            $table->text('description');
            $table->timestamps();

            $table->foreign('study_material_type_id')
                  ->references('id')
                  ->on('study_material_types')
                  ->onDelete('cascade');

            $table->foreign('author_type_id')
                  ->references('id')
                  ->on('author_types')
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
        Schema::dropIfExists('study_materials');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyMaterialStudyMaterialCategoryPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_material_study_material_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('study_material_id')->index('study_material_id');
            $table->unsignedInteger('study_material_category_id')->index('study_material_category_id');

            $table->foreign('study_material_id', 'study_material_id')
                  ->references('id')
                  ->on('study_materials');

            $table->foreign('study_material_category_id', 'study_material_category_id')
                  ->references('id')
                  ->on('study_material_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_material_study_material_category');
    }
}

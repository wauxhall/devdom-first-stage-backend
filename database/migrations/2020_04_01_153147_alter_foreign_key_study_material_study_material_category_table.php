<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterForeignKeyStudyMaterialStudyMaterialCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('study_material_study_material_category', function (Blueprint $table) {
            $table->dropForeign('study_material_id');
            $table->dropForeign('study_material_category_id');

            $table->foreign('study_material_id', 'study_material_id')
                  ->references('id')
                  ->on('study_materials')
                  ->onDelete('cascade');

            $table->foreign('study_material_category_id', 'study_material_category_id')
                  ->references('id')
                  ->on('study_material_categories')
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
        Schema::table('study_material_study_material_category', function (Blueprint $table) {
            $table->dropForeign('study_material_id');
            $table->dropForeign('study_material_category_id');

            $table->foreign('study_material_id', 'study_material_id')
                  ->references('id')
                  ->on('study_materials');

            $table->foreign('study_material_category_id', 'study_material_category_id')
                  ->references('id')
                  ->on('study_material_categories');
        });
    }
}

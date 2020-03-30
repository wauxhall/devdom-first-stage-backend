<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyMaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");

        DB::table('study_material_categories')->truncate();

        DB::table('study_material_categories')->insert([
            [ 'name' => 'Алгоритмы', 'parent_id' => null ],
            [ 'name' => 'Sql',       'parent_id' => null ],
            [ 'name' => 'Mysql',     'parent_id' => 2 ]
        ]);
    }
}

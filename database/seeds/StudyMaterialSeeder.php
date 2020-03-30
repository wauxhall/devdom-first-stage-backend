<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StudyMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");

        DB::table('study_material_links')->truncate();
        DB::table('study_materials')->truncate();
        DB::table('study_material_types')->truncate();
        DB::table('author_types')->truncate();
        DB::table('study_material_study_material_category')->truncate();

        DB::table('study_material_types')->insert([
            [ 'name' => 'Статья',   'code' => 'article' ],
            [ 'name' => 'Видео',    'code' => 'video' ],
            [ 'name' => 'Документ', 'code' => 'doc' ],
            [ 'name' => 'Прочее',   'code' => 'other' ]
        ]);

        DB::table('author_types')->insert([
            [ 'name' => 'Свое',      'code' => 'personal' ],
            [ 'name' => 'Стороннее', 'code' => 'foreign' ]
        ]);

        DB::table('study_materials')->insert([
            [
                'study_material_type_id' => '1',
                'author_type_id' => '2',
                'name' => 'Все о представлениях, временных таблицах и CTE',
                'description' => 'Обзор, различия, преимущества (на примере СУБД MySQL)'
            ],
            [
                'study_material_type_id' => '2',
                'author_type_id' => '2',
                'name' => 'Годный видеоурок по алгоритмам',
                'description' => 'Обзор подходов к разработке алгоритмов'
            ],
            [
                'study_material_type_id' => '3',
                'author_type_id' => '2',
                'name' => 'Книги по SQL',
                'description' => '2 книги: для начинающих и для профи'
            ]
        ]);

        DB::table('study_material_links')->insert([
            [
                'link' => 'https://vk.com/dima_dio1997?z=article_edit27630996_42419',
                'study_material_id' => '1'
            ],
            [
                'link' => 'https://www.youtube.com/watch?v=CB9bS46vl04',
                'study_material_id' => '2'
            ],
            [
                'link' => 'https://vk.com/doc27630996_523099802',
                'study_material_id' => '3'
            ],
            [
                'link' => 'https://vk.com/doc27630996_523099763',
                'study_material_id' => '3'
            ]
        ]);

        DB::table('study_material_study_material_category')->insert([
            [ 'study_material_id' => 1, 'study_material_category_id' => 2 ],
            [ 'study_material_id' => 1, 'study_material_category_id' => 3 ],
            [ 'study_material_id' => 2, 'study_material_category_id' => 1 ],
            [ 'study_material_id' => 3, 'study_material_category_id' => 2 ]
        ]);
    }
}

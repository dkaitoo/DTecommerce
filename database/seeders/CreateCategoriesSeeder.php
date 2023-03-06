<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = [
            [
                'name' => 'Thể loại 1',
                'slug' => 'the-loai-1',
                'description' => 'Mô tả 1',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 1',
                'meta_description' => 'meta_description1',
                'meta_keywords' => 'hashtag,hashtag1',
            ],
            [
                'name' => 'Thể loại 2',
                'slug' => 'the-loai-2',
                'description' => 'Mô tả 2',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 2',
                'meta_description' => 'meta_description2',
                'meta_keywords' => 'hashtag,hashtag2',
            ],
            [
                'name' => 'Thể loại 3',
                'slug' => 'the-loai-3',
                'description' => 'Mô tả 3',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 3',
                'meta_description' => 'meta_description3',
                'meta_keywords' => 'hashtag,hashtag3',
            ],
            [
                'name' => 'Thể loại 4',
                'slug' => 'the-loai-4',
                'description' => 'Mô tả 4',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 4',
                'meta_description' => 'meta_description4',
                'meta_keywords' => 'hashtag,hashtag4',
            ],
            [
                'name' => 'Thể loại 5',
                'slug' => 'the-loai-5',
                'description' => 'Mô tả 5',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 5',
                'meta_description' => 'meta_description5',
                'meta_keywords' => 'hashtag,hashtag5',
            ],
            [
                'name' => 'Thể loại 6',
                'slug' => 'the-loai-6',
                'description' => 'Mô tả 6',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 6',
                'meta_description' => 'meta_description6',
                'meta_keywords' => 'hashtag,hashtag6',
            ],
            [
                'name' => 'Thể loại 7',
                'slug' => 'the-loai-7',
                'description' => 'Mô tả 7',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 7',
                'meta_description' => 'meta_description7',
                'meta_keywords' => 'hashtag,hashtag7',
            ],
            [
                'name' => 'Thể loại 8',
                'slug' => 'the-loai-8',
                'description' => 'Mô tả 8',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 8',
                'meta_description' => 'meta_description8',
                'meta_keywords' => 'hashtag,hashtag8',
            ],
            [
                'name' => 'Thể loại 9',
                'slug' => 'the-loai-9',
                'description' => 'Mô tả 9',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 9',
                'meta_description' => 'meta_description9',
                'meta_keywords' => 'hashtag,hashtag9',
            ],
            [
                'name' => 'Thể loại 10',
                'slug' => 'the-loai-10',
                'description' => 'Mô tả 10',
                'status' => 0,
                'popular' => 0,
                'meta_title'=>'meta_title 10',
                'meta_description' => 'meta_description10',
                'meta_keywords' => 'hashtag,hashtag10',
            ],

        ];

        foreach ($categories as $key => $category) {
            Category::create($category);
        }

    }
}

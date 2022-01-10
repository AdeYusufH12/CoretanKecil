<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Rekomendasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Post 1
        $post = Post::create([
            'id_kategori' => '1',
            'id_user' => 1,
            'sampul' => 'post1.jpg',
            'judul' => 'Post Pertama',
            'konten' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis autem a temporibus quidem, repudiandae quam ducimus. Eum commodi voluptatibus rerum rem aperiam consequatur, harum, aut ipsum quidem dicta at?',
            'slug' => Str::slug('Post Pertama'),
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 1
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 2
        ]);

        Rekomendasi::create([
            'id_post' => $post->id
        ]);

        // Post 2
        $post = Post::create([
            'id_kategori' => '2',
            'id_user' => 2,
            'sampul' => 'post2.jpg',
            'judul' => 'Post Kedua',
            'konten' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis autem a temporibus quidem, repudiandae quam ducimus. Eum commodi voluptatibus rerum rem aperiam consequatur, harum, aut ipsum quidem dicta at?',
            'slug' => Str::slug('Post Kedua'),
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 2
        ]);

        Rekomendasi::create([
            'id_post' => $post->id
        ]);

        // Post 3
        $post = Post::create([
            'id_kategori' => '3',
            'id_user' => 2,
            'sampul' => 'post3.jpg',
            'judul' => 'Post Ketiga',
            'konten' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis autem a temporibus quidem, repudiandae quam ducimus. Eum commodi voluptatibus rerum rem aperiam consequatur, harum, aut ipsum quidem dicta at?',
            'slug' => Str::slug('Post Ketiga'),
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 3
        ]);

        // Post 4
        $post = Post::create([
            'id_kategori' => '2',
            'id_user' => 1,
            'sampul' => 'post4.jpg',
            'judul' => 'Post Keempat',
            'konten' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis autem a temporibus quidem, repudiandae quam ducimus. Eum commodi voluptatibus rerum rem aperiam consequatur, harum, aut ipsum quidem dicta at?',
            'slug' => Str::slug('Post Keempat'),
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 1
        ]);
    }
}

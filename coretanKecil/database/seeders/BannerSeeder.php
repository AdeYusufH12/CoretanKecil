<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Banner 1
        Banner::create([
            'sampul' => 'banner1.jpg',
            'judul' => 'Banner Pertama',
            'konten' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis autem a temporibus quidem, repudiandae quam ducimus. Eum commodi voluptatibus rerum rem aperiam consequatur, harum, aut ipsum quidem dicta at?',
            'slug' => Str::slug('Banner Pertama')
        ]);

        // Banner 2
        Banner::create([
            'sampul' => 'banner2.jpg',
            'judul' => 'Banner Kedua',
            'konten' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis autem a temporibus quidem, repudiandae quam ducimus. Eum commodi voluptatibus rerum rem aperiam consequatur, harum, aut ipsum quidem dicta at?',
            'slug' => Str::slug('Banner Kedua')
        ]);
    }
}

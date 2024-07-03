<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'logo' => 'logo.png',
            'fav_icon' => 'fav_icon.jpg',
            'title' => "WAsSh",
            'description' => 'this is desc',
            'keywords' => 'keywords man',
            'email' => 'ahmed@wassh.com',
            'phone' => '01029287271',
        ];

        setting($settings)->save();
    }
}

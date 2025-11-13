<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Emre Şahin',
                'role' => 'Full Stack Developer',
                'avatar' => 'https://your-portfolio.com/images/avatar.jpg',
                'bio' => [
                    'tr' => 'Laravel ve modern web teknolojileriyle API geliştiren bir yazılım geliştiricisiyim.',
                    'en' => 'I am a software developer building APIs with Laravel and modern web technologies.'
                ],
                'skills' => [
                    'Laravel',
                    'React',
                    'TailwindCSS',
                    'Sanctum',
                    'Spatie'
                ]
            ]
        );
    }
}

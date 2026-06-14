<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Category, Post, User};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'bio' => 'Administrator of Professional Blog',
            ]
        );

        // Create author user
        $author = User::firstOrCreate(
            ['email' => 'author@example.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password'),
                'role' => 'author',
                'bio' => 'Professional blogger and content creator',
            ]
        );

        // Create categories
        $categories = [
            ['name' => 'Technology', 'description' => 'Latest technology trends and updates'],
            ['name' => 'Business', 'description' => 'Business insights and strategies'],
            ['name' => 'Lifestyle', 'description' => 'Tips for a better lifestyle'],
            ['name' => 'Programming', 'description' => 'Programming tutorials and tips'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }

        // Create sample posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel 11',
                'excerpt' => 'Learn the basics of Laravel 11 and start building amazing web applications.',
                'content' => '<p>Laravel 11 brings exciting new features and improvements...</p>',
                'category_id' => 1,
                'author_id' => $author->id,
                'featured' => true,
                'reading_time' => 5,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Mastering Filament for Admin Panels',
                'excerpt' => 'Build powerful admin panels with Filament 3 in minimal time.',
                'content' => '<p>Filament is a collection of beautiful full-stack components...</p>',
                'category_id' => 4,
                'author_id' => $author->id,
                'featured' => true,
                'reading_time' => 8,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Real-time Components with Livewire 3',
                'excerpt' => 'Create interactive UIs without writing JavaScript with Livewire 3.',
                'content' => '<p>Livewire 3 is a full-stack framework for building dynamic interfaces...</p>',
                'category_id' => 4,
                'author_id' => $author->id,
                'featured' => true,
                'reading_time' => 6,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'The Future of Web Design',
                'excerpt' => 'Exploring upcoming trends in web design and user experience.',
                'content' => '<p>Web design is constantly evolving with new technologies and approaches...</p>',
                'category_id' => 1,
                'author_id' => $author->id,
                'featured' => false,
                'reading_time' => 7,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Business Growth Strategies for 2024',
                'excerpt' => 'Proven strategies to grow your business in the current market.',
                'content' => '<p>Growing a business requires careful planning and execution...</p>',
                'category_id' => 2,
                'author_id' => $author->id,
                'featured' => false,
                'reading_time' => 10,
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($posts as $post) {
            Post::firstOrCreate(
                ['title' => $post['title']],
                $post
            );
        }

        $this->command->info('Database seeded successfully!');
    }
}

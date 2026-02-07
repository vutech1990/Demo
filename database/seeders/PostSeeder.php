<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => 'Bài viết đầu tiên',
            'content' => 'Xin chào! Đây là bài viết mẫu đầu tiên được tạo bởi Seeder.',
        ]);

        Post::create([
            'title' => 'Hướng dẫn học Laravel',
            'content' => 'Laravel là một PHP Framework rất mạnh mẽ và dễ học.',
        ]);

        Post::create([
            'title' => 'Antigravity AI',
            'content' => 'Trợ lý AI giúp bạn lập trình nhanh hơn, hiệu quả hơn.',
        ]);
    }
}
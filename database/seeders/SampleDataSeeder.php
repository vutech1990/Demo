<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo một số Tag mẫu
        $tagsData = [
            ['name' => 'Laravel', 'color' => 'rose'],
            ['name' => 'PHP', 'color' => 'blue'],
            ['name' => 'Web Design', 'color' => 'indigo'],
            ['name' => 'Tips', 'color' => 'amber'],
            ['name' => 'UI/UX', 'color' => 'violet'],
            ['name' => 'Tutorial', 'color' => 'emerald'],
        ];

        foreach ($tagsData as $t) {
            Tag::firstOrCreate(['name' => $t['name']], ['color' => $t['color']]);
        }

        $allTags = Tag::all();

        // 2. Gán Tag và Ảnh mẫu cho tất cả bài viết hiện có
        $posts = Post::all();
        foreach ($posts as $post) {
            // Gán ngẫu nhiên 1-3 tag cho mỗi bài
            $randomTags = $allTags->random(rand(1, 3))->pluck('id')->toArray();
            $post->tags()->sync($randomTags);

            // Gán ảnh đại diện mẫu nếu chưa có
            if (!$post->thumbnail) {
                // Sử dụng ảnh ngẫu nhiên từ Picsum với ID của bài viết
                $post->thumbnail = "https://picsum.photos/seed/post-" . $post->id . "/800/450";
                $post->save();
            }
        }
    }
}
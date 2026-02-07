<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Đảm bảo có ít nhất một User để gán bài viết
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin Test',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // 2. Tạo một số Tag mẫu
        $tagsData = [
            ['name' => 'Laravel', 'color' => 'rose'],
            ['name' => 'PHP', 'color' => 'blue'],
            ['name' => 'Web Design', 'color' => 'indigo'],
            ['name' => 'Tips', 'color' => 'amber'],
            ['name' => 'UI/UX', 'color' => 'violet'],
            ['name' => 'Tutorial', 'color' => 'emerald'],
            ['name' => 'Javascript', 'color' => 'yellow'],
            ['name' => 'Tailwind CSS', 'color' => 'cyan'],
        ];

        foreach ($tagsData as $t) {
            Tag::firstOrCreate(['name' => $t['name']], ['color' => $t['color']]);
        }

        $allTags = Tag::all();

        // 3. Danh sách các mẫu bài viết chuyên nghiệp
        $samplePosts = [
            [
                'title' => 'Lộ trình học Laravel từ Newbie đến Master năm 2026',
                'content' => 'Laravel là một trong những PHP framework phổ biến nhất hiện nay. Để làm chủ nó, bạn cần hiểu rõ về MVC, Eloquent ORM và Middleware...',
            ],
            [
                'title' => '10 mẹo tối ưu hiệu suất cho ứng dụng web của bạn',
                'content' => 'Hiệu suất là yếu tố sống còn của mọi trang web. Hãy thử sử dụng Caching, Optimize Image và Minify CSS/JS ngay hôm nay...',
            ],
            [
                'title' => 'Tại sao Tailwind CSS đang thống trị thế giới Front-end?',
                'content' => 'Tailwind mang lại khả năng tùy biến cực cao mà không cần viết quá nhiều CSS thuần. Đó chính là lý do nó được các Developer yêu thích...',
            ],
            [
                'title' => 'Bí quyết thiết kế UI/UX cho người mới bắt đầu',
                'content' => 'Giao diện bắt mắt thôi là chưa đủ, trải nghiệm người dùng mới là thứ giữ chân họ lại lâu hơn trên trang web của bạn...',
            ],
            [
                'title' => 'Cập nhật những tính năng mới nhất trong PHP 8.4',
                'content' => 'PHP 8.4 mang đến nhiều cải tiến về hiệu năng và cú pháp ngắn gọn hơn. Hãy cùng khám phá Property Hooks và các hàm mới...',
            ],
            [
                'title' => 'Cách xây dựng hệ thống Live Search bằng AJAX và Laravel',
                'content' => 'Tìm kiếm trực tiếp giúp người dùng thấy kết quả ngay khi đang gõ. Đây là một trải nghiệm tuyệt vời mà bạn nên áp dụng...',
            ],
            [
                'title' => 'Tương lai của trí tuệ nhân tạo trong lập trình web',
                'content' => 'AI đang thay đổi cách chúng ta viết code. Từ việc gợi ý mã nguồn đến tự động kiểm tra lỗi, AI là trợ thủ đắc lực...',
            ],
            [
                'title' => 'Hướng dẫn cấu hình CI/CD cho dự án Laravel trên VPS',
                'content' => 'Tự động hóa quy trình deploy giúp giảm thiểu sai sót và tiết kiệm thời gian cho nhóm phát triển của bạn...',
            ],
            [
                'title' => 'Sự khác biệt giữa SQL và NoSQL: Khi nào nên dùng loại nào?',
                'content' => 'Tùy vào cấu trúc dữ liệu và khả năng mở rộng mà bạn nên chọn MySQL, PostgreSQL hay MongoDB cho dự án của mình...',
            ],
            [
                'title' => 'Top 5 thư viện Javascript đáng dùng nhất năm 2026',
                'content' => 'Ngoài React và Vue, các thư viện như Alpine.js hay Svelte đang ngày càng khẳng định vị thế của mình nhờ sự gọn nhẹ...',
            ],
            [
                'title' => 'Cách quản lý State hiệu quả trong ứng dụng lớn',
                'content' => 'Khi ứng dụng phình to, việc quản lý dữ liệu giữa các component trở nên phức tạp. Pinia hay Redux sẽ giúp bạn giải quyết việc này...',
            ],
            [
                'title' => 'Bảo mật ứng dụng Laravel: Những điều bạn không thể bỏ qua',
                'content' => 'Đừng để ứng dụng của bạn dễ dàng bị tấn công SQL Injection hay XSS. Hãy sử dụng các công cụ bảo mật có sẵn của Laravel...',
            ],
        ];

        // 4. Tạo thêm bài viết nếu hiện tại có quá ít
        foreach ($samplePosts as $postData) {
            $post = Post::create([
                'title' => $postData['title'],
                'content' => $postData['content'] . ' Đây là bài viết mẫu được tạo tự động nhằm minh họa cho giao diện blog chuyên nghiệp của bạn. Nội dung này sẽ giúp bạn hình dung rõ hơn về cách các thành phần như ảnh, tag và phân trang hiển thị.',
                'user_id' => $user->id,
            ]);

            // Gán ngẫu nhiên 1-3 tag
            $randomTags = $allTags->random(rand(2, 3))->pluck('id')->toArray();
            $post->tags()->sync($randomTags);

            // Gán ảnh đại diện chuyên nghiệp từ Picsum (mỗi bài một ảnh khác nhau dựa trên ID)
            $post->thumbnail = "https://picsum.photos/seed/post-" . $post->id . "/800/450";
            $post->save();
        }

        // 5. Cập nhật các bài viết cũ (nếu có) chưa có ảnh/tag
        Post::whereNull('thumbnail')->get()->each(function ($post) use ($allTags) {
            if ($post->tags->count() == 0) {
                $post->tags()->sync($allTags->random(rand(1, 2))->pluck('id')->toArray());
            }
            $post->thumbnail = "https://picsum.photos/seed/post-" . $post->id . "/800/450";
            $post->save();
        });
    }
}
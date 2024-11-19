<?php

namespace App\Http\Livewire\Posts;

use App\Models\Media;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Stevebauman\Location\Facades\Location;
use GuzzleHttp\Client;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $body;
    public $file;
    public $filePreview = null; // Thêm thuộc tính xem trước file
    public $location;
    public $linkPreview = null;

    public $imageFormats = ['jpg', 'png', 'gif', 'jpeg'];
    public $videoFormats = ['mp4', '3gp'];

    public function mount()
    {
        $ipAddress = $this->getIp();
        $position = Location::get($ipAddress);

        if ($position) {
            $this->location = $position->cityName . '/' . $position->regionCode;
        } else {
            $this->location = null;
        }
    }

    public function updatedBody()
    {
        $this->detectLink();
    }

    public function updatedFile()
    {
        // Kiểm tra xem file có phải hình ảnh không
        if ($this->file && $this->file->getMimeType()) {
            $this->filePreview = $this->file->temporaryUrl(); // Tạo URL tạm thời cho xem trước
        } else {
            $this->filePreview = null;
        }
    }

    public function detectLink()
    {
        $urlPattern = '/(https?:\/\/[^\s]+)/';
        preg_match($urlPattern, $this->body, $matches);

        if (isset($matches[0])) {
            $this->linkPreview = $this->fetchLinkPreview($matches[0]);
        } else {
            $this->linkPreview = null;
        }
    }

    public function fetchLinkPreview($url)
    {
        $client = new Client();
        try {
            $response = $client->get($url);
            $html = (string) $response->getBody();

            preg_match('/<title>(.*?)<\/title>/', $html, $title);
            preg_match('/<meta name="description" content="(.*?)"/', $html, $description);

            return [
                'title' => $title[1] ?? 'Không có tiêu đề',
                'description' => $description[1] ?? 'Không có mô tả',
                'url' => $url
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function submit()
    {
        $data = $this->validate([
            'title' => 'required|max:500',
            'location' => 'nullable|string|max:600',
            'body' => 'required|max:10000',
            'file' => 'nullable|mimes:' . implode(',', array_merge($this->imageFormats, $this->videoFormats)) . '|max:2048',
        ]);
    
        // Chuyển đổi liên kết thành thẻ <a>
        $data['body'] = $this->convertLinksToAnchors($data['body']);
    
        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'location' => $data['location'],
            'body' => $data['body'],
        ]);
    
        $this->storeFiles($post);
    
        session()->flash('success', 'Bài viết đang chờ duyệt !!!!');
        return redirect('home');
    }
    
    private function convertLinksToAnchors($text)
    {
        $urlPattern = '/(https?:\/\/[^\s]+)/';
        return preg_replace($urlPattern, '<a href="$1" target="_blank" class="text-blue-500 underline">$1</a>', $text);
    }
    
    public function render()
    {
        return view('livewire.posts.create');
    }

    private function storeFiles($post)
    {
        if (empty($this->file)) {
            return true;
        }

        $path = $this->file->store('post-photos', 'public');
        $isImage = preg_match('/^.*\.(png|jpg|gif)$/i', $path);

        Media::create([
            'post_id' => $post->id,
            'path' => $path,
            'is_image' => $isImage,
        ]);
    }

    private function getIp(): ?string
    {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip();
    }
}

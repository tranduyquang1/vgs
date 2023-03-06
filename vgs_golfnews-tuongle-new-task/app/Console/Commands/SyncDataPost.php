<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use JsonMachine\Items;

class SyncDataPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncData:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync post data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try {
            $this->info('The sync data category has been proceed successfully.');
            $postData = Items::fromFile(public_path('sync-data/posts.json'));
            $postModel = new Post();
            $categoryModel = new Category();
            foreach ($postData as $post) {
                $created_at = isset($post->created_at) ? (array)$post->created_at : [];
                $updated_at = isset($post->updated_at) ? (array)$post->updated_at : [];
                $published_at = isset($post->published_at) ? (array)$post->published_at : [];
                $published_at_display = isset($post->published_at_display) ? (array)$post->published_at_display : [];
                $categoryOld = isset($post->multi_categories) ? (array)$post->multi_categories[0] : [];
                $categoryObject = $categoryModel->where('id_old', @$categoryOld['$oid'])->first();
                $categoryId = $categoryObject ? $categoryObject->id : null;
                $data = [
                    'title' => @$post->title,
                    'excerpt' => @$post->excerpt,
                    'content' => @$post->content,
                    'format' => @$post->post_format,
                    'thumbnail' => @$post->thumbnail ?? '',
                    'status' => @$post->status,
                    'meta_title' => @$post->title,
                    'meta_description' => @$post->title,
                    'meta_keyword' => null,
                    'is_hot_news' => (int)@$post->is_on_hot_news,
                    'published_at' => !empty(@$published_at['$date']) ? Carbon::parse($published_at['$date'])->format('Y-m-d H:i:s') : null,
                    'published_at_display' => !empty(@$published_at_display['$date']) ? Carbon::parse($published_at_display['$date'])->format('Y-m-d H:i:s') : null,
                    'category_id' => $categoryId,
                    'youtube_url' => @$post->youtube_url,
                    'created_at' => !empty(@$created_at['$date']) ? Carbon::parse($created_at['$date'])->format('Y-m-d H:i:s') : null,
                    'updated_at' => !empty(@$updated_at['$date']) ? Carbon::parse($updated_at['$date'])->format('Y-m-d H:i:s') : null,
                    'slug' => @$post->slug
                ];
                $postModel->create($data);
            }
        } catch (\Exception $e) {
            $this->error('The sync data category has been failed -' . $e->getMessage());
        }
    }
}

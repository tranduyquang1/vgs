<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;
use JsonMachine\Items;

class SyncPostSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncData:postSlug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync post slug';

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
            $this->info('The sync data has been proceed successfully.');
            $postData = Items::fromFile(public_path('sync-data/posts.json'));
            foreach ($postData as $post) {
                $title = $post->title;
                $slug = $post->slug;
                $status = $post->status;

                if ($status == 'published') {
                    $dbPost = Post::where('status', 'published')->where('title', $title)->first();
                    $dbPost->slug = $slug;
                    $dbPost->save();
                }
            }
        } catch (\Exception $e) {
            $this->error('The sync data has been failed -' . $e->getMessage());
        }
    }
}

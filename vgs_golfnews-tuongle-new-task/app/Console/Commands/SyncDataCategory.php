<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class SyncDataCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncData:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync category data';

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
            $categoryJson = file_get_contents(public_path('sync-data/categories.json'));
            $categoryData = json_decode($categoryJson, true);
            $categoryModel = new Category();
            foreach ($categoryData as $cate) {
                $parent = 1;
                if (isset($cate['parent']['$oid']) && !empty($cate['parent']['$oid'])) {
                    $categoryObject = $categoryModel->where('id_old', $cate['parent']['$oid'])->first();
                    $parent = $categoryObject ? $categoryObject->id : null;
                }
                $data = [
                    'name' => $cate['title'],
                    'status' => 1,
                    'parent_id' => $parent,
                    'meta_title' => $cate['title'],
                    'meta_description' => $cate['title'],
                    'meta_keyword' => null,
                    'id_old' => $cate['_id']['$oid'],
                ];
                $categoryModel->storeItem($data);
            }
        } catch (\Exception $e) {
            $this->error('The sync data category has been failed -'. $e->getMessage());
        }
    }
}

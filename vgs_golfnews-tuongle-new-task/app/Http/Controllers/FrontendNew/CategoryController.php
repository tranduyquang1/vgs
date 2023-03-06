<?php

namespace App\Http\Controllers\FrontendNew;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;

class CategoryController extends Controller
{
    private $pathViewController = 'frontend-new.pages.category.';
    private $controllerName = 'category';

    public function __construct()
    {
        $this->agent = new Agent();
        view()->share('controllerName', $this->controllerName);
    }

    public function detail(Request $request)
    {
        $keyCache = 'frontend.category.detail.';
        $timeCache = 120;

        $bannerItems = $this->getBanners();

//        $category = Category::descendantsAndSelf($request->id)->toTree()->first();
        $id = $request->id;
        $category = Cache::remember("{$keyCache}{$id}", $timeCache, function () use ($id) {
            return Category::find($id);
        });
        $categories = $category->descendants()->pluck('id');
        $categories[] = $category->getKey();

//        $sliderPosts = Post::with('category')->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        $sliderPosts = Cache::remember("{$keyCache}{$id}sliderPosts", $timeCache, function () use ($categories) {
            return Post::with('category')->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        });

//        $latestPosts = Post::with('category')->published()->latest('published_at_display')->take(4)->get();
//        $mostReadPosts = Post::with('category')->published()->mostRead()->latest('published_at_display')->take(3)->get();
        $latestPosts = Cache::remember("frontend.latestPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->notSlider()->notHotNews()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend.mostReadPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->mostRead()->take(3)->get();
        });

        $items = Post::with('category')->whereIn('category_id', $categories)->whereNotIn('id', $sliderPosts->pluck('id'))->published()->latest('published_at_display')->paginate(6);
        $itemsChunk = $items->chunk(4);
        return view("{$this->pathViewController}detail", compact('sliderPosts', 'items', 'itemsChunk', 'category', 'mostReadPosts', 'latestPosts', 'bannerItems'));
    }

    public function getBanners()
    {
        $bannerModel = new Banner();
        $bannerItems = [];
        if ($this->agent->isMobile()) {
            $bannersMobile = $bannerModel->active()->category()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2', 'mobile_emagazine_3', 'mobile_emagazine_4'])->get()->groupBy('type');

            // Banner Emagazine 1
            $bannerE1 = @$bannersMobile['mobile_emagazine_1'] ?? collect([]);
            $keyE1 = $bannerE1->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyE1 = ($keyE1 === false || !@$bannerE1[$keyE1 + 1]) ? 0 : ++$keyE1;

            // Banner Emagazine 2
            $bannerE2 = @$bannersMobile['mobile_emagazine_2'] ?? collect([]);
            $keyE2 = $bannerE2->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyE2 = ($keyE2 === false || !@$bannerE2[$keyE2 + 1]) ? 0 : ++$keyE2;

            // Banner Emagazine 3
            $bannerE3 = @$bannersMobile['mobile_emagazine_3'] ?? collect([]);
            $keyE3 = $bannerE3->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyE3 = ($keyE3 === false || !@$bannerE3[$keyE3 + 1]) ? 0 : ++$keyE3;

            // Banner Emagazine 4
            $bannerE4 = @$bannersMobile['mobile_emagazine_4'] ?? collect([]);
            $keyE4 = $bannerE4->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyE4 = ($keyE4 === false || !@$bannerE4[$keyE4 + 1]) ? 0 : ++$keyE4;

            $bannerModel->category()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2', 'mobile_emagazine_3', 'mobile_emagazine_4'])->update(['last_viewed_at' => null]);

            if (@$bannerE1[$keyE1]) {
                $item = $bannerE1[$keyE1];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['mobile_emagazine_1'] = $item;
            }

            if (@$bannerE2[$keyE2]) {
                $item = $bannerE2[$keyE2];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['mobile_emagazine_2'] = $item;
            }

            if (@$bannerE3[$keyE3]) {
                $item = $bannerE3[$keyE3];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['mobile_emagazine_3'] = $item;
            }

            if (@$bannerE4[$keyE4]) {
                $item = $bannerE4[$keyE4];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['mobile_emagazine_4'] = $item;
            }
        } else {
            $banners = $bannerModel->select()->active()->category()->notMobile()->get()->groupBy('position');
            // Banner Center 01
            $bannerCenter01 = @$banners['center1'] ?? collect([]);
            $keyCenter01 = $bannerCenter01->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyCenter01 = ($keyCenter01 === false || !@$bannerCenter01[$keyCenter01 + 1]) ? 0 : ++$keyCenter01;

            // Banner Center 02
            $bannerCenter02 = @$banners['center2'] ?? collect([]);
            $keyCenter02 = $bannerCenter02->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyCenter02 = ($keyCenter02 === false || !@$bannerCenter02[$keyCenter02 + 1]) ? 0 : ++$keyCenter02;

            // Banner Left 01
            $bannerLeft01 = @$banners['sidebar1'] ?? collect([]);
            $keyLeft01 = $bannerLeft01->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyLeft01 = ($keyLeft01 === false || !@$bannerLeft01[$keyLeft01 + 1]) ? 0 : ++$keyLeft01;

            // Banner Left 02
            $bannerLeft02 = @$banners['sidebar2'] ?? collect([]);
            $keyLeft02 = $bannerLeft02->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyLeft02 = ($keyLeft02 === false || !@$bannerLeft02[$keyLeft02 + 1]) ? 0 : ++$keyLeft02;

            // Banner Right 01
            $bannerRight01 = @$banners['sidebar3'] ?? collect([]);
            $keyRight01 = $bannerRight01->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyRight01 = ($keyRight01 === false || !@$bannerRight01[$keyRight01 + 1]) ? 0 : ++$keyRight01;

            // Banner Right 02
            $bannerRight02 = @$banners['sidebar4'] ?? collect([]);
            $keyRight02 = $bannerRight02->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyRight02 = ($keyRight02 === false || !@$bannerRight02[$keyRight02 + 1]) ? 0 : ++$keyRight02;

            $bannerModel->category()->whereIn('position', ['sidebar1', 'sidebar2', 'sidebar3', 'sidebar4', 'center1', 'center2'])->update(['last_viewed_at' => null]);

            if (@$bannerCenter01[$keyCenter01]) {
                $item = $bannerCenter01[$keyCenter01];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['center1'] = $item;
            }

            if (@$bannerCenter02[$keyCenter02]) {
                $item = $bannerCenter02[$keyCenter02];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['center2'] = $item;
            }

            if (@$bannerLeft01[$keyLeft01]) {
                $item = $bannerLeft01[$keyLeft01];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar1'] = $item;
            }

            if (@$bannerLeft02[$keyLeft02]) {
                $item = $bannerLeft02[$keyLeft02];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar2'] = $item;
            }

            if (@$bannerRight01[$keyRight01]) {
                $item = $bannerRight01[$keyRight01];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar3'] = $item;
            }

            if (@$bannerRight02[$keyRight02]) {
                $item = $bannerRight02[$keyRight02];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar4'] = $item;
            }
        }
        return $bannerItems;
    }
}

<?php

namespace App\Http\Controllers\FrontendNew;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class IndexController extends Controller
{
    private $pathViewController = 'frontend-new.pages.index.';
    private $controllerName = 'index';

    public function __construct()
    {
        $this->agent = new Agent();
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $keyCache = 'frontend.index.index.';
        $timeCache = 120;
        $bannerItems = $this->getBanners();

        $colLeftTop = Cache::remember("{$keyCache}colLeftTop", $timeCache, function () {
            return Category::where('homepage_position', 'col_left_top')->first();
        });

        $colLeftPostsCarousel = Cache::remember("{$keyCache}colLeftPostsCarousel", $timeCache, function () {
            return Category::where('homepage_position', 'col_left_posts_carousel')->first();
        });

        $colLeftBeforeAdsCenter = Cache::remember("{$keyCache}colLeftBeforeAdsCenter", $timeCache, function () {
            return Category::where('homepage_position', 'col_left_before_ads_center')->first();
        });

        $colLeftAfterFeaturePost = Cache::remember("{$keyCache}colLeftAfterFeaturePost", $timeCache, function () {
            return Category::where('homepage_position', 'col_left_after_feature_post')->first();
        });

        $colLeftBottomLeft = Cache::remember("{$keyCache}colLeftBottomLeft", $timeCache, function () {
            return Category::where('homepage_position', 'col_left_bottom_left')->first();
        });

        $colLeftBottomRight = Cache::remember("{$keyCache}colLeftBottomRight", $timeCache, function () {
            return Category::where('homepage_position', 'col_left_bottom_right')->first();
        });

        $colRightTop = Cache::remember("{$keyCache}colRightTop", $timeCache, function () {
            return Category::where('homepage_position', 'col_right_top')->first();
        });

        $colRightBottom = Cache::remember("{$keyCache}colRightBottom", $timeCache, function () {
            return Category::where('homepage_position', 'col_right_bottom')->first();
        });

        $latestPosts = Cache::remember("frontend.latestPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->notSlider()->notHotNews()->take(4)->get();
        });

        $mostReadPosts = Cache::remember("frontend.mostReadPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->mostRead()->take(3)->get();
        });

        $sliders = Cache::remember("{$keyCache}sliders", $timeCache, function () {
            return Post::with('category')->latestPublished()->onSlider()->take(4)->get();
        });

        $hotNews = Cache::remember("{$keyCache}hotNews.home", $timeCache, function () {
            return Post::with('category')->latestPublished()->hotNews()->take(3)->get();
        });

//        $colLeftTop = $categoryModel->where('homepage_position', 'col_left_top')->first();
//        $colLeftPostsCarousel = $categoryModel->where('homepage_position', 'col_left_posts_carousel')->first();
//        $colLeftBeforeAdsCenter = $categoryModel->where('homepage_position', 'col_left_before_ads_center')->first();
//        $colLeftAfterFeaturePost = $categoryModel->with('descendants')->where('homepage_position', 'col_left_after_feature_post')->first();
//        $colLeftBottomLeft = $categoryModel->where('homepage_position', 'col_left_bottom_left')->first();
//        $colLeftBottomRight = $categoryModel->where('homepage_position', 'col_left_bottom_right')->first();
//        $colRightTop = $categoryModel->where('homepage_position', 'col_right_top')->first();
//        $colRightBottom = $categoryModel->where('homepage_position', 'col_right_bottom')->first();
//
//        $latestPosts = $postQuery->notSlider()->notHotNews()->take(4)->get();
//        $mostReadPosts = $postQuery->mostRead()->take(3)->get();
//        $sliders = $postQuery->onSlider()->take(4)->get();
//        $hotNews = Post::with('category')->latestPublished()->published()->hotNews()->take(3)->get();

        $settingMain = \App\Helpers\Fetch::get(public_path('cache/setting-main.json'), true);
        $settingSocial = \App\Helpers\Fetch::get(public_path('cache/setting-social.json'), true);
        $homePost = Post::find($settingMain['home_video']);

        return view("{$this->pathViewController}index", compact('latestPosts', 'sliders', 'colLeftTop', 'colLeftPostsCarousel', 'colLeftBeforeAdsCenter', 'colLeftAfterFeaturePost', 'colLeftBottomLeft', 'colLeftBottomRight', 'colRightTop', 'colRightBottom', 'mostReadPosts', 'homePost', 'settingSocial', 'bannerItems', 'hotNews'));
    }

    public function search(Request $request)
    {
        $searchValue = $request->search;
        $items = Post::where('title', 'LIKE', "%$searchValue%")->orWhere('excerpt', 'LIKE', "%$searchValue%")->orWhere('content', 'LIKE', "%$searchValue%")->published()->latestPublished()->paginate(6);
        $itemsChunk = $items->chunk(3);
        $latestPosts = Post::with('category')->notSlider()->notHotNews()->published()->latestPublished()->take(4)->get();
        $mostReadPosts = Post::with('category')->notSlider()->notHotNews()->published()->mostRead()->latestPublished()->take(3)->get();
        return view($this->pathViewController . 'search', compact('itemsChunk', 'items', 'searchValue', 'mostReadPosts', 'latestPosts'));
    }

    public function tags(Request $request)
    {
        $searchValue = $request->slug;
        $searchValue = implode(' ', explode('-', $searchValue));
        $items = Post::where('title', 'LIKE', "%$searchValue%")->orWhere('excerpt', 'LIKE', "%$searchValue%")->orWhere('content', 'LIKE', "%$searchValue%")->published()->latestPublished()->paginate(6);
        $itemsChunk = $items->chunk(3);
        $latestPosts = Post::with('category')->notSlider()->notHotNews()->published()->latestPublished()->take(4)->get();
        $mostReadPosts = Post::with('category')->notSlider()->notHotNews()->published()->mostRead()->latestPublished()->take(3)->get();
        return view($this->pathViewController . 'search', compact('itemsChunk', 'items', 'searchValue', 'mostReadPosts', 'latestPosts'));
    }

    public function addCountBannerClick(Request $request)
    {
        Banner::where('id', $request->id)->increment('clicked_count');
        return response()->json(['success']);
    }

    public function notfound(Request $request)
    {
        return view($this->pathViewController . 'not-found');
    }

    public function getBanners()
    {
        $bannerModel = new Banner();

        $bannerItems = [];
        if ($this->agent->isMobile()) {
            $bannersMobile = $bannerModel->active()->home()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2', 'mobile_emagazine_3', 'mobile_emagazine_4'])->get()->groupBy('type');

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

            $bannerModel->home()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2', 'mobile_emagazine_3', 'mobile_emagazine_4'])->update(['last_viewed_at' => null]);

            $updateBanner = [];

            if (@$bannerE1[$keyE1]) {
                $item = $bannerE1[$keyE1];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['mobile_emagazine_1'] = $item;
            }

            if (@$bannerE2[$keyE2]) {
                $item = $bannerE2[$keyE2];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['mobile_emagazine_2'] = $item;
            }

            if (@$bannerE3[$keyE3]) {
                $item = $bannerE3[$keyE3];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['mobile_emagazine_3'] = $item;
            }

            if (@$bannerE4[$keyE4]) {
                $item = $bannerE4[$keyE4];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['mobile_emagazine_4'] = $item;
            }
        } else {
            $banners = $bannerModel->select()->active()->home()->notMobile()->get()->groupBy('position');
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

            $bannerModel->home()->whereIn('position', ['sidebar1', 'sidebar2', 'sidebar3', 'sidebar4', 'center1', 'center2'])->update(['last_viewed_at' => null]);

            if (@$bannerCenter01[$keyCenter01]) {
                $item = $bannerCenter01[$keyCenter01];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['center1'] = $item;
            }

            if (@$bannerCenter02[$keyCenter02]) {
                $item = $bannerCenter02[$keyCenter02];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['center2'] = $item;
            }

            if (@$bannerLeft01[$keyLeft01]) {
                $item = $bannerLeft01[$keyLeft01];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['sidebar1'] = $item;
            }

            if (@$bannerLeft02[$keyLeft02]) {
                $item = $bannerLeft02[$keyLeft02];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['sidebar2'] = $item;
            }

            if (@$bannerRight01[$keyRight01]) {
                $item = $bannerRight01[$keyRight01];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['sidebar3'] = $item;
            }

            if (@$bannerRight02[$keyRight02]) {
                $item = $bannerRight02[$keyRight02];
                // $item->last_viewed_at = now();
                // $item->viewed_count += 1;
                // $item->save();
                $updateBanner[] = $item->id;
                $bannerItems['sidebar4'] = $item;
            }
        }
        DB::table('banners')->whereIn('id', $updateBanner)->update(['last_viewed_at' => now(), 'viewed_count' => DB::raw('viewed_count + 1')]);
        return $bannerItems;
    }

    public function getBannersHotFix()
    {
        $bannerModel = new Banner();

        $bannerItems = [];
        if ($this->agent->isMobile()) {
            $bannersMobile = $bannerModel->active()->home()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2', 'mobile_emagazine_3', 'mobile_emagazine_4'])->get()->groupBy('type');

            // Banner Emagazine 1
            $bannerE1 = @$bannersMobile['mobile_emagazine_1'] ?? collect([]);
            $bannerItems['mobile_emagazine_1'] = $bannerE1->shuffle()->first();
            // $keyE1 = $bannerE1->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyE1 = ($keyE1 === false || !@$bannerE1[$keyE1 + 1]) ? 0 : ++$keyE1;

            // Banner Emagazine 2
            $bannerE2 = @$bannersMobile['mobile_emagazine_2'] ?? collect([]);
            $bannerItems['mobile_emagazine_2'] = $bannerE2->shuffle()->first();
            // $keyE2 = $bannerE2->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyE2 = ($keyE2 === false || !@$bannerE2[$keyE2 + 1]) ? 0 : ++$keyE2;

            // Banner Emagazine 3
            $bannerE3 = @$bannersMobile['mobile_emagazine_3'] ?? collect([]);
            $bannerItems['mobile_emagazine_3'] = $bannerE3->shuffle()->first();
            // $keyE3 = $bannerE3->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyE3 = ($keyE3 === false || !@$bannerE3[$keyE3 + 1]) ? 0 : ++$keyE3;

            // Banner Emagazine 4
            $bannerE4 = @$bannersMobile['mobile_emagazine_4'] ?? collect([]);
            $bannerItems['mobile_emagazine_4'] = $bannerE4->shuffle()->first();
            // $keyE4 = $bannerE4->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyE4 = ($keyE4 === false || !@$bannerE4[$keyE4 + 1]) ? 0 : ++$keyE4;

            // $bannerModel->home()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2', 'mobile_emagazine_3', 'mobile_emagazine_4'])->update(['last_viewed_at' => null]);

            // if (@$bannerE1[$keyE1]) {
            //     $item = $bannerE1[$keyE1];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['mobile_emagazine_1'] = $item;
            // }

            // if (@$bannerE2[$keyE2]) {
            //     $item = $bannerE2[$keyE2];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['mobile_emagazine_2'] = $item;
            // }

            // if (@$bannerE3[$keyE3]) {
            //     $item = $bannerE3[$keyE3];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['mobile_emagazine_3'] = $item;
            // }

            // if (@$bannerE4[$keyE4]) {
            //     $item = $bannerE4[$keyE4];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['mobile_emagazine_4'] = $item;
            // }
        } else {
            $banners = $bannerModel->select()->active()->home()->notMobile()->get()->groupBy('position');
            // Banner Center 01
            $bannerCenter01 = @$banners['center1'] ?? collect([]);
            $bannerItems['center1'] = $bannerCenter01->shuffle()->first();
            // $keyCenter01 = $bannerCenter01->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyCenter01 = ($keyCenter01 === false || !@$bannerCenter01[$keyCenter01 + 1]) ? 0 : ++$keyCenter01;

            // Banner Center 02
            $bannerCenter02 = @$banners['center2'] ?? collect([]);
            $bannerItems['center2'] = $bannerCenter02->shuffle()->first();
            // $keyCenter02 = $bannerCenter02->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyCenter02 = ($keyCenter02 === false || !@$bannerCenter02[$keyCenter02 + 1]) ? 0 : ++$keyCenter02;

            // Banner Left 01
            $bannerLeft01 = @$banners['sidebar1'] ?? collect([]);
            $bannerItems['sidebar1'] = $bannerLeft01->shuffle()->first();
            // $keyLeft01 = $bannerLeft01->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyLeft01 = ($keyLeft01 === false || !@$bannerLeft01[$keyLeft01 + 1]) ? 0 : ++$keyLeft01;

            // Banner Left 02
            $bannerLeft02 = @$banners['sidebar2'] ?? collect([]);
            $bannerItems['sidebar2'] = $bannerLeft02->shuffle()->first();
            // $keyLeft02 = $bannerLeft02->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyLeft02 = ($keyLeft02 === false || !@$bannerLeft02[$keyLeft02 + 1]) ? 0 : ++$keyLeft02;

            // Banner Right 01
            $bannerRight01 = @$banners['sidebar3'] ?? collect([]);
            $bannerItems['sidebar3'] = $bannerRight01->shuffle()->first();
            // $keyRight01 = $bannerRight01->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyRight01 = ($keyRight01 === false || !@$bannerRight01[$keyRight01 + 1]) ? 0 : ++$keyRight01;

            // Banner Right 02
            $bannerRight02 = @$banners['sidebar4'] ?? collect([]);
            $bannerItems['sidebar4'] = $bannerRight02->shuffle()->first();
            // $keyRight02 = $bannerRight02->search(function ($item) {
            //     return $item->last_viewed_at != null;
            // });
            // $keyRight02 = ($keyRight02 === false || !@$bannerRight02[$keyRight02 + 1]) ? 0 : ++$keyRight02;

            // $bannerModel->home()->whereIn('position', ['sidebar1', 'sidebar2', 'sidebar3', 'sidebar4', 'center1', 'center2'])->update(['last_viewed_at' => null]);

            // if (@$bannerCenter01[$keyCenter01]) {
            //     $item = $bannerCenter01[$keyCenter01];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['center1'] = $item;
            // }

            // if (@$bannerCenter02[$keyCenter02]) {
            //     $item = $bannerCenter02[$keyCenter02];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['center2'] = $item;
            // }

            // if (@$bannerLeft01[$keyLeft01]) {
            //     $item = $bannerLeft01[$keyLeft01];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['sidebar1'] = $item;
            // }

            // if (@$bannerLeft02[$keyLeft02]) {
            //     $item = $bannerLeft02[$keyLeft02];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['sidebar2'] = $item;
            // }

            // if (@$bannerRight01[$keyRight01]) {
            //     $item = $bannerRight01[$keyRight01];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['sidebar3'] = $item;
            // }

            // if (@$bannerRight02[$keyRight02]) {
            //     $item = $bannerRight02[$keyRight02];
            //     $item->last_viewed_at = now();
            //     $item->viewed_count += 1;
            //     $item->save();
            //     $bannerItems['sidebar4'] = $item;
            // }
        }
        return $bannerItems;
    }
}
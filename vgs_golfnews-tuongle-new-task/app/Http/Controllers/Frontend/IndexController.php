<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class IndexController extends Controller
{
    private $pathViewController = 'frontend.pages.index.';
    private $controllerName = 'index';

    public function __construct()
    {
        $this->agent = new Agent();
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $postModel = new Post();
        $categoryModel = new Category();
        $bannerModel = new Banner();

        $sliders = $postModel->frontendHomepageSlider();

        $hotNews = $postModel->frontendHomepageHotNews();

        $categoriesHomepage = $categoryModel->with('postsFrontendArticle')->withDepth()->whereNotNull('homepage_position')->active()->get()->groupBy('homepage_position');

        $categoriesPosition1 = @$categoriesHomepage['position_1'];
        $categoriesPosition2 = @$categoriesHomepage['position_2'];
        $categoriesPosition3 = @$categoriesHomepage['position_3'];
        $categoriesPosition4 = @$categoriesHomepage['position_4'];

//        $videos = $postModel->frontendHomepageVideo();


        $bannerItems = [];
        if ($this->agent->isMobile()) {
            $bannersMobile = $bannerModel->active()->home()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2', 'top_banner'])->get()->groupBy('type');
            $bannerMobileTop = @$bannersMobile['top_banner'] ?? collect([]);
            $keyMobileTop = $bannerMobileTop->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyMobileTop = ($keyMobileTop === false || !@$bannerMobileTop[$keyMobileTop + 1]) ? 0 : ++$keyMobileTop;

            $bannerMobileEmagazine1 = @$bannersMobile['mobile_emagazine_1'] ?? collect([]);
            $keyMobileEmagazine1 = $bannerMobileEmagazine1->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyMobileEmagazine1 = ($keyMobileEmagazine1 === false || !@$bannerMobileEmagazine1[$keyMobileEmagazine1 + 1]) ? 0 : ++$keyMobileEmagazine1;

            $bannerMobileEmagazine2 = @$bannersMobile['mobile_emagazine_2'] ?? collect([]);
            $keyMobileEmagazine2 = $bannerMobileEmagazine2->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyMobileEmagazine2 = ($keyMobileEmagazine2 === false || !@$bannerMobileEmagazine2[$keyMobileEmagazine2 + 1]) ? 0 : ++$keyMobileEmagazine2;

            $bannerModel->home()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2', 'top_banner'])->update(['last_viewed_at' => null]);

            if (@$bannerMobileTop[$keyMobileTop]) {
                $item = $bannerMobileTop[$keyMobileTop];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['top_banner'] = $item;
            }

            if (@$bannerMobileEmagazine1[$keyMobileEmagazine1]) {
                $item = $bannerMobileEmagazine1[$keyMobileEmagazine1];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['mobile_emagazine_1'] = $item;
            }

            if (@$bannerMobileEmagazine2[$keyMobileEmagazine2]) {
                $item = $bannerMobileEmagazine2[$keyMobileEmagazine2];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['mobile_emagazine_2'] = $item;
            }

//            $bannerCenter = $bannerModel->select('id', 'name', 'thumb', 'last_viewed_at', 'position', 'url')->active()->home()->center()->get();
//            $keyCenter = $bannerCenter->search(function ($item) {
//                return $item->last_viewed_at != null;
//            });
//            $keyCenter = ($keyCenter === false || !@$bannerCenter[$keyCenter + 1]) ? 0 : ++$keyCenter;
//
//            if (@$bannerCenter[$keyCenter]) {
//                $bannerModel->home()->center()->update(['last_viewed_at' => null]);
//                $item = $bannerCenter[$keyCenter];
//                $item->last_viewed_at = now();
//                $item->viewed_count += 1;
//                $item->save();
//                $bannerItems['center'] = $item;
//            }
        } else {
            $banners = $bannerModel->select('id', 'name', 'thumb', 'last_viewed_at', 'position', 'url')->active()->home()->notMobile()->get()->groupBy('position');

            $bannerSidebar1 = @$banners['sidebar1'] ?? collect([]);
            $key1 = $bannerSidebar1->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $key1 = ($key1 === false || !@$bannerSidebar1[$key1 + 1]) ? 0 : ++$key1;

            $bannerSidebar2 = @$banners['sidebar2'] ?? collect([]);
            $key2 = $bannerSidebar2->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $key2 = ($key2 === false || !@$bannerSidebar2[$key2 + 1]) ? 0 : ++$key2;

            $bannerCenter = @$banners['center'] ?? collect([]);
            $key3 = $bannerCenter->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $key3 = ($key3 === false || !@$bannerCenter[$key3 + 1]) ? 0 : ++$key3;

            $bannerModel->home()->whereIn('position', ['sidebar1', 'sidebar2', 'center'])->update(['last_viewed_at' => null]);
            if (@$bannerSidebar1[$key1]) {
                $item = $bannerSidebar1[$key1];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar1'] = $item;
            }

            if (@$bannerSidebar2[$key2]) {
                $item = $bannerSidebar2[$key2];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar2'] = $item;
            }

            if (@$bannerCenter[$key3]) {
                $item = $bannerCenter[$key3];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['center'] = $item;
            }
        }

        return view($this->pathViewController . 'index', compact('sliders', 'hotNews', 'categoriesPosition1', 'categoriesPosition2', 'categoriesPosition3', 'categoriesPosition4', 'bannerItems'));
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $items = Post::where('title', 'LIKE', "%$q%")->orWhere('excerpt', 'LIKE', "%$q%")->orWhere('content', 'LIKE', "%$q%")->published()->latest('published_at_display')->paginate(10);
        return view($this->pathViewController . 'search', compact('items'));
    }

    public function addCountBannerClick(Request $request) {
        Banner::where('id', $request->id)->increment('clicked_count');
        return response()->json(['success']);
    }

    public function notfound(Request $request)
    {
        return view($this->pathViewController . 'not-found');
    }
}
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class PostController extends Controller
{
    private $pathViewController = 'frontend.pages.post.';
    private $controllerName = 'post';

    public function __construct()
    {
        $this->agent = new Agent();
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        return view($this->pathViewController . 'index');
    }

    public function detail(Request $request) {
        $item = Post::where('id', $request->id)->firstOrFail();
        $itemsRelated = Post::where('id', '<>', $item->id)->where('category_id', $item->category_id)->published()->latest('published_at_display')->take(6)->get();
        $itemsFeatured = Post::hotNews()->published()->latest('published_at_display')->take(5)->get();
        $breadcrumbs = Category::withDepth()->having('depth', '>', 0)->defaultOrder()->ancestorsAndSelf($item->category_id);

        $bannerModel = new Banner();


        $bannerItems = [];
        if ($this->agent->isMobile()) {
            $bannersMobile = $bannerModel->active()->home()->mobile()->whereIn('type', ['inpage_fullscreen', 'top_banner'])->get()->groupBy('type');

            $bannerMobileTop = @$bannersMobile['top_banner'] ?? collect([]);
            $keyMobileTop = $bannerMobileTop->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyMobileTop = ($keyMobileTop === false || !@$bannerMobileTop[$keyMobileTop + 1]) ? 0 : ++$keyMobileTop;

            $bannerInpage = @$bannersMobile['inpage_fullscreen'] ?? collect([]);
            $keyInpage = $bannerInpage->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyInpage = ($keyInpage === false || !@$bannerInpage[$keyInpage + 1]) ? 0 : ++$keyInpage;

            if (@$bannerMobileTop[$keyMobileTop]) {
                $itemAds = $bannerMobileTop[$keyMobileTop];
                $itemAds->last_viewed_at = now();
                $itemAds->viewed_count += 1;
                $itemAds->save();
                $bannerItems['top_banner'] = $itemAds;
            }

            if (@$bannerInpage[$keyInpage]) {
                $itemAds = $bannerInpage[$keyInpage];
                $itemAds->last_viewed_at = now();
                $itemAds->viewed_count += 1;
                $itemAds->save();
                $bannerItems['inpage_fullscreen'] = $itemAds;
            }
        } else {
            $banners = $bannerModel->active()->post()->notMobile()->get()->groupBy('position');

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

            $bannerSidebar3 = @$banners['sidebar3'] ?? collect([]);
            $key3 = $bannerSidebar3->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $key3 = ($key3 === false || !@$bannerSidebar3[$key3 + 1]) ? 0 : ++$key3;


            $bannerModel->post()->whereIn('position', ['sidebar1', 'sidebar2', 'sidebar3'])->update(['last_viewed_at' => null]);
            if (@$bannerSidebar1[$key1]) {
                $itemAds = $bannerSidebar1[$key1];
                $itemAds->last_viewed_at = now();
                $itemAds->viewed_count += 1;
                $itemAds->save();
                $bannerItems['sidebar1'] = $itemAds;
            }

            if (@$bannerSidebar2[$key2]) {
                $itemAds = $bannerSidebar2[$key2];
                $itemAds->last_viewed_at = now();
                $itemAds->viewed_count += 1;
                $itemAds->save();
                $bannerItems['sidebar2'] = $itemAds;
            }

            if (@$bannerSidebar3[$key3]) {
                $itemAds = $bannerSidebar3[$key3];
                $itemAds->last_viewed_at = now();
                $itemAds->viewed_count += 1;
                $itemAds->save();
                $bannerItems['sidebar3'] = $itemAds;
            }
        }

        return view($this->pathViewController . 'detail', compact('item', 'itemsRelated', 'itemsFeatured', 'breadcrumbs', 'bannerItems'));
    }

}
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class VideoController extends Controller
{
    private $pathViewController = 'frontend.pages.video.';
    private $controllerName = 'video';

    public function __construct()
    {
        $this->agent = new Agent();
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $bannerModel = new Banner();
        $category = Category::with('postsFrontendVideo')->withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toTree();

        // BANNER
        $bannerItems = [];

        if ($this->agent->isMobile()) {
            $bannersMobile = $bannerModel->active()->category()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2'])->get()->groupBy('type');

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

            $bannerModel->category()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2'])->update(['last_viewed_at' => null]);

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
        } else {
            $banners = $bannerModel->select('id', 'name', 'thumb', 'last_viewed_at', 'position', 'url')->whereIn('position', ['sidebar1', 'sidebar2', 'sidebar3'])->active()->category()->notMobile()->get()->groupBy('position');
            $bannerSidebar1 = @$banners['sidebar1'] ?? collect([]);
            $keySidebar1 = $bannerSidebar1->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keySidebar1 = ($keySidebar1 === false || !@$bannerSidebar1[$keySidebar1 + 1]) ? 0 : ++$keySidebar1;

            $bannerSidebar2 = @$banners['sidebar2'] ?? collect([]);
            $keySidebar2 = $bannerSidebar2->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keySidebar2 = ($keySidebar2 === false || !@$bannerSidebar2[$keySidebar2 + 1]) ? 0 : ++$keySidebar2;

            $bannerSidebar3 = @$banners['sidebar3'] ?? collect([]);
            $keySidebar3 = $bannerSidebar3->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keySidebar3 = ($keySidebar3 === false || !@$bannerSidebar3[$keySidebar3 + 1]) ? 0 : ++$keySidebar3;

            $bannerModel->whereIn('position', ['sidebar1', 'sidebar2', 'sidebar3'])->category()->update(['last_viewed_at' => null]);
            if (@$bannerSidebar3[$keySidebar3]) {
                $item = $bannerSidebar3[$keySidebar3];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar3'] = $item;
            }

            if (@$bannerSidebar1[$keySidebar1]) {
                $item = $bannerSidebar1[$keySidebar1];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar1'] = $item;
            }

            if (@$bannerSidebar2[$keySidebar2]) {
                $item = $bannerSidebar2[$keySidebar2];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar2'] = $item;
            }
        }

        return view($this->pathViewController . 'index', compact('category', 'bannerItems'));
    }

    public function detail(Request $request)
    {
        $bannerModel = new Banner();
        $category = Category::with('postsFrontendVideo')->withDepth()->descendantsAndSelf($request->id)->toTree()->first();
        $categories = $category->descendants()->pluck('id');
        $categories[] = $category->getKey();
        $items = Post::whereIn('category_id', $categories)->video()->published()->latest('published_at_display')->take(4)->get();
        $firstPost = $items->shift();

        // BANNER
        $bannerItems = [];

        if ($this->agent->isMobile()) {
            $bannersMobile = $bannerModel->active()->category()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2'])->get()->groupBy('type');

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

            $bannerModel->category()->mobile()->whereIn('type', ['mobile_emagazine_1', 'mobile_emagazine_2'])->update(['last_viewed_at' => null]);

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
        } else {
            $banners = $bannerModel->select('id', 'name', 'thumb', 'last_viewed_at', 'position', 'url')->whereIn('position', ['sidebar1', 'sidebar2', 'sidebar3'])->active()->category()->notMobile()->get()->groupBy('position');
            $bannerSidebar1 = @$banners['sidebar1'] ?? collect([]);
            $keySidebar1 = $bannerSidebar1->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keySidebar1 = ($keySidebar1 === false || !@$bannerSidebar1[$keySidebar1 + 1]) ? 0 : ++$keySidebar1;

            $bannerSidebar2 = @$banners['sidebar2'] ?? collect([]);
            $keySidebar2 = $bannerSidebar2->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keySidebar2 = ($keySidebar2 === false || !@$bannerSidebar2[$keySidebar2 + 1]) ? 0 : ++$keySidebar2;

            $bannerSidebar3 = @$banners['sidebar3'] ?? collect([]);
            $keySidebar3 = $bannerSidebar3->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keySidebar3 = ($keySidebar3 === false || !@$bannerSidebar3[$keySidebar3 + 1]) ? 0 : ++$keySidebar3;

            $bannerModel->whereIn('position', ['sidebar1', 'sidebar2', 'sidebar3'])->category()->update(['last_viewed_at' => null]);
            if (@$bannerSidebar3[$keySidebar3]) {
                $item = $bannerSidebar3[$keySidebar3];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar3'] = $item;
            }

            if (@$bannerSidebar1[$keySidebar1]) {
                $item = $bannerSidebar1[$keySidebar1];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar1'] = $item;
            }

            if (@$bannerSidebar2[$keySidebar2]) {
                $item = $bannerSidebar2[$keySidebar2];
                $item->last_viewed_at = now();
                $item->viewed_count += 1;
                $item->save();
                $bannerItems['sidebar2'] = $item;
            }
        }

        return view($this->pathViewController . 'detail', compact('items', 'firstPost', 'category', 'bannerItems'));
    }

    public function getMorePostsLevel2(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        $categories = $category->descendants()->pluck('id');
        $categories[] = $category->getKey();
        $items = Post::whereIn('category_id', $categories)->published()->video()->latest('published_at_display')->paginate(4);
        $firstPost = $items->shift();
        return view($this->pathViewController . 'get-more-posts-level2', compact('items', 'firstPost'));
    }
}

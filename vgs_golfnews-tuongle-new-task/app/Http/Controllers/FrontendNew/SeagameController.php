<?php

namespace App\Http\Controllers\FrontendNew;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannersSeagames;
use App\Models\Category;
use App\Models\Lives;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;

class SeagameController extends Controller
{
    private $pathViewController = 'frontend.pages.category.';
    private $controllerName = 'category';
    private $bannerTop = [];
    private $bannerBackground = [];
    private $bannerItems = [];
    public function __construct()
    {
        $this->agent = new Agent();
        if ($this->agent->isMobile()) {
            $bannersSeagameTop = BannersSeagames::select("name", "thumb", "url")->where("type", 1)->where("device", 1)->where("status", 1)->get()->toArray();
            $bannersSeagameBackground = BannersSeagames::select("name", "thumb", "url")->where("type", 2)->where("device", 1)->where("status", 1)->get()->toArray();
            $bannerSeagamesItems = BannersSeagames::select("name", "thumb", "url")->where("type", 3)->where("device", 1)->where("status", 1)->get()->toArray();
        } else {
            $bannersSeagameTop = BannersSeagames::select("name", "thumb", "url")->where("type", 1)->where("device", 0)->where("status", 1)->get()->toArray();
            $bannersSeagameBackground = BannersSeagames::select("name", "thumb", "url")->where("type", 2)->where("device", 0)->where("status", 1)->get()->toArray();
            $bannerSeagamesItems = BannersSeagames::select("name", "thumb", "url")->where("type", 3)->where("device", 0)->where("status", 1)->get()->toArray();
        }
        if (!empty($bannersSeagameTop)) {
            $this->bannerTop = $bannersSeagameTop;
        }
        if (!empty($bannersSeagameBackground)) {
            $this->bannerBackground = $bannersSeagameBackground;
        }
        if (!empty($bannerSeagamesItems)) {
            $this->bannerItems = $bannerSeagamesItems;
        }
        view()->share('controllerName', $this->controllerName);
        // $this->bannerTop =[  
        // 0 =>[
        //     "name" => "AMBER SLIDER LEFT 01 CHI TIẾT BÀI VIẾT",
        //     "thumb" => asset('frontend-new/images/seagames31/bannerTopSeagames.jpg'),
        //     "url" => "http://www.baohiempvi.com.vn",
        // ],
        // 1 =>[
        //     "name" => "NAM Á SLIDERBAR LEFT 01_XUYÊN TRANG",
        //     "thumb" => asset('frontend-new/images/seagames31/sea-games-31-7530.png'),
        //     "url" => "https://www.t99.vn",
        // ]
        // ];
        // dd($this->bannerTop);
        // $this->bannerBackground =[  
        // 0 =>[
        //     "name" => "AMBER SLIDER LEFT 01 CHI TIẾT BÀI VIẾT",
        //     "thumb" => asset('frontend-new/images/seagames31/bannerTopSeagames.jpg'),
        //     "url" => "http://www.baohiempvi.com.vn",
        // ],
        // 1 =>[
        //     "name" => "NAM Á SLIDERBAR LEFT 01_XUYÊN TRANG",
        //     "thumb" => asset('frontend-new/images/seagames31/sea-games-31-7530.png'),
        //     "url" => "https://www.t99.vn",
        // ]
        // ];
    }
    public function index(Request $request)
    {
        $keyCache = 'frontend-new.category.seagames.news.';
        $timeCache = 120;

        // $bannerItems = $this->getBanners();

        $id = '30';
        $category = Cache::remember("{$keyCache}{$id}", $timeCache, function () use ($id) {
            return Category::find($id);
        });
        $categories = $category->descendants()->pluck('id');

        $categories[] = $category->getKey();
        $language = session('locale') == 'vi' ? 0 : 1;

        $sliderPosts = Cache::remember("frontend-new.seagames.sliderPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        });




        $latestPosts = Cache::remember("frontend-new.seagames.latestPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->notSlider()->notHotNews()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend-new.seagames.mostReadPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->mostRead()->take(3)->get();
        });

        $items = Cache::remember("frontend-new.seagames.items.language." . $language . ($request->page ?? 1), $timeCache, function () use ($categories, $language, $sliderPosts) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->whereNotIn('id', $sliderPosts->pluck('id'))->published()->latest('published_at_display')->paginate(4);
        });
            // $items = Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->whereNotIn('id', $sliderPosts->pluck('id'))->published()->latest('published_at_display')->paginate(4);
           



        $itemsChunk = $items->chunk(4);
        // return view("{$this->pathViewController}detail", compact('sliderPosts', 'items', 'itemsChunk', 'category', 'mostReadPosts', 'latestPosts'));
        // $bannerItems =[
        //     0 =>[
        //         "name" => "AMBER SLIDER LEFT 01 CHI TIẾT BÀI VIẾT",
        //         "thumb" => "https://9134476f07ab2c2.kcdn.vn/uploads/50/homepage-1/hio-1190x135px.jpg",
        //         "url" => "http://www.baohiempvi.com.vn",
        //     ],
        //     1 =>[
        //         "name" => "NAM Á SLIDERBAR LEFT 01_XUYÊN TRANG",
        //         "thumb" => "https://9134476f07ab2c2.kcdn.vn/uploads/50/1190x135.png",
        //         "url" => "https://www.t99.vn",
        //     ],
        //     2 =>[
        //         "name" => "Half-page Ad right 1 Ping",
        //         "thumb" => "https://9134476f07ab2c2.kcdn.vn/uploads/50/homepage-1/1190x135.jpg",
        //         "url" => "https://baoyengroup.com",
        //     ],
        //     3 =>[
        //         "name" => "T99 SLIDERBAR RIGHT 01_XUYÊN TRANG",
        //         "thumb" => "https://9134476f07ab2c2.kcdn.vn/uploads/50/homepage-1/0-02-06-b54552847fefe057ca66240969ce8e23678000830ff14f3babd2b2bcd07d61bd-26e95588e16.jpg",
        //         "url" => "https://www.namabank.com.vn",
        //     ],
        // ];
        $bannerItems = $this->bannerItems;

        shuffle($bannerItems);

        $bannerTop = $this->bannerTop;
        shuffle($bannerTop);

        $live = Lives::where('type', 1)->orderBy('id', 'desc')->first();
        $livescore = Lives::where('type', 2)->orderBy('id', 'desc')->first();
        $bannerBackground = $this->bannerBackground;
        shuffle($bannerBackground);
        return view("frontend-new.pages.seagames.home", compact('live', 'livescore', 'sliderPosts', 'items', 'itemsChunk', 'category', 'mostReadPosts', 'latestPosts', 'bannerItems', 'bannerTop', 'bannerBackground'));
    }
    public function news(Request $request)
    {
        $keyCache = 'frontend-new.category.detail.';
        $timeCache = 120;
        $language = session('locale') == 'vi' ? 0 : 1;


        $id = '30';

        $category = Cache::remember("{$keyCache}{$id}", $timeCache, function () use ($id) {
            return Category::find($id);
        });
        $categories = $category->descendants()->pluck('id');
        $categories[] = $category->getKey();


        $sliderPosts = Cache::remember("frontend-new.seagames.news.sliderPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        });





        $latestPosts = Cache::remember("frontend-new.seagames.news.latestPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->notSlider()->notHotNews()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend-new.seagames.news.mostReadPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->mostRead()->take(3)->get();
        });
        $items = Cache::remember("frontend-new.seagames.news.items.language." . $language . ($request->page ?? 1), $timeCache, function () use ($categories, $language, $sliderPosts) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->whereNotIn('id', $sliderPosts->pluck('id'))->published()->latest('published_at_display')->paginate(6);
        });
        // dd($latestPosts);

        $bannerBackground = $this->bannerBackground;
        shuffle($bannerBackground);
        $bannerItems = $this->bannerItems;
        shuffle($bannerItems);
        $bannerTop = $this->bannerTop;
        shuffle($bannerTop);

        // $items = Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->whereNotIn('id', $sliderPosts->pluck('id'))->published()->latest('published_at_display')->paginate(6);

        $itemsChunk = $items->chunk(4);
        return view("frontend-new.pages.seagames.news", compact('sliderPosts', 'items', 'itemsChunk', 'category', 'mostReadPosts', 'latestPosts', 'bannerTop', 'bannerBackground', 'bannerItems'));
    }

    public function viewBanner()
    {
        $banner = BannersSeagames::get();
        return view("frontend-new.pages.seagames.viewBanner", compact('banner'));
    }
    public function formBanner()
    {
        // $banner = BannersSeagames::get();
        return view("frontend-new.pages.seagames.formBanner");
    }
    public function updateBanner(Request $request)
    {
        if (!empty($request->sua)) {
            $banner = BannersSeagames::find($request->id);
            $banner->name = $request->name ?? null;
            $banner->thumb = $request->thumb ?? null;
            $banner->url = $request->url ?? null;
            $banner->type = $request->type ?? null;
            $banner->device = $request->device ?? 0;
            $banner->status = $request->status ?? null;
            $banner->save();
            return "<script>alert('Sua thanh cong')</script>" . redirect()->back();
        } else {
            $banner = BannersSeagames::find($request->id);
            $banner->delete();
            return "<script>alert('Xoa thanh cong')</script>" . redirect()->back();
        }
    }
    public function createBanner(Request $request)
    {
        BannersSeagames::create([
            "name" => $request->name,
            "thumb" => $request->thumb,
            "url" => $request->url,
            "type" => $request->type,
            "device" => $request->device,
            "status" => $request->status,
        ]);
        return "<script>alert('Tao thanh cong')</script>" . redirect()->route('seagames.viewBanner');
    }
    public function viewLive()
    {
        $live = Lives::get();
        return view("frontend-new.pages.seagames.viewLive", compact('live'));
    }
    public function formLive()
    {
        // $banner = BannersSeagames::get();
        return view("frontend-new.pages.seagames.formLive");
    }
    public function createLive(Request $request)
    {
        $live = Lives::create([
            "name"      => $request->name,
            "status"    => $request->status,
            "image"     => $request->image,
            "content"   => $request->content,
            "url_key"   => $request->url_key,
            "type"      => $request->type,
        ]);
        return "<script>alert('Tao thanh cong')</script>" . redirect()->route('seagames.viewLive');
    }
    public function updateLive(Request $request)
    {
        if (!empty($request->sua)) {
            $live = Lives::find($request->id);
            $live->name = $request->name ?? null;
            $live->image = $request->image ?? null;
            $live->url_key = $request->url_key ?? null;
            $live->type = $request->type ?? null;
            $live->status = $request->status ?? null;
            $live->content = $request->content ?? null;
            $live->save();
            return "<script>alert('Sua thanh cong')</script>" . redirect()->back();
        } else {
            $live = Lives::find($request->id);
            $live->delete();
            return "<script>alert('Xoa thanh cong')</script>" . redirect()->back();
        }
    }
    public function setLang($locale)
    {

        if (array_key_exists($locale, Config::get('languages'))) {
            Session::put('locale', $locale);
        }
        return redirect()->route('seagames31');
    }
    public function live()
    {
        $keyCache = 'frontend.category.detail.';
        $timeCache = 120;
        $latestPosts = Cache::remember("frontend.latestPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->notSlider()->notHotNews()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend.mostReadPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->mostRead()->take(3)->get();
        });
        $bannerTop = $this->bannerTop;
        $live = Lives::where('type', 1)->orderBy('id', 'desc')->first();
        $livescore = Lives::where('type', 2)->orderBy('id', 'desc')->first();
        shuffle($bannerTop);

        $bannerBackground = $this->bannerBackground;
        shuffle($bannerBackground);
        $bannerItems = $this->bannerItems;
        shuffle($bannerItems);
        return view("frontend-new.pages.seagames.live", compact('live', 'livescore', 'latestPosts', 'mostReadPosts', 'bannerTop', 'bannerBackground', 'bannerItems'));
    }
    public function liveScore()
    {
        $keyCache = 'frontend.category.detail.';
        $timeCache = 120;
        $latestPosts = Cache::remember("frontend.latestPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->notSlider()->notHotNews()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend.mostReadPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->mostRead()->take(3)->get();
        });
        $bannerTop = $this->bannerTop;
        shuffle($bannerTop);
        $live = Lives::where('type', 1)->orderBy('id', 'desc')->first();
        $livescore = Lives::where('type', 2)->orderBy('id', 'desc')->first();
        $bannerBackground = $this->bannerBackground;
        shuffle($bannerBackground);
        $bannerItems = $this->bannerItems;
        shuffle($bannerItems);
        return view("frontend-new.pages.seagames.livescore", compact('live', 'livescore', 'latestPosts', 'mostReadPosts', 'bannerTop', 'bannerBackground', 'bannerItems'));
    }
    public function getBanners()
    {
        $bannerModel = new Banner();
        $bannerItems = [];
        if ($this->agent->isMobile()) {
            $bannersMobile = $bannerModel->active()->post()->mobile()->whereIn('type', ['inpage_fullscreen', 'mobile_emagazine_4'])->get()->groupBy('type');

            $bannerMobileE4 = @$bannersMobile['mobile_emagazine_4'] ?? collect([]);
            $keyMobileE4 = $bannerMobileE4->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyMobileE4 = ($keyMobileE4 === false || !@$bannerMobileE4[$keyMobileE4 + 1]) ? 0 : ++$keyMobileE4;

            $bannerInpage = @$bannersMobile['inpage_fullscreen'] ?? collect([]);
            $keyInpage = $bannerInpage->search(function ($item) {
                return $item->last_viewed_at != null;
            });
            $keyInpage = ($keyInpage === false || !@$bannerInpage[$keyInpage + 1]) ? 0 : ++$keyInpage;

            $bannerModel->post()->mobile()->whereIn('type', ['inpage_fullscreen', 'mobile_emagazine_4'])->update(['last_viewed_at' => null]);

            if (@$bannerMobileE4[$keyMobileE4]) {
                $itemAds = $bannerMobileE4[$keyMobileE4];
                $itemAds->last_viewed_at = now();
                $itemAds->viewed_count += 1;
                $itemAds->save();
                $bannerItems['mobile_emagazine_4'] = $itemAds;
            }

            if (@$bannerInpage[$keyInpage]) {
                $itemAds = $bannerInpage[$keyInpage];
                $itemAds->last_viewed_at = now();
                $itemAds->viewed_count += 1;
                $itemAds->save();
                $bannerItems['inpage_fullscreen'] = $itemAds;
            }
        } else {
            $banners = $bannerModel->select()->active()->post()->notMobile()->get()->groupBy('position');
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

            $bannerModel->post()->whereIn('position', ['sidebar1', 'sidebar2', 'sidebar3', 'sidebar4', 'center1', 'center2'])->update(['last_viewed_at' => null]);

            if (@$bannerCenter01[$keyCenter01]) {
                $itemBanner = $bannerCenter01[$keyCenter01];
                $itemBanner->last_viewed_at = now();
                $itemBanner->viewed_count += 1;
                $itemBanner->save();
                $bannerItems['center1'] = $itemBanner;
            }

            if (@$bannerCenter02[$keyCenter02]) {
                $itemBanner = $bannerCenter02[$keyCenter02];
                $itemBanner->last_viewed_at = now();
                $itemBanner->viewed_count += 1;
                $itemBanner->save();
                $bannerItems['center2'] = $itemBanner;
            }

            if (@$bannerLeft01[$keyLeft01]) {
                $itemBanner = $bannerLeft01[$keyLeft01];
                $itemBanner->last_viewed_at = now();
                $itemBanner->viewed_count += 1;
                $itemBanner->save();
                $bannerItems['sidebar1'] = $itemBanner;
            }

            if (@$bannerLeft02[$keyLeft02]) {
                $itemBanner = $bannerLeft02[$keyLeft02];
                $itemBanner->last_viewed_at = now();
                $itemBanner->viewed_count += 1;
                $itemBanner->save();
                $bannerItems['sidebar2'] = $itemBanner;
            }

            if (@$bannerRight01[$keyRight01]) {
                $itemBanner = $bannerRight01[$keyRight01];
                $itemBanner->last_viewed_at = now();
                $itemBanner->viewed_count += 1;
                $itemBanner->save();
                $bannerItems['sidebar3'] = $itemBanner;
            }

            if (@$bannerRight02[$keyRight02]) {
                $itemBanner = $bannerRight02[$keyRight02];
                $itemBanner->last_viewed_at = now();
                $itemBanner->viewed_count += 1;
                $itemBanner->save();
                $bannerItems['sidebar4'] = $itemBanner;
            }
        }

        return $bannerItems;
    }
}

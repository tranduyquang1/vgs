<?php

namespace App\Http\Controllers\FrontendNew;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\BannersCategories;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;

use App\Models\Menu;
use App\Models\TournamentCategories;
use App\Models\BannersSeagames;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App as AppSupport;

class PostController extends Controller
{
    private $pathViewController = 'frontend-new.pages.post.';
    private $controllerName = 'post';
    private $bannerItems = [];
    public function __construct()
    {
        $this->agent = new Agent();
        if ($this->agent->isMobile()) {
            
            $bannerSeagamesItems = BannersSeagames::select("name", "thumb", "url")->where("type", 3)->where("device", 1)->where("status", 1)->get()->toArray();
    
            }
            else{
            $bannerSeagamesItems = BannersSeagames::select("name", "thumb", "url")->where("type", 3)->where("device", 0)->where("status", 1)->get()->toArray();
    
            }
            if(!empty($bannerSeagamesItems)){
                $this->bannerItems = $bannerSeagamesItems;
            }
        view()->share('controllerName', $this->controllerName);
    }

    public function detail(Request $request)
    {
        $keyCache = 'frontend.post.detail.';
        $timeCache = 120;
        $item = Post::with(['category', 'createdBy'])->where('slug', $request->slug)->firstOrFail();
//        $slug = $request->slug;
//        $item = Cache::remember("{$keyCache}$slug", $timeCache, function () use ($slug) {
//            return Post::with(['category', 'createdBy'])->where('slug', $slug)->firstOrFail();
//        });
        views($item)->record();
    // seagames
        $bannerTop = BannersSeagames::select("name", "thumb", "url")->where("type", 1)->where("status", 1)->get()->toArray();

        
        if($item->category_id==30){
            $language = session('locale') == 'vi' ? 0 : 1;
            $bannerBackground = BannersSeagames::select("name", "thumb", "url")->where("type", 2)->where("status", 1)->get()->toArray();
            shuffle($bannerBackground);
            $bannerItems =$this->bannerItems;
        
            shuffle($bannerItems);

            $sliderRelatedPosts = Post::with('category')->latestPublished()->where('id', '<>', $item->id)->where('category_id', $item->category_id)->where('language', $language)->take(5)->get();
            $relatedPosts =  Post::with('category')->latestPublished()->whereNotIn('id', $sliderRelatedPosts->pluck('id'))->where('id', '<>', $item->id)->where('category_id', $item->category_id)->where('language', $language)->take(4)->get();
            $latestPosts =Post::with('category')->where('category_id', $item->category_id)->where('language', $language)->latestPublished()->notSlider()->notHotNews()->take(4)->get();
            $mostReadPosts =  Post::with('category')->where('category_id', $item->category_id)->where('language', $language)->latestPublished()->mostRead()->take(3)->get();
            return view('frontend-new.pages.seagames.detail',compact('item', 'relatedPosts', 'sliderRelatedPosts', 'latestPosts','mostReadPosts','bannerTop','bannerBackground','bannerItems'));
        }



    // tournament
        $menu = Menu::select('id','tournament_categories_id','is_special_page')->where(['category_id' => $item->category_id,'is_special_page' =>1])->first();
        if($menu){
     
                $tournament_categories= TournamentCategories::find($menu->tournament_categories_id);
                if($tournament_categories){
                    $multi_language = $tournament_categories->multi_language;
                    if($multi_language == 0){
                        Session::put('locale', 'vi');
        
                        AppSupport::setLocale('vi');
        
                    }
        
                }
                $language = session('locale') == 'vi' ? 0 : 1;

                $bannerInPostItems =[];
                $bannerTop =[];
                $bannerBackground =[];
                $bannerInPostInPageTournamentItems =[];
                $bannerInPostInpageItems =[];
                if($tournament_categories->banner_category_id){
                    $banner_category_id=$tournament_categories->banner_category_id;
                    $whereBanner = [
                        "category_id"=>$banner_category_id,
                        "status" => 1,
                        "is_post" =>1
                
                    ];
                    if ($this->agent->isMobile()) {
                        $bannersTournamentTop = BannersCategories::select("id","name", "thumb", "url")->where("position", 1)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
                        $bannersTournamentBackground = BannersCategories::select("id","name", "thumb", "url")->where("position", 2)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
                        $bannerTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 3)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
                        $bannerInPostTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 4)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
                        $bannerInPostInPageTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 5)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
                    } else {
                        $bannersTournamentTop = BannersCategories::select("id","name", "thumb", "url")->where("position", 1)->where("is_mobile", 0)->where($whereBanner)->get()->toArray();
                        $bannersTournamentBackground = BannersCategories::select("id","name", "thumb", "url")->where("position", 2)->where("is_mobile", 0)->where($whereBanner)->get()->toArray();
                        $bannerTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 3)->where("is_mobile", 0)->where($whereBanner)->get()->toArray();
                        $bannerInPostTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 4)->where("is_mobile", 0)->where($whereBanner)->get()->toArray();
                    }
            
            
                    $bannerItems = $bannerTournamentItems;
                    shuffle($bannerItems);
                    if(!empty($bannerItems))
                    {
                        $this->countViewBannerSpecialPage($bannerItems[0]['id']);
            
                    }
            
                    $bannerTop = $bannersTournamentTop;
                    shuffle($bannerTop);
                    if(!empty($bannerTop))
                    {
                        $this->countViewBannerSpecialPage($bannerTop[0]['id']);
            
                    }
            
            
                    $bannerBackground = $bannersTournamentBackground;
                    shuffle($bannerBackground);
                    if(!empty($bannerBackground))
                    {
                        $this->countViewBannerSpecialPage($bannerBackground[0]['id']);
            
                    }
                    $bannerInPostItems = $bannerInPostTournamentItems;
                    shuffle($bannerInPostItems);
                    if(!empty($bannerInPostItems))
                    {
                        $this->countViewBannerSpecialPage($bannerInPostItems[0]['id']);
            
                    }
                    $bannerInPostInpageItems = $bannerInPostInPageTournamentItems;
                    shuffle($bannerInPostInpageItems);
                    if(!empty($bannerInPostInpageItems))
                    {
                        $this->countViewBannerSpecialPage($bannerInPostInpageItems[0]['id']);
            
                    }
        
                }

            $sliderPosts = Cache::remember("frontend-new.tournament.special.sliderPosts.language" . $language, $timeCache, function () use ($item, $language,$tournament_categories) {
                    return Post::with('category')->where(['language' => $language])->where('category_id', $item->category_id)->latestPublished()->take($tournament_categories->amount_slider_posts)->get();
            });
            $sliderRelatedPosts = Cache::remember($keyCache.$item->id."tournament.sliderRelatedPosts.language" . $language, $timeCache, function () use ($item, $language) {
                return Post::with('category')->latestPublished()->where('id', '<>', $item->id)->where('category_id', $item->category_id)->where('language', $language)->take(5)->get();
            });


            
            $relatedPosts = Cache::remember($keyCache.$item->id."tournament.relatedPosts.language" . $language, $timeCache, function () use ($item,$sliderRelatedPosts, $language) {
            return Post::with('category')->latestPublished()->whereNotIn('id', $sliderRelatedPosts->pluck('id'))->where('id', '<>', $item->id)->where('category_id', $item->category_id)->where('language', $language)->take(4)->get();
            });
            $latestPosts = Cache::remember("frontend.tournamentpage.latestPosts.language" . $language, $timeCache, function() use ($language,$item) {
                return Post::with('category')->latestPublished()->where('category_id', $item->category_id)->where('language', $language)->take(4)->get();
            });

            $mostReadPosts = Cache::remember("frontend.tournamentpage.mostReadPosts.language" . $language, $timeCache, function() use ($language,$item) {
                return Post::with('category')->where('category_id', $item->category_id)->where('language', $language)->latestPublished()->mostRead()->get();
            });
            $tournamentSpecialId = $menu->id;
            return view('frontend-new.pages.tournament.detail',compact('item', 'relatedPosts', 'sliderRelatedPosts', 'latestPosts','mostReadPosts','bannerTop','bannerBackground','bannerInPostItems','tournamentSpecialId','tournament_categories','bannerInPostInpageItems'));

            

        }










        $sliderRelatedPosts = Cache::remember("{$keyCache}{$item->id}.sliderRelatedPosts", $timeCache, function () use ($item) {
            return Post::with('category')->latestPublished()->where('id', '<>', $item->id)->where('category_id', $item->category_id)->take(5)->get();
        });

        $relatedPosts = Cache::remember("{$keyCache}{$item->id}.relatedPosts", $timeCache, function () use ($item, $sliderRelatedPosts) {
            return Post::with('category')->latestPublished()->whereNotIn('id', $sliderRelatedPosts->pluck('id'))->where('id', '<>', $item->id)->where('category_id', $item->category_id)->take(4)->get();
        });

        $latestPosts = Cache::remember("frontend.latestPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->notSlider()->notHotNews()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend.mostReadPosts", $timeCache, function () {
            return Post::with('category')->latestPublished()->mostRead()->take(3)->get();
        });

        $bannerItems = $this->getBanners();




       
        return view($this->pathViewController . 'detail', compact('item', 'relatedPosts', 'sliderRelatedPosts', 'bannerItems', 'latestPosts', 'mostReadPosts', 'bannerItems'));
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
    public function countViewBannerSpecialPage($id){
        BannersCategories::where('id', $id)->increment('viewed_count');
    }
}

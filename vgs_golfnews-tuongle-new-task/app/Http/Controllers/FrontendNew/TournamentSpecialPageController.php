<?php

namespace App\Http\Controllers\FrontendNew;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Menu;
use App\Models\BannersCategories;
use App\Models\TournamentCategories;
use App\Models\TournamentLiveScheldule;
// use App\Models\BannersSeagames;
use App\Models\Category;
use App\Models\TournamentLive;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

use Jenssegers\Agent\Agent;
use App;
use Illuminate\Support\Facades\App as AppSupport;

class TournamentSpecialPageController extends Controller
{
    private $pathViewController = 'frontend.pages.category.';
    private $controllerName = 'category';
    private $bannerTop = [];
    private $bannerBackground = [];
    private $bannerItems = [];
    private $bannerInPostItems = [];
    private $tournament_categories = [];
    private $category_id = [];
    public function __construct(Request $request)
    {
        

        $this->agent = new Agent();
        $id =$request->id ?? null;


        $menu = Menu::find($id);
        if($menu && $menu->status==1){

            $this->category_id = $menu->category_id;
            $tournament_categories= TournamentCategories::find($menu->tournament_categories_id);
        
        if($tournament_categories){
            $multi_language = $tournament_categories->multi_language;
            if($multi_language == 0){
                Session::put('locale', 'vi');

                AppSupport::setLocale('vi');

            }

        }
        }
           




        if (!empty($tournament_categories)) {
            $this->tournament_categories = $tournament_categories;
        }
        view()->share(['controllerName'=> $this->controllerName,
        'tournamentSpecialId'=> $id
]);

    }
    public function index(Request $request)
    {
        
        $keyCache = 'frontend-new.category.tournament.news.';
        $timeCache = 120;

        $id = $request->id;
        $category_id=$this->category_id;
        $tournament_categories = $this->tournament_categories;
        $category = Cache::remember("{$keyCache}{$id}{$category_id}", $timeCache, function () use ($category_id) {
            return Category::find($category_id);
        });
        $categories = [];
        if($category){
            $categories = $category->descendants()->pluck('id');

        $categories[] = $category->getKey();
        }
        $language = session('locale') == 'vi' ? 0 : 1;
        $sliderPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".sliderPosts.language" . $language, $timeCache, function () use ($categories, $language,$tournament_categories) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->take($tournament_categories->amount_slider_posts)->get();
        });



        $latestPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".latestPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".mostReadPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->mostRead()->take(3)->get();
        });

        $items = Cache::remember("frontend-new.tournament.".$id.$category_id.".items.language." . $language . ($request->page ?? 1), $timeCache, function () use ($categories, $language, $sliderPosts) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->whereNotIn('id', $sliderPosts->pluck('id'))->published()->latest('published_at_display')->paginate(4);
        });


        $itemsChunk = $items->chunk(4);




        $banner_category_id=$tournament_categories->banner_category_id;
        $whereBanner = [
            "category_id"=>$banner_category_id,
            "status" => 1,
            "is_home" =>1
    
        ];
        if ($this->agent->isMobile()) {
            $bannersTournamentTop = BannersCategories::select("id","name", "thumb", "url")->where("position", 1)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannersTournamentBackground = BannersCategories::select("id","name", "thumb", "url")->where("position", 2)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannerTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 3)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannerInPostTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 4)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
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


        
        $schedules = TournamentLiveScheldule::where('tournament_categories_id',$tournament_categories->id)->where('language',$language)->orderBy('order')->get();
        $tournament_categories_id = $tournament_categories->id;

        $live = Cache::remember("frontend-new.tournament.".$id.$category_id.".live.language." . $language, $timeCache, function () use ($tournament_categories_id) {
            return TournamentLive::where('type', 1)->where('status', 1)->where('tournament_categories_id',$tournament_categories_id)->orderBy('id', 'desc')->first();
        });
        $livescore = Cache::remember("frontend-new.tournament.".$id.$category_id.".livescore.language." . $language, $timeCache, function () use ($tournament_categories_id) {
            return TournamentLive::where('type', 2)->where('status', 1)->where('tournament_categories_id',$tournament_categories_id)->orderBy('id', 'desc')->first();
        });

        $schedules = Cache::remember("frontend-new.tournament.".$id.$category_id.".schedules.language." . $language, $timeCache, function () use ($tournament_categories_id,$language) {
            return TournamentLiveScheldule::where('tournament_categories_id',$tournament_categories_id)->where('language',$language)->orderBy('order')->get();

        });


        return view("frontend-new.pages.tournament.home", compact('live', 'livescore', 'sliderPosts', 'items', 'itemsChunk', 'category', 'mostReadPosts', 'latestPosts', 'bannerItems', 'bannerTop', 'bannerBackground','tournament_categories','schedules'));
    }
    public function news(Request $request)
    {
        $keyCache = 'frontend-new.category.detail.';
        $timeCache = 120;
        $language = session('locale') == 'vi' ? 0 : 1;

        $id = $request->id;

        $category_id=$this->category_id;
    
        $category = Cache::remember("{$keyCache}{$id}{$category_id}", $timeCache, function () use ($category_id) {
            return Category::find($category_id);
        });
        $categories = [];
        if($category){
            $categories = $category->descendants()->pluck('id');

        $categories[] = $category->getKey();
        }
        // $categories = $category->descendants()->pluck('id');
        // $categories[] = $category->getKey();


        $sliderPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".news.sliderPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        });





        $latestPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".news.latestPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".news.mostReadPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->take(3)->mostRead()->get();
        });
        $items = Cache::remember("frontend-new.tournament.".$id.$category_id.".news.items.language." . $language . ($request->page ?? 1), $timeCache, function () use ($categories, $language, $sliderPosts) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->whereNotIn('id', $sliderPosts->pluck('id'))->published()->latest('published_at_display')->paginate(6);
        });


        $tournament_categories = $this->tournament_categories;



        $banner_category_id=$tournament_categories->banner_category_id;
        $whereBanner = [
            "category_id"=>$banner_category_id,
            "status" => 1,
            "is_category" =>1
    
        ];
        if ($this->agent->isMobile()) {
            $bannersTournamentTop = BannersCategories::select("id","name", "thumb", "url")->where("position", 1)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannersTournamentBackground = BannersCategories::select("id","name", "thumb", "url")->where("position", 2)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannerTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 3)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannerInPostTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 4)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
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




        $itemsChunk = $items->chunk(4);

        return view("frontend-new.pages.tournament.news", compact('sliderPosts', 'items', 'itemsChunk', 'category', 'mostReadPosts', 'latestPosts', 'bannerTop', 'bannerBackground', 'bannerItems','tournament_categories'));
    }




    public function setLang($locale,Request $request)
    {
        if (array_key_exists($locale, Config::get('languages'))) {
            Session::put('locale', $locale);
        }
        return redirect()->route('category.special-page',['id' =>$request->input('id') ]);
    }
    public function live(Request $request)
    {
        $category_id=$this->category_id;
        $id = $request->id;

        $keyCache = 'frontend.category.detail.';
        $language = session('locale') == 'vi' ? 0 : 1;

        $timeCache = 120;

        $category = Cache::remember("{$keyCache}{$id}{$category_id}", $timeCache, function () use ($category_id) {
            return Category::find($category_id);
        });
        $categories = [];
        if($category){
            $categories = $category->descendants()->pluck('id');

        $categories[] = $category->getKey();
        }

        $latestPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".news.latestPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".news.mostReadPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->mostRead()->take(3)->get();
        });

       
     
        $tournament_categories = $this->tournament_categories;

        $live = TournamentLive::where('type', 1)->where('status', 1)->where('tournament_categories_id',$tournament_categories->id)->orderBy('id', 'desc')->first();
        $livescore = TournamentLive::where('type', 2)->where('status', 1)->where('tournament_categories_id',$tournament_categories->id)->orderBy('id', 'desc')->first();


        $banner_category_id=$tournament_categories->banner_category_id;
        $whereBanner = [
            "category_id"=>$banner_category_id,
            "status" => 1,
            "is_category" =>1
    
        ];
        if ($this->agent->isMobile()) {
            $bannersTournamentTop = BannersCategories::select("id","name", "thumb", "url")->where("position", 1)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannersTournamentBackground = BannersCategories::select("id","name", "thumb", "url")->where("position", 2)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannerTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 3)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannerInPostTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 4)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
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


        return view("frontend-new.pages.tournament.live", compact('live', 'livescore', 'latestPosts', 'mostReadPosts', 'bannerTop', 'bannerBackground', 'bannerItems','tournament_categories'));
    }
    public function liveScore(Request $request)
    {
        $keyCache = 'frontend.category.detail.';
        $timeCache = 120;
        $language = session('locale') == 'vi' ? 0 : 1;
        $category_id=$this->category_id;
        $id = $request->id;



        $category = Cache::remember("{$keyCache}{$id}{$category_id}", $timeCache, function () use ($category_id) {
            return Category::find($category_id);
        });
        $categories = [];
        if($category){
            $categories = $category->descendants()->pluck('id');

        $categories[] = $category->getKey();
        }

        $latestPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".news.latestPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        });
        $mostReadPosts = Cache::remember("frontend-new.tournament.".$id.$category_id.".news.mostReadPosts.language" . $language, $timeCache, function () use ($categories, $language) {
            return Post::with('category')->where(['language' => $language])->whereIn('category_id', $categories)->latestPublished()->mostRead()->take(3)->get();
        });




        $tournament_categories = $this->tournament_categories;
        $live = TournamentLive::where('type', 1)->where('status', 1)->where('tournament_categories_id',$tournament_categories->id)->orderBy('id', 'desc')->first();
        $livescore = TournamentLive::where('type', 2)->where('status', 1)->where('tournament_categories_id',$tournament_categories->id)->orderBy('id', 'desc')->first();


        $banner_category_id=$tournament_categories->banner_category_id;
        $whereBanner = [
            "category_id"=>$banner_category_id,
            "status" => 1,
            "is_category" =>1
    
        ];
        if ($this->agent->isMobile()) {
            $bannersTournamentTop = BannersCategories::select("id","name", "thumb", "url")->where("position", 1)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannersTournamentBackground = BannersCategories::select("id","name", "thumb", "url")->where("position", 2)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannerTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 3)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
            $bannerInPostTournamentItems = BannersCategories::select("id","name", "thumb", "url")->where("position", 4)->where("is_mobile", 1)->where($whereBanner)->get()->toArray();
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

        return view("frontend-new.pages.tournament.livescore", compact('live', 'livescore', 'latestPosts', 'mostReadPosts', 'bannerTop', 'bannerBackground', 'bannerItems','tournament_categories'));
    }
    public function addCountBannerClick(Request $request)
    {
        BannersCategories::where('id', $request->id)->increment('clicked_count');
        return response()->json(['success']);
    }
    public function countViewBannerSpecialPage($id){
        BannersCategories::where('id', $id)->increment('viewed_count');
    }

}

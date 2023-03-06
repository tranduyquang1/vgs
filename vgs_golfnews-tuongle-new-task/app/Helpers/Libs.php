<?php
/**
 * Calculator previous date from current date
 * @Return date ago
 */
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'năm',
        'm' => 'tháng',
        'w' => 'tuần',
        'd' => 'ngày',
        'h' => 'giờ',
        'i' => 'phút',
        's' => 'giây',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' trước' : 'tức thời';
}

/**
 * Group array by key
 * @param $array
 * @param $key
 * @return array
 */
function group_by($array, $key)
{
    $return = [];
    foreach ($array as $val) {
        $return[$val->$key][] = $val;
    }
    return $return;
}

function replaceSrcImg($contents)
{
    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $contents);
    $images = $doc->getElementsByTagName('img');
    foreach ($images as $img) {
        $url = $img->getAttribute('src');
        // do whatever you need to with $url
//        $url = 'https://cdn.golfnews.vn' . $url;


        $url = str_replace('golfnews.vn/upload-new', 'cdn.golfnews.vn/upload-new', $url);
        $img->setAttribute('src', $url);
    }
    return $doc->saveHTML();
}

function replaceSrcImgOld($contents)
{
    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $contents);
    $images = $doc->getElementsByTagName('img');
    foreach ($images as $img) {
        $url = $img->getAttribute('src');
        // do whatever you need to with $url
        if (str_contains($url, 'golfnews.vn/upload-new')) {
            $url = str_replace('golfnews.vn/upload-new', 'cdn.golfnews.vn/upload-new', $url);
        } else {
            $url = 'https://cdn.golfnews.vn' . $url;
        }

        $img->setAttribute('src', $url);
    }
    return $doc->saveHTML();
}

function getYoutubeID($url)
{
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
//    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
    return @$match[1];
}

function replaceYoutubeShortCode($content)
{
    $beginTag = '[youtube]';
    $endTag = '[/youtube]';
    $startsAt = strpos($content, $beginTag) + strlen($beginTag);
    $endsAt = strpos($content, $endTag);
    $youtubeURL = substr($content, $startsAt, $endsAt - $startsAt);
    $youtubeId = getYoutubeID($youtubeURL);

    $liteYoutute = '<lite-youtube videoid="' . $youtubeId . '" ></lite-youtube>';
//    posterquality="maxresdefault"

    $content = replace_all_text_between($content, $beginTag, $endTag, $liteYoutute);
    return $content;
}

function replace_all_text_between($str, $start, $end, $replacement)
{
    $start = preg_quote($start, '/');
    $end = preg_quote($end, '/');
    $regex = "/({$start})(.*?)({$end})/";

    return preg_replace($regex, $replacement, $str);
}

function imageSrc($item, $ratio = null)
{
    if ($item->is_old) {
        return 'https://cdn.golfnews.vn' . $item->thumbnail;
    } else {
        $thumb = '';
        switch ($ratio) {
            case '16x7':
                $thumb = $item->thumbnail_large;
                break;
            case '16x9':
                $thumb = $item->thumbnail;
                break;
            case '1x1':
                $thumb = $item->thumbnail_small ?? $item->thumbnail;
                break;
            default:
                $thumb = $item->thumbnail;
        }
        return cdn($thumb);
    }
}

function displayTimeDiffForHumans($value)
{
    return \Carbon\Carbon::parse($value)->diffForHumans();
}


if (!function_exists('cdn')) {
    function cdn($asset)
    {
        // Verify if KeyCDN URLs are present in the config file
        if (!Config::get('app.cdn'))
            return asset($asset);
        // Get file name incl extension and CDN URLs
        $cdns = Config::get('app.cdn');
        $assetName = basename($asset);
        // Remove query string
        $assetName = explode("?", $assetName);
        $assetName = $assetName[0];
        // Select the CDN URL based on the extension
        foreach ($cdns as $cdn => $types) {
            if (preg_match('/^.*\.(' . $types . ')$/i', $assetName))
                return cdnPath($cdn, $asset);
        }
        // In case of no match use the last in the array
        end($cdns);
        return cdnPath(key($cdns), $asset);
    }
}
if (!function_exists('cdnPath')) {
    function cdnPath($cdn, $asset)
    {
        return "//" . rtrim($cdn, "/") . "/" . ltrim($asset, "/");
    }
}
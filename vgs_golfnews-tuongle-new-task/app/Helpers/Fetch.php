<?php

namespace App\Helpers;

/**
 * Class Fetch
 * @package App\Helpers
 */
class Fetch
{
    /**
     * Fetch from link or file json
     * @param $path
     * @param bool $file
     * @param bool $toArray
     * @return mixed|null
     */
    public static function get($path, $file = false, $toArray = true)
    {
        try {
            if ($file)
                $result = json_decode(file_get_contents($path), true);
            else
                $result = json_decode(file_get_contents(url($path)), $toArray);
        } catch (\Exception $e) {
            $result = null;
        }
        return $result;
    }
}
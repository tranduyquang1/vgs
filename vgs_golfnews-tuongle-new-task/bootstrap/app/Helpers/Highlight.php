<?php

namespace App\Helpers;
/**
 * Class Highlight
 * @package App\Helpers
 */
class Highlight
{
    /**
     * Show and high light text search
     * @param $input
     * @param $paramsSearch
     * @param $field
     * @return string|string[]|null
     */
    public static function show($input, $paramsSearch, $field) // name
    {
        if ($paramsSearch['value'] == "") return $input;
        if ($paramsSearch['field'] == "all" || $paramsSearch['field'] == $field) {
            return preg_replace("/" . preg_quote($paramsSearch['value'], "/") . "/i", "<span class='highlight'>$0</span>", $input);
        }
        return $input;
    }

    /**
     * Create template rating
     * @param $number
     * @return string
     */
    public static function rate($number)
    {
        $xhtml = '';
        for ($i = 1; $i <= $number; $i++)
            $xhtml .= '★ ';
        return $xhtml;
    }

    /**
     * Create template list
     * @param $items
     * @return string
     */
    public static function list($items)
    {
        $xhtml = '<ul>';
        foreach ($items as $item)
            $xhtml .= '<li>' . $item . '</li>';
        $xhtml .= '</ul>';

        return $xhtml;
    }
}
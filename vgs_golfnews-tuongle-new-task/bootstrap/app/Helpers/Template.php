<?php

namespace App\Helpers;

use Config;

/**
 * Class Template
 * @package App\Helpers
 */
class Template
{
    /**
     * Show button filter (status, recall, order, contact)
     * @param $controllerName
     * @param $itemsStatusCount
     * @param $currentFilterStatus
     * @param $paramsSearch
     * @param $type
     * @return string|null
     */
    public static function showButtonFilter($controllerName, $itemsStatusCount, $currentFilterStatus, $paramsSearch, $type)
    { // $currentFilterStatus active inactive all
        $xhtml = null;
        $tmplStatus = Config::get('zvn.template.' . $type);

        if (count($itemsStatusCount) > 0) {
            array_unshift($itemsStatusCount, [
                'count' => array_sum(array_column($itemsStatusCount, 'count')),
                'status' => 'all'
            ]);

            foreach ($itemsStatusCount as $item) {  // $item = [count,status]
                $statusValue = $item['status'];  // active inactive block
                $statusValue = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default';

                $currentTemplateStatus = $tmplStatus[$statusValue]; // $value['status'] inactive block active
                $link = route($controllerName) . "?filter_status=" . $statusValue;

                if ($paramsSearch['value'] !== '') {
                    $link .= "&search_field=" . $paramsSearch['field'] . "&search_value=" . $paramsSearch['value'];
                }

                $class = ($currentFilterStatus == $statusValue) ? 'btn-danger' : 'btn-info';
                $xhtml .= sprintf('<a href="%s" type="button" class="btn %s">
                                            %s <span class="badge bg-white">%s</span>
                                        </a>', $link, $class, $currentTemplateStatus['name'], $item['count']);
            }
        }

        return $xhtml;
    }

    /**
     * Render block search & filter
     * @param $controllerName
     * @param $paramsSearch
     * @return string|null
     */
    public static function showAreaSearch($controllerName, $paramsSearch)
    {
        $xhtml = null;
        $tmplField = Config::get('zvn.template.search');
        $fieldInController = Config::get('zvn.config.search');

        $controllerName = (array_key_exists($controllerName, $fieldInController)) ? $controllerName : 'default';
        $xhtmlField = null;

        foreach ($fieldInController[$controllerName] as $field) {// all id
            $xhtmlField .= sprintf('<li><a href="#" class="select-field" data-field="%s">%s</a></li>', $field, $tmplField[$field]['name']);
        }

        $searchField = (in_array($paramsSearch['field'], $fieldInController[$controllerName])) ? $paramsSearch['field'] : "all";

        $xhtml = sprintf('
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle btn-active-field" data-toggle="dropdown" aria-expanded="false">
                        %s <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        %s
                    </ul>
                </div>
                <input type="text" name="search_value" value="%s" class="form-control" >
                <input type="hidden" name="search_field" value="%s">
                <span class="input-group-btn">
                    <button id="btn-clear-search" type="button" class="btn btn-success" style="margin-right: 0px">Xóa tìm kiếm</button>
                    <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                </span>
            </div>', $tmplField[$searchField]['name'], $xhtmlField, $paramsSearch['value'], $searchField);
        return $xhtml;
    }

    /**
     * Show item render datetime
     * @param $by
     * @param $time
     * @return string
     */
    public static function showItemHistory($by, $time)
    {
        $xhtml = sprintf(
            '<p><i class="fa fa-user"></i> %s</p>
            <p><i class="fa fa-clock-o"></i> %s</p>', $by, date('H:i:s d-m-Y', strtotime($time)));
        return $xhtml;
    }

    /**
     * Show Item button (status, order, recall, ...)
     * @param $controllerName
     * @param $id
     * @param $statusValue
     * @param $type
     * @return string
     */
    public static function showItemButton($controllerName, $id, $statusValue, $type)
    {
        $tmplStatus = Config::get('zvn.template.' . $type);
        $statusValue = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default';
        $currentTemplateStatus = $tmplStatus[$statusValue];
        $link = route($controllerName . '/status', ['status' => $statusValue, 'id' => $id]);

        $xhtml = sprintf(
            '<button type="button" data-link="%s" class="btn btn-round %s-ajax %s">%s</button>', $link, $type, $currentTemplateStatus['class'], $currentTemplateStatus['name']);
        return $xhtml;
    }

    /**
     * Show is full button
     * @param $controllerName
     * @param $id
     * @param $statusValue
     * @param $type
     * @return string
     */
    public static function showIsFullButton($controllerName, $id, $statusValue, $type)
    {
        $tmplStatus = Config::get('zvn.template.' . $type);
        $statusValue = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default';
        $currentTemplateStatus = $tmplStatus[$statusValue];
        $link = route($controllerName . '/is_full', ['status' => $statusValue, 'id' => $id]);

        $xhtml = sprintf(
            '<button type="button" data-link="%s" class="btn btn-round %s-ajax %s">%s</button>', $link, $type, $currentTemplateStatus['class'], $currentTemplateStatus['name']);
        return $xhtml;
    }

    /**
     * Show item custom link
     * @param $controllerName
     * @param $id
     * @param $statusValue
     * @param $type
     * @param $action
     * @return string
     */
    public static function showItemCustom($controllerName, $id, $statusValue, $type, $action)
    {
        $tmplStatus = Config::get('zvn.template.' . $type);
        $statusValue = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default';
        $currentTemplateStatus = $tmplStatus[$statusValue];
        $link = route($controllerName . '/' . $action, ['status' => $statusValue, 'id' => $id]);

        $xhtml = sprintf(
            '<button type="button" data-link="%s" class="btn btn-round %s-ajax %s">%s</button>', $link, $type, $currentTemplateStatus['class'], $currentTemplateStatus['name']);
        return $xhtml;
    }

    /**
     * Show button check isHome
     * @param $controllerName
     * @param $id
     * @param $isHomeValue
     * @return string
     */
    public static function showItemIsHome($controllerName, $id, $isHomeValue)
    {
        $tmplIsHome = Config::get('zvn.template.is_home');
        $isHomeValue = array_key_exists($isHomeValue, $tmplIsHome) ? $isHomeValue : 'yes';
        $currentTemplateIsHome = $tmplIsHome[$isHomeValue];
        $link = route($controllerName . '/isHome', ['is_home' => $isHomeValue, 'id' => $id]);

        $xhtml = sprintf(
            '<button type="button" data-link="%s" class="btn btn-round isHome-ajax %s">%s</button>', $link, $currentTemplateIsHome['class'], $currentTemplateIsHome['name']);
        return $xhtml;
    }

    /**
     * Show button check config product
     * @param $controllerName
     * @param $id
     * @param $config
     * @param $statusValue
     * @return string
     */
    public static function showItemConfigProduct($controllerName, $id, $config, $statusValue)
    {
        $tmplStatus = Config::get('zvn.template.config')[$config];
        $statusValue = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default';
        $currentTemplateStatus = $tmplStatus[$statusValue];
        $link = route($controllerName . '/config', ['config' => $config, 'value' => $statusValue, 'id' => $id]);

        $xhtml = sprintf(
            '<button type="button" data-link="%s" data-config="%s" class="btn btn-round config-ajax %s">%s</button>', $link, $config, $currentTemplateStatus['class'], $currentTemplateStatus['name']);
        return $xhtml;
    }

    /**
     * Select change attr ajax
     * @param $controllerName
     * @param $id
     * @param $arrValue
     * @param $displayValue
     * @param $fieldName
     * @param bool $showConfig
     * @return string
     */
    public static function showItemSelect($controllerName, $id, $arrValue, $displayValue, $fieldName, $showConfig = true)
    {
        $link = route($controllerName . '/attribute', ['id' => $id]);

        $xhtml = sprintf('<select name="select_change_attr" data-url="%s" data-field="%s" class="form-control select-ajax">', $link, $fieldName);

        foreach ($arrValue as $key => $value) {
            $xhtmlSelected = '';
            if ($key == $displayValue) $xhtmlSelected = 'selected="selected"';
            if ($showConfig)
                $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
            else
                $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value);
        }
        $xhtml .= '</select>';

        return $xhtml;
    }

    /**
     * Select2 change attr ajax
     *
     * @param $controllerName
     * @param $id
     * @param $arrValue
     * @param $displayValue
     * @param $fieldName
     * @param bool $showConfig
     * @return string
     */
    public static function showItemSelect2($controllerName, $id, $arrValue, $displayValue, $fieldName, $showConfig = true)
    {
        $link = route($controllerName . '/attribute', ['id' => $id]);

        $xhtml = sprintf('<select name="select_change_attr[]" data-url="%s" data-field="%s" class="form-control select-category select-ajax" multiple>', $link, $fieldName);

        foreach ($arrValue as $key => $value) {
            $xhtmlSelected = '';
            if (in_array($key, $displayValue)) $xhtmlSelected = 'selected="selected"';
            if ($showConfig)
                $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
            else
                $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value);
        }
        $xhtml .= '</select>';

        return $xhtml;
    }

    /**
     * Select change filter list
     * @param $field_name
     * @param $values
     * @param string $selected
     * @param bool $showConfig
     * @return string
     */
    public static function showSelectFilter($field_name, $values, $selected = 'default', $showConfig = true)
    {
        $xhtml = sprintf('<select name="select_filter" class="form-control" data-field="%s">', $field_name);
        foreach ($values as $key => $value) {
            $xhtmlSelected = '';
            if ((string)$key === $selected) {
                $xhtmlSelected = 'selected="selected"';
            }
            if ($showConfig)
                $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value['name']);
            else
                $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $xhtmlSelected, $value);
        }
        $xhtml .= '</select>';

        return $xhtml;
    }


    /**
     * Show input change value ajax
     * @param $controllerName
     * @param $id
     * @param $field
     * @param $value
     * @param null $class
     * @return string
     */
    public static function showInputAjax($controllerName, $id, $field, $value, $class = null)
    {
        $xhtml = sprintf('<input type="text" data-link="%s" data-field="%s" name="%s" class="field-ajax form-control %s" value="%s">', route($controllerName . '/attribute', ['id' => $id]), $field, $field, $class, $value);
        return $xhtml;
    }

    /**
     * Show textarea change value ajax
     * @param $controllerName
     * @param $id
     * @param $field
     * @param $value
     * @param null $class
     * @return string
     */
    public static function showTextareaAjax($controllerName, $id, $field, $value, $class = null)
    {
        $xhtml = sprintf('<textarea data-link="%s" data-field="%s" name="%s" class="field-ajax form-control %s">%s</textarea>', route($controllerName . '/attribute', ['id' => $id]), $field, $field, $class, $value);
        return $xhtml;
    }

    /**
     * Show image thumb upload input type="file"
     * @param $controllerName
     * @param $thumbName
     * @param $thumbAlt
     * @return string
     */
    public static function showItemThumb($controllerName, $thumbName, $thumbAlt)
    {
        $xhtml = sprintf(
            '<img src="%s" alt="%s" class="zvn-thumb">', asset("images/$controllerName/$thumbName"), $thumbAlt);
        return $xhtml;
    }

    /**
     * Show file upload input type="file"
     * @param $controllerName
     * @param $thumbName
     * @return string
     */
    public static function showItemFile($controllerName, $thumbName)
    {
        $xhtml = sprintf(
            '<a src="%s" download="">%s</a>', asset("images/$controllerName/$thumbName"), $thumbName);
        return $xhtml;
    }

    /**
     * Show input text
     * @param $name
     * @param $id
     * @param $value
     * @return string
     */
    public static function showItemInputOrder($name, $id, $value)
    {
        $xhtml = sprintf(
            '<input type="number" class="form-control input-ordering input-list-admin" name="%s[%s]" data-id="%s" value="%s" min="1"', $name, $id, $id, $value);
        return $xhtml;
    }

    /**
     * Show image thumb upload drop zone
     * @param $thumbName
     * @param $thumbAlt
     * @return string
     */
    public static function showItemThumbUpload($thumbName, $thumbAlt)
    {
        $xhtml = sprintf(
            '<img src="%s" alt="%s" class="zvn-thumb">', asset($thumbName), $thumbAlt);
        return $xhtml;
    }

    /**
     * Show button action: edit, delete, ...
     * @param $controllerName
     * @param $id
     * @return string
     */
    public static function showButtonAction($controllerName, $id)
    {
        $tmplButton = Config::get('zvn.template.button');
        $buttonInArea = Config::get('zvn.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : "default";
        $listButtons = $buttonInArea[$controllerName]; // ['edit', 'delete']

        $xhtml = '<div class="zvn-box-btn-filter">';

        foreach ($listButtons as $btn) {
            $currentButton = $tmplButton[$btn];

            $link = route($controllerName . $currentButton['route-name'], ['id' => $id]);
            $xhtml .= sprintf(
                '<a href="%s" type="button" class="btn btn-icon %s" data-toggle="tooltip" data-placement="top" 
                    data-original-title="%s">
                    <i class="fa %s"></i>
                </a>', $link, $currentButton['class'], $currentButton['title'], $currentButton['icon']);
        }

        $xhtml .= '</div>';

        return $xhtml;
    }

    /**
     * Render datetime frontend
     * @param $dateTime
     * @return false|string
     */
    public static function showDatetimeFrontend($dateTime)
    {
        return date_format(date_create($dateTime), Config::get('zvn.format.short_time'));
    }

    /**
     * Format currency
     * @param $value
     * @param null $prefix
     * @return int|string
     */
    public static function formatCurrency($value, $prefix = null)
    {
        if (is_numeric($value))
            return number_format($value, 0) . '' . $prefix;
        return 0;
    }

    /**
     * Show content sub charset
     * @param $content
     * @param $length
     * @param string $prefix
     * @return string
     */
    public static function substrContent($content, $length, $prefix = '...')
    {
        $prefix = ($length == 0) ? '' : $prefix;
        $content = str_replace(['<p>', '</p>'], '', $content);
        return preg_replace('/\s+?(\S+)?$/', '', substr($content, 0, $length)) . $prefix;
    }

    /**
     * Render button sort ordering
     * @param $controllerName
     * @param $items
     * @param $key
     * @param $val
     * @return string
     */
    public static function showBtnSort($controllerName, $items, $key, $val)
    {
        if (count($items) < 2)
            return '';

        $btnUp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $btnDown = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        if ($key == 0)
            $btnDown = '<a class="btn btn-info" href="' . route($controllerName . '/ordering', ['id_current' => $val->id, 'id_change' => $items[$key + 1]->id]) . '"><i class="fa fa-long-arrow-down"></i></a>';
        else if ($key == count($items) - 1)
            $btnUp = '<a class="btn btn-warning" href="' . route($controllerName . '/ordering', ['id_current' => $val->id, 'id_change' => $items[$key - 1]->id]) . '"><i class="fa fa-long-arrow-up"></i></a>';
        else {
            $btnDown = '<a class="btn btn-info" href="' . route($controllerName . '/ordering', ['id_current' => $val->id, 'id_change' => $items[$key + 1]->id]) . '"><i class="fa fa-long-arrow-down"></i></a>';
            $btnUp = '<a class="btn btn-warning" href="' . route($controllerName . '/ordering', ['id_current' => $val->id, 'id_change' => $items[$key - 1]->id]) . '"><i class="fa fa-long-arrow-up"></i></a>';
        }

        return $btnDown . $btnUp;
    }

    /**
     * Render button sort ordering (Nested Set Model)
     * @param $prefix
     * @param $arrElms
     * @param $idCurrent
     * @param null $option
     * @return string
     */
    public static function showBtnOrdering($prefix, $arrElms, $idCurrent, $option = null)
    {
        $arrParamsRouter = [
            'menuLanding' => [
                'up' => ['type' => 'up', 'id' => $idCurrent],
                'down' => ['type' => 'down', 'id' => $idCurrent]
            ],
            'cateNews' => [
                'up' => ['type' => 'up', 'id' => $idCurrent],
                'down' => ['type' => 'down', 'id' => $idCurrent]
            ],
            'cateProduct' => [
                'up' => ['type' => 'up', 'id' => $idCurrent],
                'down' => ['type' => 'down', 'id' => $idCurrent]
            ],
            'menuHeader' => [
                'up' => ['type' => 'up', 'id' => $idCurrent],
                'down' => ['type' => 'down', 'id' => $idCurrent]
            ],
            'menuMain' => [
                'up' => ['type' => 'up', 'id' => $idCurrent],
                'down' => ['type' => 'down', 'id' => $idCurrent]
            ],
            'menuFooter' => [
                'up' => ['type' => 'up', 'id' => $idCurrent],
                'down' => ['type' => 'down', 'id' => $idCurrent]
            ],
            'default' => [
                'up' => ['type' => 'up', 'id' => $idCurrent],
                'down' => ['type' => 'down', 'id' => $idCurrent]
            ]
        ];

        $prefix = !empty($prefix) ? $prefix : 'default';

        if ($option['task'] == 'ordering-menu') {
            $idParent = $option['id_parent'];
            $siblings = self::getSiblingsAndSelfByParent($arrElms, $idParent);
            $elmMin = reset($siblings);
            $elmMax = end($siblings);
            $idMin = $elmMin['id'];
            $idMax = $elmMax['id'];
            $url_up = route($prefix . '/ordering', $arrParamsRouter[$prefix]['up']);
            $url_down = route($prefix . '/ordering', $arrParamsRouter[$prefix]['down']);
        }

        if ($option['task'] == 'ordering-content') {
            $elmMin = reset($arrElms);
            $elmMax = end($arrElms);
            $idMin = $elmMin['id'];
            $idMax = $elmMax['id'];
            $id_menu = $elmMin['id_menu'];
            $url_up = route($prefix . '/ordering', array_merge($arrParamsRouter[$prefix]['up'], ['id_menu' => $id_menu]));
            $url_down = route($prefix . '/ordering', array_merge($arrParamsRouter[$prefix]['down'], ['id_menu' => $id_menu]));
        }

        switch ($idCurrent) {
            case $idMin:
                $xhtml = '<a href="' . $url_down . '" class="btn btn-info"><i class="fa fa-long-arrow-down"></i></a>';
                break;
            case $idMax:
                $xhtml = '<a href="' . $url_up . '" class="btn btn-info"><i class="fa fa-long-arrow-up"></i></a>';
                break;
            default:
                $xhtml = '<a href="' . $url_down . '" class="btn btn-info"><i class="fa fa-long-arrow-down"></i></a>';
                $xhtml .= '<a href="' . $url_up . '" class="btn btn-info"><i class="fa fa-long-arrow-up"></i></a>';
                break;
        }

        return $xhtml;
    }

    /**
     * getSiblingsAndSelfByParent function
     * @param $arrElms
     * @param $idParent
     * @return array
     */
    public static function getSiblingsAndSelfByParent($arrElms, $idParent)
    {
        $arrSiblings = [];
        $arrElms = $arrElms->toArray()['data'];
        foreach ($arrElms as $k => $arrElm) {
            if ($arrElm['parent_id'] == $idParent) {
                array_push($arrSiblings, $arrElms[$k]);
            }
        }
        uasort($arrSiblings, function ($a, $b) {
            if ($a['_lft'] == $b['_lft']) {
                return 0;
            }
            return ($a['_lft'] < $b['_lft']) ? -1 : 1; //asc
        });

        return $arrSiblings;
    }

    /* Render input upload image */
    public static function uploadImage($name, $value)
    {
        $src = (!empty($value)) ? request()->getSchemeAndHttpHost() . $value : '';
        return '<div class="form-group">
                        <label for="description_short" class="control-label col-md-3 col-sm-3 col-xs-12">' . ucwords($name) . '</label>
                        <div class="col-md-8 col-sm-10 col-xs-12">
                            <div class="d-flex algin-items-center">
                                <div class="input-group" style="margin-right: 10px">
                                   <span class="input-group-btn">
                                     <a data-input="image_main" data-preview="holder_main" class="btn btn-primary lfm">
                                       <i class="fa fa-picture-o"></i> Chọn ảnh
                                     </a>
                                   </span>
                                   <input id="image_main" class="form-control" type="hidden" name="' . $name . '" value="' . $value . '">
                                </div>
                                <img id="holder_main" src="' . $src . '" class="mb-4 img-fluid image-preview" style="max-height:60px;">
                           </div>
                        </div>
                    </div>';
    }
}

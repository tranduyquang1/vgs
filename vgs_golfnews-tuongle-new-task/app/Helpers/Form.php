<?php

namespace App\Helpers;

use Config;

/**
 * Class Form
 * @package App\Helpers
 */
class Form
{
    /**
     * Render all form element
     * @param $elements
     * @return string|null
     */
    public static function show($elements)
    {
        $xhtml = null;
        foreach ($elements as $element) {
            $xhtml .= self::formGroup($element);
        }
        return $xhtml;
    }

    /**
     * Render form-group element
     * @param $element
     * @return string|null
     */
    public static function radioShowModalSpecialPage($name, $id, $value, $class="", $selected=false, $option=null){
        $xhtml = sprintf('<input type="radio"  name="%s" id="%s" value="%s" class="%s" %s %s >',$name, $id, $value, $class, $selected, $option);
        return $xhtml;
    }
    public static function formGroup($element)
    {
        $type = isset($element['type']) ? $element['type'] : "input";
        $xhtml = null;

        switch ($type) {
            case 'input':
                $xhtml .= sprintf(
                    '<div class="form-group">
                        %s
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            %s
                        </div>
                    </div>', $element['label'], $element['element']
                );
                break;
            case 'thumb':
                $xhtml .= sprintf(
                    '<div class="form-group">
                        %s
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            %s
                            <p style="margin-top: 50px;">%s</p>
                        </div>
                    </div>', $element['label'], $element['element'], $element['thumb']
                );
                break;
            case 'avatar':
                $xhtml .= sprintf(
                    '<div class="form-group">
                        %s
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            %s
                            <p style="margin-top: 50px;">%s</p>
                        </div>
                    </div>', $element['label'], $element['element'], $element['avatar']
                );
                break;
            case 'radio':
                $xhtml = '';
                foreach ($element['element'] as $label => $radio)
                    $xhtml .= '<div class="radio radio-inline"><label>' . $radio . $label . '</label></div>';
                $xhtml = sprintf(
                    '<div class="form-group d-flex align-items-center"> 
                        %s
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            %s
                        </div>
                    </div>', $element['label'], $xhtml);
                break;
            case 'radio-show-modal-menu':
                $xhtml = '';
                foreach ($element['element'] as $label => $radio)
                    $xhtml .= '<div class="radio radio-inline"><label>' . $radio . $label . '</label></div>';
                $xhtml = sprintf(
                    '<div class="form-group d-flex align-items-center"> 
                        %s
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            %s
                        </div>
                    </div>', $element['label'], $xhtml);
                break;
            case 'checkbox':
                $xhtml = '';
                foreach ($element['element'] as $label => $checkbox)
                    $xhtml .= '<div class="checkbox radio-inline"><label>' . $checkbox . $label . '</label></div>';
                $xhtml = sprintf(
                    '<div class="form-group d-flex align-items-center"> 
                        %s
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            %s
                        </div>
                    </div>', $element['label'], $xhtml);
                break;
            case 'input-checkbox':
                $xhtml = sprintf(
                    '<div class="form-group d-flex align-items-center"> 
                        %s
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            %s
                        </div>
                         %s
                    </div>
                   
                    ', $element['label'], $element['element'], @$element['checkbox']);
                break;
            case 'input-checkbox-col-5':
                $xhtml = sprintf(
                    '<div class="form-group d-flex align-items-center"> 
                        %s
                        <div class="col-md-5 col-sm-5 col-xs-6">
                            %s
                        </div>
                         %s
                    </div>
                   
                    ', $element['label'], $element['element'], $element['checkbox']);
                break;
            case 'input-color':
                $xhtmlColor = '';
                foreach ($element['element'] as $color)
                    $xhtmlColor .= sprintf('<div class="mr-2 d-flex align-items-center"> %s %s</div>', $color->toHtml(), $element['delete']->toHtml());
                $xhtml = sprintf(
                    '<div class="form-group d-flex align-items-center mb-6""> 
                        %s
                        <div class="col-xs-10 col-sm-8 col-xs-8 d-flex align-items-center">
                           %s %s
                        </div>
                    </div>', $element['label'], $xhtmlColor, $element['button']);
                break;
            case 'btn-submit':
                $xhtml .= sprintf(
                    '<div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-sm-offset-3">
                            %s
                        </div>
                    </div>', $element['element']
                );
                break;
            case 'btn-submit-edit':
                $xhtml .= sprintf(
                    '<div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                            %s
                        </div>
                    </div>', $element['element']
                );
                break;
            default:
                $xhtml = sprintf(
                    '<div class="form-group"> 
                        %s
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            %s
                        </div>
                    </div>', $element['label'], $element['element']);
                break;
        }
        return $xhtml;
    }

}



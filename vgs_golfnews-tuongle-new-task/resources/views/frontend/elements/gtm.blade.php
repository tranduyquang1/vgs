@php
    $settingMain = \App\Helpers\Fetch::get(public_path('cache/setting-script.json'), true);
@endphp
{!! $settingMain['script_head'] !!}
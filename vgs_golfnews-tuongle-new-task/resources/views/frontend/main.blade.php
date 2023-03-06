@php ob_start() @endphp
<!DOCTYPE html>
<html dir="ltr" lang="en">
    @include('frontend.elements.head')
    <body class="stretched">
        <div id="wrapper" class="clearfix">
        @include('frontend.elements.header')
        @yield('content')
        @include('frontend.elements.footer')

        </div>
        <div id="gotoTop" class="icon-angle-up"></div>
        @include('frontend.elements.script')
    </body>
</html>
@php
    $content = ob_get_clean();
    echo \App\Libs\TinyMinify\TinyMinify::html($content, $options = [
        'collapse_whitespace' => true,
        'collapse_json_lt' => true, // WARNING - EXPERIMENTAL FEATURE
    ]);
@endphp
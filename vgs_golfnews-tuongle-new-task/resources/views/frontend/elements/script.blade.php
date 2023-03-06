{{--<script type="text/javascript" src="{{ asset('frontend/assets/js/combine-all-assets.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('frontend/assets/js/myScript.js?v='.time())}}"></script>--}}

{{--@php--}}
{{--    $settingMain = \App\Helpers\Fetch::get(public_path('cache/setting-script.json'), true);--}}
{{--@endphp--}}
{{--{!! $settingMain['google_analyst'] !!}--}}
{{-- <script src="{{ asset('frontend/js/jquery.js') }}"></script>
<script src="{{ asset('frontend/js/plugins.min.js') }}"></script>
<script src="{{ asset('frontend/js/functions.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('frontend/assets/js/combine-all-assets.min.js') }}"></script>
<script type="module"  src="{{ asset('frontend/js/lite-youtube.js') }}"></script>
<script src="{{ asset('frontend/js/myScript.js?v=' . time()) }}"></script>
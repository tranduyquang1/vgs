<script src="{{ asset('backend/asset/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('backend/asset/nprogress/nprogress.js') }}"></script>
<script src="{{ asset('backend/js/notify.min.js') }}"></script>
<script src="{{ asset('backend/asset/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<script src="{{ asset('backend/asset/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('backend/asset/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('backend/asset/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('backend/js/ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('backend/js/simple.money.format.js')}}"></script>
<script src="{{ asset('backend/js/lfm.js')}}"></script>
<script src="{{ asset('backend/js/custom.js') }}"></script>
<script src="{{ asset('backend/js/myScript.js?v='.time()) }}"></script>

{{-- Custom upload image ckedtior --}}
<script>
    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };
    CKEDITOR.replace('ckeditor', options);
</script>
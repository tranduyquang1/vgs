$(document).ready(function() {
    let $btnSearch = $("button#btn-search");
    let $btnClearSearch = $("button#btn-clear-search");
    let $inputSearchField = $("input[name=search_field]");
    let $inputSearchValue = $("input[name=search_value]");
    let $statusAjax = $("button.status-ajax");
    let $bccContactAjax = $("button.bcc_contact-ajax");
    let $categoryName = $("input[name=name]");
    let $categorySlug = $("input[name=slug]");
    let $selectAttr = $("select.select-ajax");
    let $selectFilter = $("select[name=select_filter]");
    let $selectFilterCustom = $("select[name=select_filter_custom]");
    let $price_default = $("input[name=price_default]");
    let $inputOrdering = $("input.input-ordering");
    let $fieldAjax = $('.field-ajax');
    var $statusCourseAjax = $("button.status_course-ajax");
    var $statusTuitionAjax = $("button.tuition_status-ajax");
    var $statusUserAjax = $("button.user_status-ajax");
    var $isHomeAjax = $("button.isHome-ajax");
    var $isShowFrontendAjax = $("button.show-frontend-ajax");
    let $alert = $('.alert');
    let $datepicker = $('.datepicker');
    let $lfm = $('.lfm');
    let $selectCategory = $('.select-category');
    let $searchFilter = $('.search-filter');
    let $btnMail = $('.btn-mail');
    let $btnDeleteAjax = $('.btn-delete-ajax');
    let $specialAjax = $("button.special-ajax");
    let $lockAjax = $("button.lock-ajax");
    let $contactsAjax = $("button.contact-ajax");
    let $datepickerMonth = $('.datepicker-month');
    let $selectMulti = $('.select-multi');

    // Init Tagify
    document.querySelectorAll('.zvn-tagify').forEach((element) => {
        new Tagify(element);
    });

    // Notify message livewire
    window.addEventListener('alert', ({ detail: { type, message } }) => {
        $(this.activeElement);
        $(this.activeElement).notify(message, {
            className: type,
            autoHideDelay: 1000,
            elementPosition: 'top center'
        });
    });

    // Preview Image Before Upload
    $('.image-upload-with-preview').on('change', function(e) {
        let image = $(this).parent().find('.zvn-thumb');
        image.attr('src', URL.createObjectURL(e.target.files[0]));
    });

    // Nestable2
    let categoryTree = $('#nestable-category');
    categoryTree
        .nestable({
            /* config options */
        })
        .on('change', function() {
            const dataSend = categoryTree.nestable('serialize');
            $.ajax({
                type: 'POST',
                url: categoryTree.data('url'),
                data: {
                    data: dataSend,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                },
            });
        });

    $selectMulti.select2();

    // init library
    $selectCategory.select2();
    $price_default.simpleMoneyFormat();
    $lfm.filemanager('image');
    $datepicker.datepicker({
        format: 'dd-mm-yyyy'
    });
    $alert.delay(2500).hide(1000);

    // select field
    $("a.select-field").click(function(e) {
        e.preventDefault();
        let field = $(this).data('field');
        let fieldName = $(this).html();
        $("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
        $inputSearchField.val(field);
    });

    /* search */
    $btnSearch.click(function() {

        var pathname = window.location.pathname;
        let params = ['filter_status'];
        let searchParams = new URLSearchParams(window.location.search); // ?filter_status=active

        let link = "";
        $.each(params, function(key, param) { // filter_status
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&" // filter_status=active
            }
        });

        let search_field = $inputSearchField.val();
        let search_value = $inputSearchValue.val();

        if (search_value.replace(/\s/g, "") == "") {
            alert("Nhập vào giá trị cần tìm !");
        } else {
            window.location.href = pathname + "?" + link + 'search_field=' + search_field + '&search_value=' + search_value;
        }
    });

    /* filter status */
    $btnClearSearch.click(function() {
        var pathname = window.location.pathname;
        let searchParams = new URLSearchParams(window.location.search);

        params = ['filter_status'];

        let link = "";
        $.each(params, function(key, param) {
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&"
            }
        });

        window.location.href = pathname + "?" + link.slice(0, -1);
    });

    /* confirm delete */
    $('.btn-delete').on('click', function() {
        if (!confirm('Bạn có chắc muốn xóa phần tử?')) return false;
    });

    $btnDeleteAjax.on('click', function(e) {
        e.preventDefault();
        if (!confirm('Bạn có chắc muốn xóa phần tử?')) return false;
        const href = $(e.target).attr("href");
        const id = $(e.target).data("id");

        $.ajax({
            url: href,
            type: "GET",
            dataType: "json",
            success: function() {
                console.log($('.row-item[data-id="' + id + '"]'));
                $('.row-item[data-id="' + id + '"]').remove();
            }
        });
    });

    /* change status */
    $statusAjax.on('click', function() {
        let link = $(this).data('link');
        let $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function(result) {
                if (result.status) {
                    if (result.response === 'active') $selector.removeClass('btn-info').addClass('btn-success').text('Kích hoạt').data('link', result.link);
                    else $selector.removeClass('btn-success').addClass('btn-info').text('Chưa kích hoạt').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });
                } else {
                    console.log(result.error)
                }
            }
        });
    });

    /* change Bcc contact */
    $bccContactAjax.on('click', function() {
        let link = $(this).data('link');
        let $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function(result) {
                if (result.status) {
                    if (result.response === 'active') $selector.removeClass('btn-warning').addClass('btn-primary').text('Bật').data('link', result.link);
                    else $selector.removeClass('btn-primary').addClass('btn-warning').text('Tắt').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });
                } else {
                    console.log(result.error)
                }
            }
        });
    });

    $specialAjax.on('click', function() {
        let link = $(this).data('link');
        let $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function(result) {
                if (result.status) {
                    if (result.response === 1) $selector.removeClass('btn-info').addClass('btn-success').text('Có').data('link', result.link);
                    else $selector.removeClass('btn-success').addClass('btn-info').text('Không').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 1500,
                        elementPosition: 'top left'
                    });
                } else {
                    console.log(result.error)
                }
            }
        });
    });

    $lockAjax.on('click', function() {
        let link = $(this).data('link');
        let $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function(result) {
                if (result.status) {
                    if (result.response === 1) $selector.removeClass('btn-info').addClass('btn-danger').text('Đã khóa').data('link', result.link);
                    else $selector.removeClass('btn-danger').addClass('btn-info').text('Không khóa').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 1500,
                        elementPosition: 'top left'
                    });
                } else {
                    console.log(result.error)
                }
            }
        });
    });

    /* create slug of category */
    $categoryName.on('change', function() {
        let categoryName = $(this).val();
        if ($categorySlug.val() === '') $categorySlug.val(to_slug(categoryName));
    });

    /* Change attr select box */
    $selectAttr.on('change', function() {
        let url = $(this).data('url');
        let field = $(this).data('field');
        let value = $(this).val();
        let $selector = $(this);
        $.ajax({
            url: url,
            type: "GET",
            data: {
                'field': field,
                'value': value
            },
            dataType: "json",
            success: function(result) {
                if (result.status) {
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });
                } else {
                    console.log(result.error)
                }
            }
        });
    });

    $fieldAjax.on('change', function(e) {
        let value = $(this).val();
        let field = $(this).data('field');
        let link = $(this).data('link');
        let $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            data: {
                'field': field,
                'value': value
            },
            dataType: "json",
            success: function(result) {
                if (result.status) {
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });
                } else {
                    console.log(result.error)
                }
            }
        });
    });

    $statusCourseAjax.on('click', function() {
        var link = $(this).data('link');
        var $selector = $(this);
        // alert(link);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function success(result) {
                // console.log(result);
                if (result.status) {
                    if (result.response === 1) $selector.removeClass('btn-info').addClass('btn-success').text('Kích hoạt').data('link', result.link);
                    else $selector.removeClass('btn-success').addClass('btn-info').text('Chưa kích hoạt').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 1500,
                        elementPosition: 'top left'
                    });
                    location.reload();
                } else {
                    console.log(result.error);
                }
            }
        });
    });

    $statusTuitionAjax.on('click', function() {
        var link = $(this).data('link');
        var $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function success(result) {
                // console.log(result);
                if (result.status) {
                    if (result.response === 'active') $selector.removeClass('btn-info').addClass('btn-success').text('Ưu đãi').data('link', result.link);
                    else $selector.removeClass('btn-success').addClass('btn-info').text('Không ưu đãi').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 1500,
                        elementPosition: 'top left'
                    });
                    location.reload();
                } else {
                    console.log(result.error);
                }
            }
        });
    });

    $statusUserAjax.on('click', function() {
        var link = $(this).data('link');
        var $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function success(result) {
                if (result.status) {
                    if (result.response === 1) $selector.removeClass('btn-info').addClass('btn-success').text('Kích hoạt').data('link', result.link);
                    else $selector.removeClass('btn-success').addClass('btn-info').text('Chưa kích hoạt').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 1500,
                        elementPosition: 'top left'
                    });
                } else {
                    console.log(result.error);
                }
            }
        });
    });

    $isHomeAjax.on('click', function() {
        var link = $(this).data('link');
        var $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function success(result) {
                if (result.status) {
                    if (result.response === 'yes') $selector.removeClass('btn-warning').addClass('btn-primary').text('Hiện thị').data('link', result.link);
                    else $selector.removeClass('btn-primary').addClass('btn-warning').text('Không hiển thị').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 1500,
                        elementPosition: 'top left'
                    });
                    location.reload();
                } else {
                    console.log(result.error);
                }
            }
        });
    });

    $isShowFrontendAjax.on('click', function() {
        var link = $(this).data('link');
        var $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function success(result) {
                if (result.status) {
                    if (result.response === 1) $selector.removeClass('btn-warning').addClass('btn-primary').text('Hiện thị').data('link', result.link);
                    else $selector.removeClass('btn-primary').addClass('btn-warning').text('Không hiển thị').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 1500,
                        elementPosition: 'top left'
                    });
                } else {
                    console.log(result.error);
                }
            }
        });
    });

    $contactsAjax.on('click', function() {
        let link = $(this).data('link');
        let $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function(result) {
                if (result.status) {
                    if (result.response === 'active') $selector.removeClass('btn-info').addClass('btn-success').text('Đã liên hệ').data('link', result.link);
                    else $selector.removeClass('btn-success').addClass('btn-info').text('Chưa liên hệ').data('link', result.link);
                    $selector.notify("Cập nhật thành công!", {
                        className: 'success',
                        autoHideDelay: 1500,
                        elementPosition: 'top left'
                    });
                } else {
                    console.log(result.error)
                }
            }
        });
    });


    $btnMail.on('click', function() {
        let link = $(this).data('link');
        let $selector = $(this);
        $selector.addClass('disabled');
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function(result) {
                $selector.removeClass('disabled');
                if (result.status) {
                    $selector.notify("Gửi mail thành công!", {
                        className: 'success',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });
                } else {
                    $selector.notify(result.message, {
                        className: 'error',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });
                    console.log(result.error)
                }
            }
        });
    });

    let paramsDefine = ['filter_group_id', 'filter_level_id', 'filter_division_id', 'filter_post_status', 'filter_post_format', 'filter_post_is_on_slider', 'filter_post_is_hot_news', 'filter_category_id', 'filter_category', 'filter_teacher', 'filter_supporter', 'filter_course_id', 'filter_show_is_home', 'filter_question', 'filter_page', 'filter_position', 'filter_user_level', 'filter_type', 'filter_is_mobile'];
    $selectFilter.on('change', function() {
        var pathname = window.location.pathname;
        let searchParams = new URLSearchParams(window.location.search);

        params = [...['page', 'filter_status', 'search_field', 'search_value'], ...paramsDefine];

        let link = "";
        $.each(params, function(key, value) {
            if (searchParams.has(value)) {
                link += value + "=" + searchParams.get(value) + "&"
            }
        });
        let select_field = $(this).data('field');
        let select_value = $(this).val();
        if (link === '') window.location.href = pathname + '?select_field=' + select_field + '&select_value=' + select_value;
        else window.location.href = pathname + "?" + link.slice(0, -1) + '&select_field=' + select_field + '&select_value=' + select_value;
    });

    $selectFilterCustom.on('change', function() {
        let select_field = $(this).data('field');
        let select_value = $(this).val();
        var pathname = window.location.pathname;
        let searchParams = new URLSearchParams(window.location.search);
        let paramsCustom = paramsDefine.filter(item => item !== `filter_${select_field}`);
        params = [...['page', 'filter_status', 'search_field', 'search_value'], ...paramsCustom];
        let link = "";
        $.each(params, function(key, value) {
            if (searchParams.has(value)) {
                link += value + "=" + searchParams.get(value) + "&"
            }
        });
        if (link === '') window.location.href = pathname + '?filter_' + select_field + '=' + select_value;
        else window.location.href = pathname + "?" + link.slice(0, -1) + '&filter_' + select_field + '=' + select_value;
    });

    /* checkbox ordering */
    $inputOrdering.on('change', function() {
        let id = $(this).data('id');
        let $selector = $('input[name="cid[' + id + ']"]');
        $selector.attr('checked', true);
        $selector.parent().addClass('checked');
        $selector.parent().parent().addClass('selected');
    });

    $('.modal').on('show.bs.modal', (e) => {
        $('.datepicker-modal').datepicker({
            format: 'dd-mm-yyyy'
        });
    })

    // search filter files 
    $searchFilter.on('change', (e) => {
        let sheetId = $(e.target).data('sheet');
        let $form = $('.search-filter-form[data-sheet="' + sheetId + '"]')
        $.ajax({
            url: $form.attr('action'),
            type: 'GET',
            data: $form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    let ids = response.message;
                    $('.row-item').addClass('d-none');
                    ids.forEach((item, index) => {
                        $('.row-item[data-id="' + item.id + '"]').removeClass('d-none');
                    })


                } else {
                    console.log(response.message)
                }
            }
        });
    });

    $('.outline-filter select[name="chapter_id"]').on('change', (e) => {
        let url = $('.outline-filter').data('link');
        let value = $(e.target).val();
        window.location.href = url + '?chapter_id=' + value;
    });

    $('.outline-filter select[name="lesson_id"]').on('change', (e) => {
        let url = $('.outline-filter').data('link');
        let chapterId = $('.outline-filter select[name="chapter_id"]').val();
        let value = $(e.target).val();
        window.location.href = url + '?chapter_id=' + chapterId + '&lesson_id=' + value;
    });

    $('.btn-add-video').on('click', () => {
        $('.videos-form').toggleClass('d-none');
        $('.videos-import').addClass('d-none');
    });

    $('.btn-import-video').on('click', () => {
        $('.videos-import').toggleClass('d-none');
        $('.videos-form').addClass('d-none');
    });

    $datepickerMonth.datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months"
    });

    $datepickerMonth.change((e) => {
        let value = $(e.target).val();
        window.location.href = updateQueryStringParameter(window.location.href, 'filter_month', value);
    });

    $('.btn-modal-youtube').on('click', (e) => {
        $(e.target).find('i').trigger('click');
    })

    $('.btn-modal-youtube i').on('click', (e) => {
        let id = $(e.target).parent().data('id');
        $('#youtube-modal iframe').attr('src', 'https://www.youtube.com/embed/' + id);
        $('#youtube-modal').modal('show');
    });

    $('#youtube-modal').on('hidden.bs.modal', function(e) {
        $(e.target).find('iframe').attr('src', '');
    });

    $('.currency').simpleMoneyFormat();
});

function to_slug(str) {
    str = str.toLowerCase();
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
    str = str.replace(/([^0-9a-z-\s])/g, '');
    str = str.replace(/(\s+)/g, '-');
    str = str.replace(/^-+/g, '');
    str = str.replace(/-+$/g, '');
    return str;
}

function updateQueryStringParameter(uri, key, value) {
    let re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    let separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
        return uri + separator + key + "=" + value;
    }
}
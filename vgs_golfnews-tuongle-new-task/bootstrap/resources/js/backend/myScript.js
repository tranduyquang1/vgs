$(document).ready(function () {
    let $btnSearch = $("button#btn-search");
    let $btnClearSearch = $("button#btn-clear-search");
    let $inputSearchField = $("input[name=search_field]");
    let $inputSearchValue = $("input[name=search_value]");
    let $statusAjax = $("button.status-ajax");
    let $bccContactAjax = $("button.bcc_contact-ajax");
    let $categoryName = $("input[name=name]");
    let $categorySlug = $("input[name=slug]");
    let $selectAttr = $("select.select-ajax");
    let $selectFilter = $("select[name = select_filter]");
    let $price_default = $("input[name=price_default]");
    let $inputOrdering = $("input.input-ordering");
    let $fieldAjax = $('.field-ajax');
    let $alert = $('.alert');
    let $datepicker = $('.datepicker');
    let $lfm = $('.lfm');
    let $selectCategory = $('.select-category');
    let $btnAddView = $('.btn-view-add');
    let $btnBlockCont = $('.btn-block-cont');
    let $searchFilter = $('.search-filter');
    let $btnMail = $('.btn-mail');
    let $btnExportSearch = $('.btn-export-search');

    // init library
    $selectCategory.select2();
    $price_default.simpleMoneyFormat();
    $lfm.filemanager('image');
    $datepicker.datepicker({
        format: 'dd-mm-yyyy'
    });
    $alert.delay(2500).hide(1000);

    // select field
    $("a.select-field").click(function (e) {
        e.preventDefault();
        let field = $(this).data('field');
        let fieldName = $(this).html();
        $("button.btn-active-field").html(fieldName + ' <span class="caret"></span>');
        $inputSearchField.val(field);
    });

    /* search */
    $btnSearch.click(function () {

        var pathname = window.location.pathname;
        let params = ['filter_status'];
        let searchParams = new URLSearchParams(window.location.search);	// ?filter_status=active

        let link = "";
        $.each(params, function (key, param) { // filter_status
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&" // filter_status=active
            }
        });

        let search_field = $inputSearchField.val();
        let search_value = $inputSearchValue.val();

        if (search_value.replace(/\s/g, "") == "") {
            alert("Nh???p v??o gi?? tr??? c???n t??m !");
        } else {
            window.location.href = pathname + "?" + link + 'search_field=' + search_field + '&search_value=' + search_value;
        }
    });

    /* filter status */
    $btnClearSearch.click(function () {
        var pathname = window.location.pathname;
        let searchParams = new URLSearchParams(window.location.search);

        params = ['filter_status'];

        let link = "";
        $.each(params, function (key, param) {
            if (searchParams.has(param)) {
                link += param + "=" + searchParams.get(param) + "&"
            }
        });

        window.location.href = pathname + "?" + link.slice(0, -1);
    });

    /* confirm delete */
    $('.btn-delete').on('click', function () {
        if (!confirm('B???n c?? ch???c mu???n x??a ph???n t????'))
            return false;
    });

    /* change status */
    $statusAjax.on('click', function () {
        let link = $(this).data('link');
        let $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function (result) {
                if (result.status) {
                    if (result.response === 'active')
                        $selector.removeClass('btn-info').addClass('btn-success').text('K??ch ho???t').data('link', result.link);
                    else
                        $selector.removeClass('btn-success').addClass('btn-info').text('Ch??a k??ch ho???t').data('link', result.link);
                    $selector.notify("C???p nh???t th??nh c??ng!", {
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
    $bccContactAjax.on('click', function () {
        let link = $(this).data('link');
        let $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function (result) {
                if (result.status) {
                    if (result.response === 'active')
                        $selector.removeClass('btn-warning').addClass('btn-primary').text('B???t').data('link', result.link);
                    else
                        $selector.removeClass('btn-primary').addClass('btn-warning').text('T???t').data('link', result.link);
                    $selector.notify("C???p nh???t th??nh c??ng!", {
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

    /* create slug of category */
    $categoryName.on('change', function () {
        let categoryName = $(this).val();
        if ($categorySlug.val() === '')
            $categorySlug.val(to_slug(categoryName));
    });

    /* Change attr select box */
    $selectAttr.on('change', function () {
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
            success: function (result) {
                if (result.status) {
                    $selector.notify("C???p nh???t th??nh c??ng!", {
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

    $fieldAjax.on('change', function (e) {
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
            success: function (result) {
                if (result.status) {
                    $selector.notify("C???p nh???t th??nh c??ng!", {
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

    $btnMail.on('click', function () {
        let link = $(this).data('link');
        let $selector = $(this);
        $.ajax({
            url: link,
            type: "GET",
            dataType: "json",
            success: function (result) {
                if (result.status) {
                    $selector.notify("G???i mail th??nh c??ng!", {
                        className: 'success',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });
                } else {
                    $selector.notify("C?? l???i x???y ra!", {
                        className: 'error',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });
                    console.log(result.error)
                }
            }
        });
    });

    $selectFilter.on('change', function () {
        var pathname = window.location.pathname;
        let searchParams = new URLSearchParams(window.location.search);

        params = ['page', 'filter_status', 'search_field', 'search_value'];

        let link = "";
        $.each(params, function (key, value) {
            if (searchParams.has(value)) {
                link += value + "=" + searchParams.get(value) + "&"
            }
        });
        let select_field = $(this).data('field');
        let select_value = $(this).val();
        if (link === '')
            window.location.href = pathname + '?select_field=' + select_field + '&select_value=' + select_value;
        else
            window.location.href = pathname + "?" + link.slice(0, -1) + '&select_field=' + select_field + '&select_value=' + select_value;
    });

    /* checkbox ordering */
    $inputOrdering.on('change', function () {
        let id = $(this).data('id');
        let $selector = $('input[name="cid[' + id + ']"]');
        $selector.attr('checked', true);
        $selector.parent().addClass('checked');
        $selector.parent().parent().addClass('selected');
    });

    // submit form
    $('.btn-submit').click((e) => {
        let confirmed = $(e.target).data('confirmed');
        
        if(confirmed != 1) {
            if(!confirm('B???n c?? ch???c x??c nh???n kh??ng ?')) {
                e.preventDefault();
                return false;
            }
        }

        let $selector = $(e.target);
        let id = $(e.target).data('id');
        let status = $('select[name="status"][data-id="'+ id +'"]').val();
        if(status == 0) {
            $selector.notify("Vui l??ng ch???n tr???ng th??i", {
                className: 'error',
                autoHideDelay: 3000,
                elementPosition: 'bottom left'
            });
            e.preventDefault();
            return false;
        }
    })

    $(document).on('submit', '.update-form', (e) => {
        e.preventDefault();
        let id = $(e.target).data('id');
    
        $.ajax({
            url: $(e.target).attr('action'),
            dataType: 'json',
            data: $(e.target).serialize(),
            success: function (response) {
                if (response.status === true) {
                    $.notify("C???p nh???t th??nh c??ng!", {
                        className: 'success',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });

                    $(e.target).parent().addClass('tr-highlight');
                    $('.history-log[data-id="'+ response.id +'"] .display-info').html('<b>'+ response.user +'</b> ???? c???p nh???t v??o l??c <b>' + response.time +'</b>')

                    $('.btn-block-cont[data-id="'+ id +'"]').data('confirm', true);
                } else
                    $.notify("C?? l???i x???y ra!", {
                        className: 'error',
                        autoHideDelay: 3000,
                        elementPosition: 'top left'
                    });
            }
        });
    });

    // btn add view
    $btnAddView.click((e) => {
        let url = $(e.target).data('url');
        $.ajax({
            url: url,
            dataType: 'html',
            success: function (response) {
               $('.show-company-form').html('').append(response);
               $('#company-form-modal').modal('show');
            }
        });
    });


    $('.modal').on('show.bs.modal', (e) => {
        $('.datepicker-modal').datepicker({
            format: 'dd-mm-yyyy'
        });
    })


    $btnBlockCont.click((e) => {
        let $selector = $(e.target);
        let isConfirm = $(e.target).data('confirm');
        
        if(isConfirm == false) {
            $selector.notify("B???n ch??a x??c nh???n n??n kh??ng th??? kh??a!", {
                className: 'info',
                autoHideDelay: 3000,
                elementPosition: 'top left'
            });
            return false;
        }
            
        if(!confirm('B???n c?? ch???c mu???n kh??a kh??ng ?'))
            return false;

        let id = $(e.target).data('id');
        $(e.target).removeClass('btn-success btn-block-cont').addClass('btn-danger disabled').text('???? kh??a');
        $('.cont_no_block[data-id="'+ id +'"]').val(1);
        $('.btn-submit[data-id="'+ id +'"]').data('confirmed', 1).trigger('click');

        // disbled input when block record
        $('select[name="status"][data-id="'+ id +'"]').prop('disabled', true);
        $('input[name="note"][data-itemId="'+ id +'"]').attr('disabled', true);
        $('button.btn-submit[data-id="'+ id +'"]').attr('disabled', true);
        $('select[name="times_check"][data-id="'+ id +'"]').attr('disabled', true);
        $('div.box-hints[data-id="'+ id +'"]').addClass('d-none');
    });


    // suggestions event input
    $(document).on('click', '.suggestions-input', (e) => {
        e.preventDefault();
        let $selector = $(e.target);
        let id = $selector.data('id');
        let value = $selector.data('value');
        let $target = $('input[name="note"][data-id="' + id + '"]');
        $target.val($target.val() + " " + value);
    });

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
                if(response.status == true) {
                    let ids = response.message;
                    $('.row-item').addClass('d-none');
                    ids.forEach((item, index) => {
                        $('.row-item[data-id="'+ item.id +'"]').removeClass('d-none');
                    })
                    
                    
                } else {
                    console.log(response.message)
                }
            }
        });
    });

    $btnExportSearch.click((e) => {
        let link = $(e.target).data('link');
        $('.form-search').attr('action', link).submit();
    });
});

function to_slug(str) {
    str = str.toLowerCase();
    str = str.replace(/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/g, 'a');
    str = str.replace(/(??|??|???|???|???|??|???|???|???|???|???)/g, 'e');
    str = str.replace(/(??|??|???|???|??)/g, 'i');
    str = str.replace(/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/g, 'o');
    str = str.replace(/(??|??|???|???|??|??|???|???|???|???|???)/g, 'u');
    str = str.replace(/(???|??|???|???|???)/g, 'y');
    str = str.replace(/(??)/g, 'd');
    str = str.replace(/([^0-9a-z-\s])/g, '');
    str = str.replace(/(\s+)/g, '-');
    str = str.replace(/^-+/g, '');
    str = str.replace(/-+$/g, '');
    return str;
}
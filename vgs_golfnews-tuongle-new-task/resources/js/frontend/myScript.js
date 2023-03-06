$(document).ready(function () {
    $('.golf-owl-carousel').owlCarousel({
        margin: 10,
        nav: true,
        navText: ["<div class='nav-btn prev-slide'></div>", "<div class='nav-btn next-slide'></div>"],
        responsive: {
            0: {items: 1},
            600: {items: 3},
            1000: {items: 3}
        }
    });

    $(document).on('click', '.golf-banner', function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        let href = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (result) {
                window.open(href);
            }
        });
    });

    // let categoryTop1 = $('#category-top-1');
    // let bannerHomeSidebar1 = $('#banner-home-sidebar1');
    // let categoryTop2 = $('#category-top-2');
    // let bannerHomeSidebar2 = $('#banner-home-sidebar2');

    // let categoryPageArea1 = $('#category-page-area-1');
    // let bannerCategorySidebar1 = $('#banner-category-sidebar1');
    // let categoryPageArea2 = $('#category-page-area-2');
    // let bannerCategorySidebar2 = $('#banner-category-sidebar2');
    // let categoryPageArea3 = $('#category-page-area-3');
    // let bannerCategorySidebar3 = $('#banner-category-sidebar3');
    // let categoryPageSectionVideo = $('#category-section-video');
    //
    // if (categoryPageArea1.length) {
    //     bannerCategorySidebar1.offset({top: categoryPageArea1.offset().top});
    //     bannerCategorySidebar1.css('height', categoryPageArea1.css('height'));
    // }
    //
    // if (categoryPageArea2.length) {
    //     bannerCategorySidebar2.offset({top: categoryPageArea2.offset().top});
    //     bannerCategorySidebar2.css('height', categoryPageArea2.css('height'));
    // } else {
    //
    // }
    //
    // if (categoryPageArea3.length) {
    //     bannerCategorySidebar3.offset({top: categoryPageArea3.offset().top});
    //     bannerCategorySidebar3.css('height', categoryPageArea3.css('height'));
    // } else {
    //     if (bannerCategorySidebar3.length) {
    //         let marginTop = parseInt(bannerCategorySidebar2.css('height')) + 100 - (bannerCategorySidebar3.offset().top - bannerCategorySidebar2.offset().top);
    //         bannerCategorySidebar3.css('margin-top', marginTop + 'px');
    //     }
    // }
    //
    // $(window).resize(function () {
    //     if (categoryPageArea1.length) {
    //         bannerCategorySidebar1.offset({top: categoryPageArea1.offset().top});
    //         bannerCategorySidebar1.css('height', categoryPageArea1.css('height'));
    //     }
    //
    //     if (categoryPageArea2.length) {
    //         bannerCategorySidebar2.offset({top: categoryPageArea2.offset().top});
    //         bannerCategorySidebar2.css('height', categoryPageArea2.css('height'));
    //     } else {
    //
    //     }
    //
    //     if (categoryPageArea3.length) {
    //         bannerCategorySidebar3.offset({top: categoryPageArea3.offset().top});
    //         bannerCategorySidebar3.css('height', categoryPageArea3.css('height'));
    //     } else {
    //         if (bannerCategorySidebar3.length) {
    //             let marginTop = parseInt(bannerCategorySidebar2.css('height')) + 100 - (bannerCategorySidebar3.offset().top - bannerCategorySidebar2.offset().top);
    //             bannerCategorySidebar3.css('margin-top', marginTop + 'px');
    //         }
    //     }
    // });

    // if (bannerHomeSidebar1.length) {
    //     bannerHomeSidebar1.offset({top: categoryTop1.offset().top});
    //     bannerHomeSidebar1.css('height', categoryTop1.css('height'));
    //     bannerHomeSidebar2.offset({top: categoryTop2.offset().top});
    //     bannerHomeSidebar2.css('height', categoryTop2.css('height'));
    //
    //     $(window).resize(function () {
    //         bannerHomeSidebar1.offset({top: categoryTop1.offset().top});
    //         bannerHomeSidebar1.css('height', categoryTop1.css('height'));
    //         bannerHomeSidebar2.offset({top: categoryTop2.offset().top});
    //         bannerHomeSidebar2.css('height', categoryTop2.css('height'));
    //     });
    // }

    $('#btn-load-more-level2').on('click', function () {
        let ele = $(this);
        let url = ele.data('url');
        let page = ele.data('page');
        $.ajax({
            url: url, type: 'GET', data: {page}, dataType: 'html', beforeSend: function () {
                ele.html('<div class="spinner-grow spinner-grow-sm mr-2" role="status"><span class="visually-hidden">Loading...</span></div>');
            }, success: function (result) {
                ele.html('Xem thêm');
                $('.golf-post-list').append(result);
                ele.data('page', ++page);
            }
        });
    });

    $('.ajax-content').each(function (index, element) {
        $.ajax({
            type: 'GET',
            url: $(element).data('url'),
            dataType: 'html',
            success: function (response) {
                $(element).html(response);
            }
        });
    });

    let golfPostDetail = $('#golf-post-detail');
    let adsInpageFullscreen = $('#ads-inpage-fullscreen');
    if (golfPostDetail.length && adsInpageFullscreen.length) {
        let tags = $('#golf-post-detail > *');
        let idx = Math.round(tags.length / 2);
        let html = adsInpageFullscreen.html();
        $(html).insertBefore(tags[idx]);
    }
});
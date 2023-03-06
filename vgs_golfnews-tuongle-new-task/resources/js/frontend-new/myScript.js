$(document).ready(function() {
    function setMaxHeightExcerpt(selector) {
        if (selector.length > 0) {
            let heights = selector.map(function() {
                return $(this).height();
            }).get();

            let maxHeight = Math.max.apply(null, heights);
            selector.height(maxHeight);
        }
    }

    $(document).on('click', '.golf-banner', function(e) {
        // e.preventDefault();
        let url = $(this).data('url');
        let href = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(result) {
                // window.open(href);
            }
        });
    });

    $(".owl-carousel").owlCarousel({
        items: 1,
        nav: true,
        navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>'],
        dots: false,
        loop: true,
        autoplay: true
    });

    $("#dl-menu").dlmenu();

    setMaxHeightExcerpt($('.home-col-left-top .post-excerpt'));
    setMaxHeightExcerpt($('.col-left-bottom .post-excerpt'));
    setMaxHeightExcerpt($('.golf-category-page-posts .post-excerpt'));

    $('#golf-post-detail > table').each(function(index, element) {
        $(element).wrap('<div style="overflow-x:auto;"></div>');
    });

    let adsInpageFullscreenWrapper = $("#ads-inpage-fullscreen-content");
    if (adsInpageFullscreenWrapper.length > 0) {
        let tags = $('#golf-post-detail > *');
        let idx = Math.round(tags.length / 2);
        let html = adsInpageFullscreenWrapper.html();
        $(html).insertBefore(tags[idx]);
        // $('.inpage-fullscreen-banner').css('background-image', `url('${$('.inpage-fullscreen-banner').data('src')}')`);
        var elmDiv = document.createElement('DIV');
        elmDiv.classList.add('postdetail-after-ads');

        for (let i = idx; i < tags.length; i++) {
            elmDiv.appendChild(tags[i]);
        }
        var postDetail = document.getElementById('golf-post-detail');
        if (postDetail) postDetail.appendChild(elmDiv);
    }

    let fixedEle = $('#fixed-position-banner');
    let bannerContainer = $('.banner-container');
    let menuContainer = $('.menu_container');
    let homeSlider = $('.home-slider');
    let verticalBanner = $('.vertical-banner');
    let footerContainer = $('.footer_container');

    bannerContainer.width(fixedEle.width());
    $('.vertical-banner').css('width', ($(window).width() - fixedEle.width()) / 2 - 20);

    $(window).resize(function() {
        bannerContainer.width(fixedEle.width());
        $('.vertical-banner').css('width', ($(window).width() - fixedEle.width()) / 2 - 20);
    })

    $(window).scroll(function() {
        let menuContainerHeight = menuContainer.height();
        let menuContainerOuterHeight = menuContainer.outerHeight();
        banner_footer = document.querySelector('body').offsetHeight - document.querySelector('.vertical-banner').offsetHeight - document.querySelector('.footer_container').offsetHeight;
        footer_height = document.querySelector('.footer_container').getBoundingClientRect().top;
        windowsHeight = window.innerHeight;
        var hT = fixedEle.offset().top,
            wS = $(this).scrollTop();
        if (wS + menuContainerHeight > hT) {
            bannerContainer.css({
                position: "fixed",
                top: menuContainerHeight,
                left: 'unset'
            })
            if (window.scrollY > banner_footer + 14) {
                bannerContainer.css({
                    position: "fixed",
                    top: 'unset',
                    bottom: windowsHeight - 8 - footer_height + document.querySelector('.vertical-banner').offsetHeight + 'px'
                })
            }
        } else {
            bannerContainer.css({
                position: "absolute",
                top: 0,
                left: 0
            })
        }

        if (menuContainer.hasClass('move')) {
            homeSlider.css('margin-top', menuContainerOuterHeight);
            $('.golf-page-container').css('margin-top', menuContainerOuterHeight)
        } else {
            homeSlider.css('margin-top', 0);
            $('.golf-page-container').css('margin-top', 0)
        }


        // if ($('#ads-inpage-fullscreen-wrapper').length > 0) {
        //     let adsTop = $('#ads-inpage-fullscreen-wrapper').offset().top;
        //     if (wS + menuContainerOuterHeight >= adsTop) {
        //         $('#ads-inpage-fullscreen-wrapper').css('background-position-y', wS + menuContainerOuterHeight - adsTop);
        //     }
        // }


    });
    window.addEventListener('scroll', reveal);
    var siteMarLeft = 0;
    var menuHeight = document.querySelector('.menu_container.sticky');
    if (menuHeight) menuHeight = menuHeight.offsetHeight;
    var headerNavHeight = document.querySelector('.menu_container').offsetHeight;
    var reveals = document.querySelectorAll('#golf-post-detail .ads-inner-detail');
    var imgFix = document.querySelector('#golf-post-detail .img-fix');
    var imgFlow = document.querySelector('#golf-post-detail .ads-inner-detail .img-flow');
    imgFix.style.top = parseFloat(menuHeight) + "px";

    var imgFlowHeight, imgFlowWidth;
    var siteBanner = document.getElementById('fixed-position-banner');

    function reveal() {
        if (siteBanner) siteMarLeft = parseFloat(siteBanner.getBoundingClientRect().left);
        console.log(siteMarLeft);
        if (imgFlow && imgFix) {
            imgFixHeight = imgFlow.clientHeight + 8;
            imgFlowHeight = imgFlow.clientHeight - headerNavHeight + 8; // 8px margin bottom anchor
            imgFlowWidth = parseFloat(imgFlow.getBoundingClientRect().width);
            for (var i = 0; i < reveals.length; i++) {
                var revealtop = reveals[i].getBoundingClientRect().top;
                if (revealtop > -(imgFlowHeight) && revealtop < headerNavHeight) {
                    imgFix.style.display = "block";
                    imgFix.style.maxHeight = imgFixHeight + (revealtop) - 10 + 'px';
                    imgFix.style.width = imgFlowWidth + 'px';
                    imgFix.style.marginLeft = siteMarLeft + 'px';

                } else {
                    imgFix.style.display = "none";
                }
            }
        }
    }

});
$(".search-golfnews").click(function() {
    if ($('.search-input').css('display') == 'none') {
        $('.search-input').css({ 'display': 'block' });
        $('#iconsearch').removeClass('fa-search');
        $('#iconsearch').addClass('fa-close');
    } else {
        $('.search-input').css('display', 'none');
        $('#iconsearch').removeClass('fa-close');
        $('#iconsearch').addClass('fa-search');
    }

});
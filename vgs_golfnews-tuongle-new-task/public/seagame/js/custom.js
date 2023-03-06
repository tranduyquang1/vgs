var elem = document.getElementById("videoLive");

function openFullscreen() {
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen) {
        /* Firefox */
        elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen) {
        /* Chrome, Safari & Opera */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
        /* IE/Edge */
        elem.msRequestFullscreen();
    }
}

$(document).ready(function() {

    var url = $('.link_url').val();
    var video = document.getElementById('videoLive');
    if (Hls.isSupported()) {
        // var video = document.getElementById('video');
        var hls = new Hls();
        hls.loadSource(url);
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED, function() {
            video.play();
        });
    } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
        video.src = url;
        video.addEventListener('canplay', function() {
            video.play();
        });
    }
    // openFullscreen();
});
document.addEventListener("DOMContentLoaded", function() {

    // $(document.body).on('touchmove', onScroll); // for mobile
    // $(window).on('scroll', onScroll);

    // function onScroll() {
    //     console.log('scrollss');
    //     bannerTopSeagame = document.querySelector('#bannerTopSeagame').offsetHeight
    //     if (window.scrollY > bannerTopSeagame) {
    //         console.log('add-fix-munu')

    //         document.getElementById('menu-seagames').classList.add('fixed-menu-top');
    //         menuSeagames = document.getElementById('menu-seagames')
    //         if (menuSeagames) {

    //             navbar_height = menuSeagames.offsetHeight;
    //         }
    //     } else {
    //         menuSeagames = document.getElementById('menu-seagames')
    //         if (menuSeagames) {
    //             menuSeagames.classList.remove('fixed-menu-top');
    //         }

    //     }
    // }


    window.addEventListener('scroll', function() {

        let bannerTopSeagame = document.querySelector('#bannerTopSeagame').offsetHeight
        if (window.scrollY > 0) {
            if (window.scrollY > bannerTopSeagame) {

                document.getElementById('menu-seagames').classList.add('fixed-menu-top');
                menuSeagames = document.getElementById('menu-seagames')

                if (menuSeagames) {
                    let navbar_height = menuSeagames.offsetHeight;
                    let marginMenu = window.getComputedStyle(document.querySelector("#menu-seagames")).marginBottom
                    document.querySelector(".site-page-seagames").style.marginTop = navbar_height + parseFloat(marginMenu) + 'px'

                }
            } else {
                menuSeagames = document.getElementById('menu-seagames')
                if (menuSeagames) {
                    menuSeagames.classList.remove('fixed-menu-top');

                    document.querySelector(".site-page-seagames").style.marginTop = '0px'



                }

            }
        } else if (document.body.scrollTop > 0) {
            if (document.body.scrollTop > bannerTopSeagame) {

                document.getElementById('menu-seagames').classList.add('fixed-menu-top');
                menuSeagames = document.getElementById('menu-seagames')
                if (menuSeagames) {
                    let navbar_height = menuSeagames.offsetHeight;
                    let marginMenu = window.getComputedStyle(document.querySelector("#menu-seagames")).marginBottom
                    document.querySelector(".site-page-seagames").style.marginTop = navbar_height + parseFloat(marginMenu) + 'px'
                    console.log(navbar_height, marginMenu, navbar_height + parseFloat(marginMenu) + 'px')
                }
            } else {
                menuSeagames = document.getElementById('menu-seagames')
                if (menuSeagames) {
                    menuSeagames.classList.remove('fixed-menu-top');
                    document.querySelector(".site-page-seagames").style.marginTop = '0px'

                }

            }
        }


    }, true);

});
$('.scroll_top_seagame').click(function() {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
});




// document.addEventListener("DOMContentLoaded", function() {
//     window.addEventListener('scroll', function() {
//         if (window.scrollY > 32) {
//             document.getElementById('navbar_menu_top').classList.add('fixed-menu-top');
//             navbar_height = document.querySelector('#navbar_menu_top').offsetHeight;
//             document.head.style.paddingTop = navbar_height + 'px';
//         } else {
//             document.getElementById('navbar_menu_top').classList.remove('fixed-menu-top');
//             document.head.style.paddingTop = '0';
//         }
//         header_banner = document.querySelector('.container-fluid .header-banner');
//         if (header_banner != null) {
//             height1 = header_banner.offsetHeight;
//         } else {
//             height1 = 0;
//         }
//         header_stiki = document.querySelector('#header__stiki');
//         if (header_stiki != null) {
//             height2 = header_stiki.offsetHeight;
//         } else {
//             height2 = 0;
//         }
//         header_infor = document.querySelector('#header__infor');
//         if (header_infor != null) {
//             height3 = header_infor.offsetHeight;
//         } else {
//             height3 = 0;
//         }
//         banner_height = height1 + height2 + height3 - navbar_height;
//         if (banner_height < 0) banner_height = 33;
//         if (window.scrollY > (banner_height - height1)) {
//             document.getElementById('main-menu-custom').style.top = navbar_height - 1 + 'px';

//             if (window.scrollY > banner_height) {
//                 document.getElementById('banner-vertical').classList.add('fixed-banner-verical');

//                 navbar_height = document.querySelector('#navbar_menu_top').offsetHeight;
//                 document.getElementById('banner-vertical').style.top = navbar_height + 'px';
//             } else {
//                 document.getElementById('banner-vertical').classList.remove('fixed-banner-verical');
//                 document.getElementById('banner-vertical').style.top = '0';

//             }
//         } else {
//             document.getElementById('main-menu-custom').style.top = navbar_height + height2 - 1 + 'px';

//         }
//         banner_footer = document.querySelector('body').offsetHeight - document.querySelector('.qc-left').offsetHeight - document.querySelector('#navbar_menu_top').offsetHeight - document.querySelector('#footer').offsetHeight;
//         footer_height = document.querySelector('#footer').getBoundingClientRect().top;
//         windowsHeight = window.innerHeight;
//         if (window.scrollY > banner_footer) {

//             document.getElementById('banner-vertical').style.top = 'unset';
//             document.getElementById('banner-vertical').style.bottom = windowsHeight - footer_height + document.querySelector('.qc-left').offsetHeight + 'px';
//         } else {

//         }

//     });
// });
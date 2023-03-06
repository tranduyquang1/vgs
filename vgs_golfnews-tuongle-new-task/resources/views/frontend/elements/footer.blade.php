@php
    $settingMain = \App\Helpers\Fetch::get(public_path('cache/setting-main.json'), true);
@endphp

<footer id="footer" class="dark pb-5">
    <div class="container">
        <div class="footer-widgets-wrap py-5">

            <div class="row col-mb-50">
                <div class="col-12">
                    <a href="#" class="d-inline-block">
                        <img src="{{ asset($settingMain['logo_footer']) }}" alt="Image"
                             style="height: 50px">
                    </a>
                </div>
                <div class="col-md-9">
                    <div class="widget clearfix">
                        <div class="row col-mb-50 mt-2">
                            <div class="col-lg-6 pb-2">
                                <div class="widget clearfix">
                                    <h4 class="text-uppercase mb-0">Trang thông tin điện tử tổng hợp về golf</h4>
                                    <div class="line line-sm bg-white my-2"></div>
                                    <div>
                                        <p>Giấy phép ICP số 37/GP-TTĐT do Sở Thông Tin và Truyền Thông TPHCM cấp ngày
                                            04/05/2018</p>
                                        <p>Chịu trách nhiệm nội dung: Nguyễn Hoàng Minh</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 pb-2">
                                <div class="widget subscribe-widget clearfix">
                                    <h4 class="text-uppercase mb-0">Đơn vị chủ quản</h4>
                                    <div class="line line-sm bg-white my-2"></div>
                                    <div>
                                        <p class="mb-1">Công ty CP Dịch vụ Truyền thông Golf Việt Nam</p>
                                        <p class="mb-1">Địa chỉ: 20 Võ Chí Công, phường Nghĩa Đô, quận Cầu Giấy, TP. Hà
                                            Nội</p>
                                        <p class="mb-1">VP HCM: 205/10A Hoàng Văn Thụ, phường 8, quận Phú Nhuận</p>
                                        <p class="mb-1">Hotline: 0941 123 003</p>
                                        <p class="mb-1">&copy; {{ now()->year }} Discovery Golf, Inc. All Rights
                                            Reserved</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-3">
                    <div class="widget clearfix">
                        <a href="{{ $settingMain['url_price_quotation'] }}" target="_blank" class="btn btn-outline-light btn-lg text-uppercase">Báo giá quảng cáo</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</footer>
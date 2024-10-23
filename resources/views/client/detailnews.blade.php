@extends('layouts.client.app')

@section('meta_title', '')

@section('content')
    <div class="main-body">
        <div class="news__page">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="breadcrumbs-nav" style="padding: 20px 0 20px 0">
                        <div class="item">
                            <a href="{{ route('client.home') }}" title="Trang chủ">Trang chủ</a>
                        </div>
                        <div class="item sep">/</div>
                        <div class="item">
                            <a href="{{ route('client.news') }}" title="Tin tức">Tin tức</a>
                        </div>
                        <div class="item sep">/</div>
                        <div class="item">
                            {{$blog->title}}
                        </div>
                    </div>
                    <div class="section news__detail">
                        <div class="gap-y-20">
                            <div class="col l-12 mc-12 c-12">
                                <div class="page__head">
                                    <div class="box-header">
                                        <div class="title">Tin tức</div>
                                        <h1 class="box-title"> {{$blog->title}}</h1>
                                    </div>
                                </div>
                                <div class="news__detail--description">
                                    <div class="content-detail">
                                        <p style="text-align:justify">
                                            {{$blog->describe}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col l-12 mc-12 c-12">
                                <div class="date">
                                    <span class="published"> {{$blog->date}}</span>
                                </div>
                            </div>
                            <div class="col l-12 mc-12 c-12">
                                <div class="news__detail--content">
                                    <div class="content-detail">
                                        {!! $blog->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="news__relative">
                        <div class="news__relative--frame">
                            <div class="row gap-y-20">
                                <div class="col l-12 mc-12 c-12">
                                    <h2 class="box-title text-center">BÀI VIẾT LIÊN QUAN</h2>
                                </div>
                                <div class="col l-12 mc-12 c-12">
                                    <div class="news__slider news__list slick-initialized slick-slider">
                                        <div class="slick-list draggable" tabindex="0">
                                            <div class="slick-track"
                                                style="opacity: 1; width: 1191px; transform: translate3d(0px, 0px, 0px);">
                                                <div class="item slick-slide slick-active" index="0"
                                                    style="width: 377px;">
                                                    <div class="item__frame">
                                                        <div class="item__thumb">
                                                            <a href="https://phongkhamtuean.com.vn/tin-tuc/su-ki-dieu-cua-phuong-phap-nan-chinh-cot-song-bang-tay-chiropractic"
                                                                class="item__thumb--link">
                                                                <img src="https://phongkhamtuean.com.vn/uploads/static/Blog/su-ki-dieu/thuml1.jpg"
                                                                    alt="Sự kì diệu của Phương pháp nắn chỉnh cột sống bằng tay Chiropractic">
                                                            </a>
                                                        </div>
                                                        <div class="item__body">
                                                            <h2 class="item__title">
                                                                <a href="https://phongkhamtuean.com.vn/tin-tuc/su-ki-dieu-cua-phuong-phap-nan-chinh-cot-song-bang-tay-chiropractic"
                                                                    class="item__link title">Sự kì diệu của Phương pháp nắn
                                                                    chỉnh cột sống bằng tay Chiropractic</a>
                                                            </h2>
                                                            <div class="item__body--wrap">
                                                                <a href="https://phongkhamtuean.com.vn/tin-tuc/"
                                                                    class="item__category">Tin tức</a>
                                                                <div class="sep"></div>
                                                                <div class="item__published">05/05/2024</div>
                                                            </div>
                                                            <div class="item__description">Các bệnh lý về xương khớp đặc
                                                                biệt là các bệnh liên quan đến cột sống hiện nay ngày càng
                                                                trở nên phổ biến do nhiều nguyên nhân khác nhau như môi
                                                                trường làm việc, chế độ dinh dưỡng, tuổi tác,… Do đó, phương
                                                                pháp nắn chỉnh cột sống bằng tay được rất nhiều các chuyên
                                                                gia về xương khớp đánh giá cao. Hãy cùng phòng khám Tuệ
                                                                An&nbsp;tìm hiểu về phương pháp điều trị đau cột sống này
                                                                nhé.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item slick-slide slick-active" index="1"
                                                    style="width: 377px;">
                                                    <div class="item__frame">
                                                        <div class="item__thumb">
                                                            <a href="https://phongkhamtuean.com.vn/tin-tuc/chiropractic-cong-nghe-tri-lieu-than-kinh-cot-song-dot-pha-tu-my"
                                                                class="item__thumb--link">
                                                                <img src="https://phongkhamtuean.com.vn/uploads/static/Blog/chiropractic/thuml.jpg"
                                                                    alt="Chiropractic - Công nghệ Trị liệu thần kinh cột sống đột phá từ Mỹ">
                                                            </a>
                                                        </div>
                                                        <div class="item__body">
                                                            <h2 class="item__title">
                                                                <a href="https://phongkhamtuean.com.vn/tin-tuc/chiropractic-cong-nghe-tri-lieu-than-kinh-cot-song-dot-pha-tu-my"
                                                                    class="item__link title">Chiropractic - Công nghệ Trị
                                                                    liệu thần kinh cột sống đột phá từ Mỹ</a>
                                                            </h2>
                                                            <div class="item__body--wrap">
                                                                <a href="https://phongkhamtuean.com.vn/tin-tuc/"
                                                                    class="item__category">Tin tức</a>
                                                                <div class="sep"></div>
                                                                <div class="item__published">01/05/2024</div>
                                                            </div>
                                                            <div class="item__description">Trị liệu thần kinh cột sống hay
                                                                còn gọi là công nghệ Chiropractic được xem là phương pháp
                                                                chỉ định đầu tiên, trước tất cả các giải pháp nội khoa (dùng
                                                                thuốc) hay ngoại khoa (phẫu thuật) để điều trị các bệnh lý
                                                                cơ, xương, khớp và cột sống một cách hiệu quả nhất. Vậy
                                                                phương pháp chiropractic là gì và có ưu điểm ra sao… Hãy
                                                                cùng phòng khám Tuệ An&nbsp;tìm hiểu qua bài viết hôm nay
                                                                nhé!
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item slick-slide slick-active" index="2"
                                                    style="width: 377px;">
                                                    <div class="item__frame">
                                                        <div class="item__thumb">
                                                            <a href="https://phongkhamtuean.com.vn/tin-tuc/dau-hieu-va-trieu-chung-gu-lung-o-tre-can-luu-y"
                                                                class="item__thumb--link">
                                                                <img src="https://phongkhamtuean.com.vn/uploads/static/Blog/gu-lung/thuml.jpg"
                                                                    alt="Dấu hiệu và triệu chứng gù lưng ở trẻ cần lưu ý">
                                                            </a>
                                                        </div>
                                                        <div class="item__body">
                                                            <h2 class="item__title">
                                                                <a href="https://phongkhamtuean.com.vn/tin-tuc/dau-hieu-va-trieu-chung-gu-lung-o-tre-can-luu-y"
                                                                    class="item__link title">Dấu hiệu và triệu chứng gù
                                                                    lưng ở trẻ cần lưu ý</a>
                                                            </h2>
                                                            <div class="item__body--wrap">
                                                                <a href="https://phongkhamtuean.com.vn/tin-tuc/"
                                                                    class="item__category">Tin tức</a>
                                                                <div class="sep"></div>
                                                                <div class="item__published">29/04/2024</div>
                                                            </div>
                                                            <div class="item__description">Gù lưng ở mức độ nghiêm
                                                                trọng có thể dẫn đến một số biến chứng ảnh hưởng
                                                                đến sinh hoạt hàng ngày, gây chèn ép đường tiêu hoá và khiến
                                                                cho người bệnh gặp tự ti bởi vóc dáng không như ý, đặc biệt
                                                                là đối với thanh thiếu niên.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l-12 mc-12 c-12">
                                    <a href="https://phongkhamtuean.com.vn/tin-tuc" class="button btn-text">Xem tất cả</a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.client.master')

@section('meta_title', 'Bệnh viện')
<style>
    .hover-text-white:hover {
        color: #ffffff !important;
        transition: color 0.3s ease;
    }
</style>
@section('content')
    <div class="main-body">
        <div class="section box box-head">
            <div class="bg box-head__bg">
                <img src="{{ asset('frontend/assets/image/banner.png') }}" alt="Background">
            </div>
            <div class="box box-head__frame">
                <div class="container">
                    <div class="">
                        <div class="col l-12 mc-12 c-12">
                            <div class="box-head__image">
                                <img src="{{ asset('frontend/assets/image/banner-2.png') }}"
                                    alt="Image">
                            </div>
                        </div>
                        <div class="col l-12 mc-12 c-12">
                            <div class="box-head__service">
                                <div class="">
                                    <div class="col l-12 mc-12 c-12 mt-5">
                                        <h2 class="box-title">CAM KẾT ĐIỀU TRỊ <span class="highlight">DỨT ĐIỂM</span> CÁC
                                            BỆNH LÝ TOÀN DIỆN</h2>
                                    </div>
                                    <div class="col l-12 mc-12 c-12 mt-5">
                                        <div class="service__featured">
                                            <div class="row gap-y-20">
                                                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                                                    <div class="item">
                                                        <a href="" class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon-index/eye.png') }}"
                                                                    alt="Viêm mũi" />
                                                            </div>
                                                            <h3 class="item__title title">Bệnh về mắt</h3>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                                                    <div class="item">
                                                        <a href="" class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon-index/stethoscope.png') }}"
                                                                    alt="Phẫu thuật" />
                                                            </div>
                                                            <h3 class="item__title title">Phẫu thuật</h3>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                                                    <div class="item">
                                                        <a href="" class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon-index/crutches.png') }}"
                                                                    alt="Xét nghiệm" />
                                                            </div>
                                                            <h3 class="item__title title">Xét nghiệm</h3>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                                                    <div class="item">
                                                        <a href="" class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon-index/throat.png') }}"
                                                                    alt="Viêm xoan" />
                                                            </div>
                                                            <h3 class="item__title title">Viêm xoan</h3>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section box box-commit">
            <div class="container">
                <div class="box-commit__frame">
                    <div class="row gap-y-40">
                        <div class="col l-5 mc-12 c-12">
                            <div class="box-commit__image">
                                <img src="{{ asset('frontend/assets/image/bg.png') }}" alt="Cam kết" />
                            </div>
                        </div>
                        <div class="col l-7 mc-12 c-12">
                            <div class="box-commit__main">
                                <div class=" gap-y-40">
                                    <div class="col l-12 mc-12 c-12">
                                        <h2 class="box-title highlight">
                                            <p>Các con số <span>Ấn tượng</span></p>
                                            TẠI BỆNH VIỆN <p>VIETCARE</p>
                                        </h2>
                                    </div>
                                    <div class="col l-12 mc-12 c-12">
                                        <div class="box-count">
                                            <div class="row gap-y-20">
                                                <div class="col l-4 mc-4 c-12">
                                                    <div class="item">
                                                        <div class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon_commit_1 1.png') }}"
                                                                    alt="Khách hàng đang điều trị" />
                                                            </div>
                                                            <div class="item__body">
                                                                <div class="item__number" data-count="500">
                                                                    <span>0</span>+
                                                                </div>
                                                                <div class="item__title">
                                                                    Khách hàng đang điều trị
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-4 mc-4 c-12">
                                                    <div class="item">
                                                        <div class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon_commit_2 1.png') }}"
                                                                    alt="Khách hàng hồi phục" />
                                                            </div>
                                                            <div class="item__body">
                                                                <div class="item__number" data-count="7000">
                                                                    <span>0</span>+
                                                                </div>
                                                                <div class="item__title">
                                                                    Khách hàng hồi phục
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-4 mc-4 c-12">
                                                    <div class="item">
                                                        <div class="item__frame">
                                                            <div class="item__image">
                                                                <img src=" {{ asset('frontend/assets/image/icon_commit_3 1.png') }}"
                                                                    alt="Khách hàng hài lòng về dịch vụ" />
                                                            </div>
                                                            <div class="item__body">
                                                                <div class="item__number" data-count="99">
                                                                    <span>0</span>%
                                                                </div>
                                                                <div class="item__title">
                                                                    Khách hàng hài lòng về dịch vụ
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                let a = 0;
                                                const boxNumberWrap = $(".box-count .item__number");
                                                let boxNumberWrapCount = boxNumberWrap.length;
                                                const oTop =
                                                    $(".box-count").offset().top - window.innerHeight;
                                                let animationFinished = false;

                                                function animateNumbers() {
                                                    boxNumberWrap.each(function() {
                                                        const $this = $(this);
                                                        const countTo = $this.attr("data-count");

                                                        $({
                                                            countNum: $this.find("span").text(),
                                                        }).animate({
                                                            countNum: countTo,
                                                        }, {
                                                            duration: 2000,
                                                            easing: "swing",
                                                            step: function() {
                                                                $this
                                                                    .find("span")
                                                                    .text(
                                                                        Math.floor(
                                                                            this.countNum
                                                                        ).toLocaleString("vi-VN")
                                                                    );
                                                            },
                                                            complete: function() {
                                                                $this
                                                                    .find("span")
                                                                    .text(
                                                                        this.countNum.toLocaleString("vi-VN")
                                                                    );

                                                                if (--boxNumberWrapCount === 0) {
                                                                    animationFinished = true;
                                                                }
                                                            },
                                                        });
                                                    });
                                                }

                                                $(window).scroll(function() {
                                                    if (animationFinished) {
                                                        return;
                                                    }

                                                    if (a === 0 && $(window).scrollTop() > oTop) {
                                                        a = 1;
                                                        requestAnimationFrame(animateNumbers);
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="section box box-process">
                <div class="container">
                    <div class="box-process__frame">
                        <div class="">
                            <div class="col l-12 mc-12 c-12">
                                <h2 class="box-title text-center">
                                    QUY TRÌNH ĐIỀU TRỊ <span>TẠI VIỆT CARE</span>
                                </h2>
                                <div class="box-description">
                                    Phòng khám Việt Care cam kết mang đến trải nghiệm chăm sóc sức khỏe cơ
                                    xương khớp toàn diện với sự kết hợp giữa Chiropractic, Trị liệu cơ
                                    chuyên sâu và Vật lý trị liệu công nghệ cao, giúp khách hàng giải
                                    quyết các vấn đề cơ xương khớp từ gốc rễ và cảm nhận được sự chữa
                                    lành từ sâu bên trong.
                                </div>
                            </div>
                            <div class="col l-12 mc-12 c-12 mt-3">
                                <div class="box-process__main nav-tabs-custom">
                                    <div class="process__tab tab__list">
                                        <div class="tab active" data-pane="#pane_1">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_process_1.svg"
                                                        alt="Thăm khám" />
                                                </div>
                                                <div class="tab__title">Đặt lịch khám</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_2">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_process_2.svg"
                                                        alt="Xả cơ" />
                                                </div>
                                                <div class="tab__title">Xả cơ</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_3">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_process_3.svg"
                                                        alt="Điều trị bằng máy" />
                                                </div>
                                                <div class="tab__title">Điều trị bằng máy</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_4">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_process_4.svg"
                                                        alt="Nắn chỉnh bằng tay" />
                                                </div>
                                                <div class="tab__title">Nắn chỉnh bằng tay</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_5">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_process_5.svg"
                                                        alt="Hướng dẫn bài tập tại nhà" />
                                                </div>
                                                <div class="tab__title">Hướng dẫn bài tập tại nhà</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="process__pane pane__list">
                                        <div id="pane_1" class="pane active">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Thăm khám</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                B&aacute;c sĩ tiến h&agrave;nh xem x&eacute;t bệnh
                                                                &aacute;n, h&igrave;nh chụp X-quang, kiểm tra
                                                                v&agrave; x&aacute;c định đốt sống bị sai cấu
                                                                tr&uacute;c trong cơ thể. Chỉ định ph&aacute;c đồ điều
                                                                trị ph&ugrave; hợp với thể trạng của từng bệnh
                                                                nh&acirc;n. Mỗi kh&aacute;ch h&agrave;ng khi đến với
                                                                Tuệ An đều được c&aacute;c b&aacute;c sĩ tại
                                                                ph&ograve;ng kh&aacute;m trực tiếp thăm kh&aacute;m,
                                                                đảm bảo chuẩn đo&aacute;n v&agrave; đưa ra ph&aacute;c
                                                                đồ điều trị chuẩn x&aacute;c nhất.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="https://phongkhamtuean.com.vn/uploads/static/quytrinh/tg_image_305331121.jpeg"
                                                            alt="Thăm khám" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pane_2" class="pane">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Xả cơ</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                Bước n&agrave;y thường được thực hiện để giảm căng
                                                                thẳng v&agrave; cải thiện sự linh hoạt của cơ bắp.
                                                                Bằng c&aacute;ch &aacute;p dụng &aacute;p lực
                                                                v&agrave; kỹ thuật xoa b&oacute;p, b&aacute;c sĩ sẽ
                                                                gi&uacute;p giảm căng thẳng v&agrave; gi&atilde;n cơ,
                                                                l&agrave;m cho bệnh nh&acirc;n cảm thấy thoải
                                                                m&aacute;i hơn.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="https://phongkhamtuean.com.vn/uploads/static/quytrinh/tg_image_3169920123.jpeg"
                                                            alt="Xả cơ" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pane_3" class="pane">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Điều trị bằng máy</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                Ph&ograve;ng kh&aacute;m Tuệ An sử dụng c&aacute;c
                                                                thiết bị v&agrave; m&aacute;y m&oacute;c hiện đại để
                                                                hỗ trợ qu&aacute; tr&igrave;nh điều trị. C&aacute;c kỹ
                                                                thuật như s&oacute;ng si&ecirc;u &acirc;m, điện xung,
                                                                hoặc laser c&oacute; thể được &aacute;p dụng để giảm
                                                                đau, giảm vi&ecirc;m, v&agrave; k&iacute;ch
                                                                th&iacute;ch qu&aacute; tr&igrave;nh l&agrave;nh tổn
                                                                thương. Ngo&agrave;i ra, m&aacute;y k&eacute;o
                                                                d&atilde;n đốt s&oacute;ng cũng được Tuệ An cập nhật
                                                                để &aacute;p dụng điều trị cho kh&aacute;ch
                                                                h&agrave;ng.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="https://phongkhamtuean.com.vn/uploads/static/quytrinh/bangmay.jpeg"
                                                            alt="Điều trị bằng máy" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pane_4" class="pane">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Nắn chỉnh bằng tay</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                B&aacute;c sĩ sẽ sử dụng c&aacute;c động t&aacute;c,
                                                                kỹ thuật của chiropractic để điều chỉnh cấu
                                                                tr&uacute;c cơ bắp v&agrave; xương khớp của bệnh
                                                                nh&acirc;n. Điều n&agrave;y gi&uacute;p giải
                                                                ph&oacute;ng c&aacute;c ch&egrave;n &eacute;p, cải
                                                                thiện c&acirc;n bằng cơ thể v&agrave; giảm đau hiệu
                                                                quả.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="https://phongkhamtuean.com.vn/uploads/static/quytrinh/bangtay.jpeg"
                                                            alt="Nắn chỉnh bằng tay" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pane_5" class="pane">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Hướng dẫn bài tập tại nhà</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                Cuối c&ugrave;ng, b&aacute;c sĩ sẽ hướng dẫn bệnh
                                                                nh&acirc;n về c&aacute;c b&agrave;i tập v&agrave; biện
                                                                ph&aacute;p tự chăm s&oacute;c tại nh&agrave; để hỗ
                                                                trợ đẩy nhanh thời gian điều trị. Việc thực hiện
                                                                c&aacute;c b&agrave;i tập v&agrave; chăm s&oacute;c
                                                                bản th&acirc;n đ&uacute;ng c&aacute;ch sẽ gi&uacute;p
                                                                bệnh nh&acirc;n phục hồi nhanh ch&oacute;ng v&agrave;
                                                                duy tr&igrave; sức khỏe tốt.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="https://phongkhamtuean.com.vn/uploads/static/quytrinh/baitapvenha.jpg"
                                                            alt="Hướng dẫn bài tập tại nhà" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <div class="section box box-doctor">
            <div class="box-doctor__bg bg">
                <img src="https://phongkhamtuean.com.vn/frontend/home/images/bg_doctor.png" alt="Background" />
            </div>
            <div class="container">
                <div class="box box-doctor__frame">
                    <div class="row gap-y-20">
                        <div class="col l-12 mc-12 c-12">
                            <h2 class="box-title highlight text-center">
                                ĐỘI NGŨ BÁC SĨ
                            </h2>
                            <div class="box-description">
                                Các bác sĩ trực tiếp thăm khám, điều trị cho khách hàng có
                                trình độ chuyên môn cao và nhiều năm kinh nghiệm.
                            </div>
                        </div>
                        <div class="col l-12 mc-12 c-12">
                            <div class="box-doctor__slider">
                                @foreach ($doctor as $item)
                                    <div class="item">
                                        <div class="item__frame">
                                            <div class="item__image">
                                                <img src=" {{ asset($item->avatar) }}" alt="Dũng" />
                                            </div>
                                            <div class="item__body">
                                                <div class="item__name title">
                                                    <a href="{{ route('client.ho-so', $item->user_id) }}"
                                                        class="text-dark text-decoration-none hover-text-white">
                                                        Bác sĩ {{ $item->lastname }} {{ $item->firstname }}
                                                    </a>
                                                </div>
                                                <div class="item__position">{{ $item->specialtyName }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div class="item">
                                <div class="item__frame">
                                    <div class="item__image">
                                        <img src=" {{asset('frontend/assets/image/bs2.jpg')}}" alt="Quang"/>
                                    </div>
                                    <div class="item__body">
                                        <div class="item__name title">
                                            <span>Bác sĩ.</span> Quang
                                        </div>
                                        <div class="item__position">Chuyên xương khớp</div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="item__frame">
                                    <div class="item__image">
                                        <img src=" {{asset('frontend/assets/image/bs4.jpg')}}" alt="Kiên"/>
                                    </div>
                                    <div class="item__body">
                                        <div class="item__name title">
                                            <span>Bác sĩ.</span> Kiên
                                        </div>
                                        <div class="item__position">Chuyên xương khớp</div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="item__frame">
                                    <div class="item__image">
                                        <img src="{{asset('frontend/assets/image/bs5.jpg')}}" alt="Quang"/>
                                    </div>
                                    <div class="item__body">
                                        <div class="item__name title">
                                            <span>KTV.</span> Quang
                                        </div>
                                        <div class="item__position">Chuyên xương khớp</div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="item__frame">
                                    <div class="item__image">
                                        <img src="{{asset('frontend/assets/image/bá6.jpg')}}" alt="Tuấn"/>
                                    </div>
                                    <div class="item__body">
                                        <div class="item__name title">
                                            <span>Bác sĩ.</span> Tuấn
                                        </div>
                                        <div class="item__position">Chuyên xương khớp</div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="item__frame">
                                    <div class="item__image">
                                        <img src="{{asset('frontend/assets/image/bs7.jpg')}}" alt="Hải"/>
                                    </div>
                                    <div class="item__body">
                                        <div class="item__name title">
                                            <span>Bác sĩ.</span> Hải
                                        </div>
                                        <div class="item__position">Chuyên xương khớp</div>
                                    </div>
                                </div>
                            </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(".box-doctor__slider").slick({
                slidesToShow: 4,
                slidesToScroll: 4,
                autoplay: true,
                infinite: true,
                arrows: true,
                responsive: [{
                        breakpoint: 1023,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        </script>

        <div class="section box box-contact ">
            <div class="box-contact__bg bg">
                <img src="https://phongkhamtuean.com.vn/frontend/home/images/bg_contact.png" alt="Background" />
            </div>
            <div class="container">
                <div class="box box-contact__frame">
                    <div class="row no-gutters gap-y-40">
                        <div class="col l-7 mc-12 c-12">
                            <div class="box-contact__image">
                                <img src="{{ asset('frontend/assets/image/benh-tai-mui-hong-o-tre(1).jpg') }}"
                                    alt="Hình minh hoạ" />
                            </div>
                        </div>
                        <div class="col l-5 mc-12 c-12">
                            <div class="box-contact__form">
                                <div class=" no-gutters gap-y-20">
                                    <div class="col l-12 mc-12 c-12">
                                        <div class="box-title text-center">
                                            NHẬN TƯ VẤN <span class="highlight">MIỄN PHÍ</span>
                                        </div>
                                    </div>
                                    <div class="col l-12 mc-12 c-12">
                                        <div class="form contact">
                                            <div id="loading">
                                                <img src="https://phongkhamtuean.com.vn/frontend/home/images/loading.gif"
                                                    alt="Background" />
                                            </div>
                                            <div class="form__notice">
                                                <div class="notice success">
                                                    Thông tin đã gửi thành công!
                                                </div>
                                                <div class="notice error">
                                                    Lỗi! Không gửi được thông tin!
                                                </div>
                                                <div class="notice warning">
                                                    Vui lòng nhập đúng định dạng!
                                                </div>
                                            </div>
                                            <div class="form__frame">
                                                <div class="form__group">
                                                    <input id="text" type="text" name="text"
                                                        placeholder="Vấn đề" />
                                                </div>
                                                <div class="form__group">
                                                    <input id="fullname" type="text" name="fullname"
                                                        placeholder="Họ tên" />
                                                </div>
                                                <div class="form__flex">
                                                    <div class="form__group">
                                                        <input id="phone" type="text" name="phone"
                                                            placeholder="Số điện thoại" />
                                                    </div>
                                                    <div class="form__group form__email">
                                                        <input id="email" type="text" name="email"
                                                            placeholder="Email (nếu có)" />
                                                    </div>
                                                </div>
                                                <div class="form__group form__content">
                                                    <textarea id="content" name="content" rows="3" placeholder="Chi tiết (nếu có)"></textarea>
                                                    <input id="webiste" type="text" name="website"
                                                        style="display: none" />
                                                </div>
                                                <div class="form__action">
                                                    <div class="button btn-send btn-flex">
                                                        <i class="fa-solid fa-paper-plane"></i> Gửi
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

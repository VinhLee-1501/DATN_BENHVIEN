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
                                <img src="{{ asset('frontend/assets/image/banner-2.png') }}" alt="Image">
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
                                                    <img src="{{ asset('frontend/assets/image/icon-index/stethoscope.png') }}"
                                                        alt="Thăm khám" />
                                                </div>
                                                <div class="tab__title">Đặt lịch khám</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_2">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="{{ asset('frontend/assets/image/icon-index/heart-rate-monitor.png') }}"
                                                        alt="Hậu phẩu" />
                                                </div>
                                                <div class="tab__title">Hậu Phẩu</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_3">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="{{ asset('frontend/assets/image/icon-index/heart-handshake.png') }}"
                                                        alt="Chăm sóc ân cần" />
                                                </div>
                                                <div class="tab__title">Chăm sóc ân cần</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_4">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="{{ asset('frontend/assets/image/icon-index/phone-check.png') }}"
                                                        alt="Tiện lợi" />
                                                </div>
                                                <div class="tab__title">Tiện lợi</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_5">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="{{ asset('frontend/assets/image/icon-index/building-hospital.png') }}"
                                                        alt="Hướng dẫn bài tập tại nhà" />
                                                </div>
                                                <div class="tab__title">Nguồn nhân lực chất lượng cao</div>
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
                                                                Vietcare đều được c&aacute;c b&aacute;c sĩ tại
                                                                ph&ograve;ng kh&aacute;m trực tiếp thăm kh&aacute;m,
                                                                đảm bảo chuẩn đo&aacute;n v&agrave; đưa ra ph&aacute;c
                                                                đồ điều trị chuẩn x&aacute;c nhất.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/tham_kham.jpg') }}"
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
                                                            <h3 class="pane__title">Chăm sóc sau phẩu thuật</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                Tại bệnh viện Vietcare là hành trình đồng hành cùng bạn để
                                                                bạn nhanh chóng hồi phục và tận hưởng cuộc sống trọn vẹn.
                                                                Với đội ngũ y bác sĩ giàu kinh nghiệm và quy trình chăm sóc
                                                                chuyên nghiệp, chúng tôi cam kết mang đến cho bạn sự thoải
                                                                mái tối đa, giúp bạn hồi phục sức khỏe nhanh chóng và an
                                                                toàn.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/cham_soc.jpg') }}"
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
                                                            <h3 class="pane__title">Quan tâm đến bệnh nhân</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                Chúng tôi không chỉ là đơn vị cung cấp dịch vụ y tế, mà còn
                                                                là người bạn đồng hành tin cậy của bạn. Sự hài lòng của bạn
                                                                là động lực lớn nhất để chúng tôi không ngừng nâng cao chất
                                                                lượng dịch vụ. Hãy để chúng tôi chăm sóc bạn như người thân
                                                                trong gia đình.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/an_can.jpg') }}"
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
                                                            <h3 class="pane__title">Dịch vụ chăm sóc</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                Khám chữa bệnh tại nhà mang đến sự tiện lợi tối đa cho bạn
                                                                và gia đình. Bạn
                                                                không cần phải di chuyển đến bệnh viện, mà vẫn nhận được đầy
                                                                đủ các dịch vụ y tế chất lượng cao. Chúng tôi sẽ đến tận nhà
                                                                để thăm khám, điều trị và chăm sóc cho bạn.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/tien_loi.jpg') }}"
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
                                                            <h3 class="pane__title">Bác sĩ nhiều năm kinh nghiệm</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                Đội ngũ bác sĩ chất lượng cao của chúng tôi luôn sẵn sàng
                                                                đồng hành cùng bạn trên con đường bảo vệ sức khỏe. Với kiến
                                                                thức chuyên môn sâu rộng, kinh nghiệm dày dặn và sự tận tâm,
                                                                các bác sĩ sẽ mang đến cho bạn những giải pháp điều trị hiệu
                                                                quả và an toàn nhất. Chúng tôi cam kết sẽ lắng nghe và thấu
                                                                hiểu những lo lắng của bạn, tư vấn tận tình và đưa ra những
                                                                phác đồ điều trị phù hợp nhất. Hãy để chúng tôi chăm sóc sức
                                                                khỏe cho bạn và gia đình!
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/nhan_luc.jpg') }}"
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
                                                <img src="{{ asset('storage/uploads/avatars/' . $item->avatar) }}"
                                                    alt="Dũng" />
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

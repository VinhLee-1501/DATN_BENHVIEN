@extends('layouts.client.master')

@section('meta_title', 'Phòng khám an khang')

@section('content')
    <div class="main-body">
        <div class="section box box-head">
            <img src="{{asset('frontend/assets/image/banner-1.png')}}" alt="Background"/>

        </div>
    </div>
    <div class="section box box-commit">
        <div class="container">
            <div class="box-commit__frame">
                <div class="row gap-y-40">
                    <div class="col l-5 mc-12 c-12">
                        <div class="box-commit__image">
                            <img
                                src="{{asset('frontend/assets/image/hanoimoi.com.vn-uploads-images-phananh-2020-05-14-_tai-mui-hong-tre-em.jpg')}}"
                                alt="Cam kết"/>
                        </div>
                    </div>
                    <div class="col l-7 mc-12 c-12">
                        <div class="box-commit__main">
                            <div class=" gap-y-40">
                                <div class="col l-12 mc-12 c-12">
                                    <h2 class="box-title highlight">
                                        <p>Các con số <span>Ấn tượng</span></p>
                                        TẠI PHÒNG KHÁM <p>AN KHANG</p>
                                    </h2>
                                </div>
                                <div class="col l-12 mc-12 c-12">
                                    <div class="box-count">
                                        <div class="row gap-y-20">
                                            <div class="col l-4 mc-4 c-12">
                                                <div class="item">
                                                    <div class="item__frame">
                                                        <div class="item__image">
                                                            <img
                                                                src="{{asset('frontend/assets/image/icon_commit_1 1.png')}}"
                                                                alt="Khách hàng đang điều trị"/>
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
                                                            <img
                                                                src="{{asset('frontend/assets/image/icon_commit_2 1.png')}}"
                                                                alt="Khách hàng hồi phục"/>
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
                                                            <img
                                                                src=" {{asset('frontend/assets/image/icon_commit_3 1.png')}}"
                                                                alt="Khách hàng hài lòng về dịch vụ"/>
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
                                        $(document).ready(function () {
                                            let a = 0;
                                            const boxNumberWrap = $(".box-count .item__number");
                                            let boxNumberWrapCount = boxNumberWrap.length;
                                            const oTop =
                                                $(".box-count").offset().top - window.innerHeight;
                                            let animationFinished = false;

                                            function animateNumbers() {
                                                boxNumberWrap.each(function () {
                                                    const $this = $(this);
                                                    const countTo = $this.attr("data-count");

                                                    $({
                                                        countNum: $this.find("span").text(),
                                                    }).animate(
                                                        {
                                                            countNum: countTo,
                                                        },
                                                        {
                                                            duration: 2000,
                                                            easing: "swing",
                                                            step: function () {
                                                                $this
                                                                    .find("span")
                                                                    .text(
                                                                        Math.floor(
                                                                            this.countNum
                                                                        ).toLocaleString("vi-VN")
                                                                    );
                                                            },
                                                            complete: function () {
                                                                $this
                                                                    .find("span")
                                                                    .text(
                                                                        this.countNum.toLocaleString("vi-VN")
                                                                    );

                                                                if (--boxNumberWrapCount === 0) {
                                                                    animationFinished = true;
                                                                }
                                                            },
                                                        }
                                                    );
                                                });
                                            }

                                            $(window).scroll(function () {
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
        <div class="service__featured">
            <div class="row d-flex justify-content-center">
                <!-- Hàng 1 -->
                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                    <div class="item">
                        <a href="https://phongkhamtuean.com.vn/dich-vu/vung-tay" class="item__frame">
                            <div class="item__image">
                                <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_service_1.svg"
                                     alt="Bệnh về tai"/>
                            </div>
                            <h3 class="item__title title">Bệnh về tai</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                    <div class="item">
                        <a href="https://phongkhamtuean.com.vn/dich-vu/vung-chan" class="item__frame">
                            <div class="item__image">
                                <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_service_2.svg"
                                     alt="Bệnh về mũi"/>
                            </div>
                            <h3 class="item__title title">Bệnh về mũi</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                    <div class="item">
                        <a href="https://phongkhamtuean.com.vn/dich-vu/vung-co-vai-gay" class="item__frame">
                            <div class="item__image">
                                <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_service_3.svg"
                                     alt="Bệnh về họng"/>
                            </div>
                            <h3 class="item__title title">Bệnh về họng</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                    <div class="item">
                        <a href="https://phongkhamtuean.com.vn/dich-vu/vung-ham" class="item__frame">
                            <div class="item__image">
                                <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_service_4.svg"
                                     alt="Viêm xoan"/>
                            </div>
                            <h3 class="item__title title">Viêm xoan</h3>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center">
                <!-- Hàng 2 -->
                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                    <div class="item">
                        <a href="https://phongkhamtuean.com.vn/dich-vu/vung-lung" class="item__frame">
                            <div class="item__image">
                                <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_service_5.svg"
                                     alt="Viêm mũi"/>
                            </div>
                            <h3 class="item__title title">Viêm mũi</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                    <div class="item">
                        <a href="https://phongkhamtuean.com.vn/dich-vu/sau-tai-bien" class="item__frame">
                            <div class="item__image">
                                <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_service_6.svg"
                                     alt="Phẫu thuật"/>
                            </div>
                            <h3 class="item__title title">Phẫu thuật</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                    <div class="item">
                        <a href="https://phongkhamtuean.com.vn/dich-vu/vung-khac" class="item__frame">
                            <div class="item__image">
                                <img src="https://phongkhamtuean.com.vn/frontend/home/images/icon_service_7.svg"
                                     alt="Xét nghiệm"/>
                            </div>
                            <h3 class="item__title title">Xét nghiệm</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="section box box-doctor">
        <div class="box-doctor__bg bg">
            <img src="https://phongkhamtuean.com.vn/frontend/home/images/bg_doctor.png" alt="Background"/>
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
                            <div class="item">
                                <div class="item__frame">
                                    <div class="item__image">
                                        <img src=" {{asset('frontend/assets/image/bs1.jpg')}}" alt="Dũng"/>
                                    </div>
                                    <div class="item__body">
                                        <div class="item__name title">
                                            <span>KTV.</span> Dũng
                                        </div>
                                        <div class="item__position">Chuyên Khoa Tai</div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
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
                            </div>
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
            responsive: [
                {
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
            <img src="https://phongkhamtuean.com.vn/frontend/home/images/bg_contact.png" alt="Background"/>
        </div>
        <div class="container">
            <div class="box box-contact__frame">
                <div class="row no-gutters gap-y-40">
                    <div class="col l-7 mc-12 c-12">
                        <div class="box-contact__image">
                            <img src="{{asset('frontend/assets/image/benh-tai-mui-hong-o-tre(1).jpg')}}"
                                 alt="Hình minh hoạ"/>
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
                                                 alt="Background"/>
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
                                                <input id="text" type="text" name="text" placeholder="Vấn đề"/>
                                            </div>
                                            <div class="form__group">
                                                <input id="fullname" type="text" name="fullname"
                                                       placeholder="Họ tên"/>
                                            </div>
                                            <div class="form__flex">
                                                <div class="form__group">
                                                    <input id="phone" type="text" name="phone"
                                                           placeholder="Số điện thoại"/>
                                                </div>
                                                <div class="form__group form__email">
                                                    <input id="email" type="text" name="email"
                                                           placeholder="Email (nếu có)"/>
                                                </div>
                                            </div>
                                            <div class="form__group form__content">
                                            <textarea id="content" name="content" rows="3"
                                                      placeholder="Chi tiết (nếu có)"></textarea>
                                                <input id="webiste" type="text" name="website"
                                                       style="display: none"/>
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


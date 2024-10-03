@extends('layouts.client.master')

@section('meta_title', 'Phòng khám VIETCARE')

@section('content')

    <div class="main-body">
        <div class="section box box-head">
            <img src="{{asset('frontend/assets/image/Banner 1.png')}}" alt="Background"/>

        </div>
    </div>
    <div class="about__page">
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumbs-nav">
                    <div class="item">
                        <a href="" title="Trang chủ">Trang chủ</a>
                    </div>
                    <div class="item sep">/</div>
                    <div class="item">Giới thiệu</div>
                </div>
            </div>
        </div>
        <div class="about__main m-3">
            <div class="container">
                <div class=" gap-y-40">
                    <div class="col l-12 mc-12 c-12">
                        <div class="about__head">
                            <div class=" gap-y-20">
                                <div class="col l-12 mc-12 c-12">
                                    <div class="box-heading">
                                        <h1>Giới thiệu</h1>
                                    </div>
                                </div>
                                <div class="col l-12 mc-12 c-12">
                                    <div class="about__head--content">
                                        <div class="content-detail">
                                            <p>
                                                Với định hướng trở thành một trong những hệ thống phòng khám
                                                tai, mũi,
                                                họng đạt chuẩn, mang lại hiệu quả điều trị tối ưu, đồng thời
                                                nâng cao sự trải nghiệm của bệnh nhân,
                                                phòng khám VIETCARE đã và đang liên tục hoàn thiện
                                                – nâng cấp các tiêu chuẩn chung ở tất cả các yếu tố then chốt
                                                theo những quy chuẩn khắt khe nhất.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row align-items-center" style="height: 90vh;">
                <div class="col-md-5 d-flex justify-content-center align-items-center">
                    <img src="{{asset('frontend/assets/image/logo.png')}}" alt="Logo" class="logo-inproduce">
                </div>
                <div class="col-md-7">
                    <h2 class="text-success">Sứ mệnh</h2>
                    <p>Phòng khám VIETCARE cam kết mang lại dịch vụ y tế chất lượng cao, an toàn và hiệu quả nhất
                        cho mọi bệnh nhân. Chúng tôi nỗ lực không ngừng để đem đến sự thoải mái và hài lòng tối
                        đa cho bệnh nhân, đồng thời đề cao giá trị nhân văn và tôn trọng đạo đức nghề nghiệp.
                    </p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="d-flex col-md-12" style="height: 90vh;">
                <div class="col-md-6 p-5">
                    <h2 class="text-success">Giá trị cốt lỗi</h2>
                    <p>Chúng tôi luôn đặt chất lượng dịch vụ lên hàng đầu, với cam kết sử dụng công nghệ tiên
                        tiến và phương pháp điều trị an toàn nhất.</p>
                    <p>Đội ngũ bác sĩ và nhân viên của phòng khám VIETCARE luôn tận tâm và chu đáo trong mọi quá
                        trình điều trị và chăm sóc bệnh nhân.</p>
                    <p>Mỗi bệnh nhân được đánh giá và thiết kế kế hoạch điều trị cá nhân hóa, đảm bảo phù hợp và
                        hiệu quả nhất.</p>
                    <p>Chúng tôi cam kết mang lại sự an toàn và cải thiện sức khỏe cho mọi bệnh nhân, từng bước
                        một.</p>
                </div>
                <div class="col-md-6">
                    <img src="{{asset('frontend/assets/image/image.png')}}" alt="Logo" class="img-fluid">
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
                                                <img
                                                    src="https://phongkhamtuean.com.vn/frontend/home/images/loading.gif"
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
                                                    <input id="text" type="text" name="text"
                                                           placeholder="Vấn đề"/>
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
    </div>

@endsection

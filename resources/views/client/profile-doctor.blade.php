@extends('layouts.client.app')

@section('meta_title', '')

@section('content')

    <div class="main-body">
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumbs-nav">
                    <div class="item">
                        <a href="{{ route('client.home') }}" title="Trang chủ">Trang chủ</a>
                    </div>
                    <div class="item sep">/</div>
                    <div class="item">
                        <a href="">Bác sĩ</a>
                    </div>
                    <div class="item sep">/</div>
                    <div class="item">
                        <a href="{{ route('client.news') }}">Tên bác sĩ</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact__page">
            <div class="container">
                <div class="contact__page--frame">
                    <div class=" gap-y-40">
                        <div class="col l-12 mc-12 c-12">
                            <div class="box-heading text-center">
                                <h1>
                                    Bác sĩ
                                    <span class="highlight">name</span>
                                </h1>
                                <p class="description">Chuyên khoa</p>
                            </div>
                        </div>

                        <div class="col l-12 mc-12 c-12">
                            <div class="contact__form">
                                <div class="row gap-y-40">
                                    <div class="col l-4 mc-12 c-12">
                                        <img
                                            src="https://taimuihongsg.com/wp-content/uploads/2018/06/Tang-Ngoc-Diep_taimuihongsg.jpg">

                                        <div class="row bg-primary">
                                            <div class="">
                                                <h2>CHỨC VỤ - BS. Tăng Ngọc Diệp</h2>
                                                <p class="">
                                                    Bác sĩ Chuyên Khoa Nội Phòng Khám Đa
                                                    Khoa Quốc Tế Sài Gòn
                                                </p>
                                            </div>

                                            <div class="">
                                                <a
                                                    href="https://taimuihongsg.com/doi-ngu-bac-si/bac-si-khoa-khoa-tong-quat-noi-tiet/"
                                                    rel="tag">BÁC SĨ KHOA TỔNG QUÁT - NỘI TIẾT
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                </div>


                                <div class="col l-8 mc-12 c-12">
                                    {{--                                            <div class="contact__main">--}}
                                    {{--                                                <div class=" gap-y-20">--}}
                                    {{--                                                    <div class="col l-12 mc-12 c-12">--}}
                                    {{--                                                        <h3 class="title">Thông tin địa chỉ cơ sở</h3>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="col l-12 mc-12 c-12">--}}
                                    {{--                                                        <div class="contact__map">--}}
                                    {{--                                                            <iframe--}}
                                    {{--                                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.687214618684!2d106.66530938511656!3d10.835231430577752!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529a9f70252a9%3A0x645ada8a0a3ecafd!2zNDggxJAuIFPhu5EgNiwgS0RDIENpdHlsYW5kIFBhcmtoaWxsLCBHw7IgVuG6pXAsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1714879539789!5m2!1svi!2s"--}}
                                    {{--                                                                style="border: 0" allowfullscreen="" loading="lazy"--}}
                                    {{--                                                                referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <div class="col l-12 mc-12 c-12">--}}
                                    {{--                                                        <div class="contact__list">--}}
                                    {{--                                                            <div class="item">--}}
                                    {{--                                                                <div class="item__icon">--}}
                                    {{--                                                                    <i class="fa-solid fa-phone"></i>--}}
                                    {{--                                                                </div>--}}
                                    {{--                                                                <div class="item__wrap">--}}
                                    {{--                                                                    <span class="item__label">Hotline:</span>--}}
                                    {{--                                                                    <a href="tel:0962672967"--}}
                                    {{--                                                                       class="item__link">0962.672.967</a>--}}
                                    {{--                                                                </div>--}}
                                    {{--                                                            </div>--}}
                                    {{--                                                            <div class="item">--}}
                                    {{--                                                                <div class="item__icon">--}}
                                    {{--                                                                    <i class="fa-solid fa-envelope"></i>--}}
                                    {{--                                                                </div>--}}
                                    {{--                                                                <div class="item__wrap">--}}
                                    {{--                                                                    <span class="item__label">Email:</span>--}}
                                    {{--                                                                    <a href=""--}}
                                    {{--                                                                       class="item__link"><span>vietcare@gmail.com</span></a>--}}
                                    {{--                                                                </div>--}}
                                    {{--                                                            </div>--}}
                                    {{--                                                            <div class="item">--}}
                                    {{--                                                                <div class="item__icon">--}}
                                    {{--                                                                    <i class="fa-solid fa-location-dot"></i>--}}
                                    {{--                                                                </div>--}}
                                    {{--                                                                <div class="item__wrap">--}}
                                    {{--                                                                    <span class="item__label">Địa chỉ:</span>--}}
                                    {{--                                                                    <a href="https://maps.app.goo.gl/kjpVxAW2goAAK95g7"--}}
                                    {{--                                                                       class="item__link" target="_blank">Đường 22--}}
                                    {{--                                                                        Phường Hưng Thạnh Cái Răng</a>--}}
                                    {{--                                                                </div>--}}
                                    {{--                                                            </div>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
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

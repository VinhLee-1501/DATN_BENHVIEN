@extends('layouts.client.app')

@section('meta_title', '')

@section('content')

    <div class="main-body">
        <div class="contact__page">
            <div class="container">
                <div class="contact__page--frame">
                    <div class="row gap-y-40">
                        <div class="col l-12 mc-12 c-12">
                            <div class="box-heading text-center">
                                <h1>
                                    LIÊN HỆ NHẬN TƯ VẤN
                                    <span class="highlight">MIỄN PHÍ</span>
                                </h1>
                                <p class="description">Thường phản hồi sau 5 phút!</p>
                            </div>
                        </div>
                        <div class="col l-12 mc-12 c-12">
                            <div class="contact__form">
                                <div class="row gap-y-40">
                                    <div class="col l-6 mc-12 c-12">
                                        <div class="form contact">
                                            <div id="loading">
                                                <img
                                                    src=""
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
                                                    <div class="button btn-send btn-flex btn-left">
                                                        Gửi
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col l-6 mc-12 c-12">
                                        <div class="contact__main">
                                            <div class="row gap-y-20">
                                                <div class="col l-12 mc-12 c-12">
                                                    <h3 class="title">Thông tin địa chỉ cơ sở</h3>
                                                </div>
                                                <div class="col l-12 mc-12 c-12">
                                                    <div class="contact__map">
                                                        <iframe
                                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.687214618684!2d106.66530938511656!3d10.835231430577752!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529a9f70252a9%3A0x645ada8a0a3ecafd!2zNDggxJAuIFPhu5EgNiwgS0RDIENpdHlsYW5kIFBhcmtoaWxsLCBHw7IgVuG6pXAsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1714879539789!5m2!1svi!2s"
                                                            style="border: 0" allowfullscreen="" loading="lazy"
                                                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    </div>
                                                </div>
                                                <div class="col l-12 mc-12 c-12">
                                                    <div class="contact__list">
                                                        <div class="item">
                                                            <div class="item__icon">
                                                                <i class="fa-solid fa-phone"></i>
                                                            </div>
                                                            <div class="item__wrap">
                                                                <span class="item__label">Hotline:</span>
                                                                <a href="tel:0962672967"
                                                                   class="item__link">0962.672.967</a>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <div class="item__icon">
                                                                <i class="fa-solid fa-envelope"></i>
                                                            </div>
                                                            <div class="item__wrap">
                                                                <span class="item__label">Email:</span>
                                                                <a href=""
                                                                   class="item__link"><span>ankhang@gmail.com</span></a>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <div class="item__icon">
                                                                <i class="fa-solid fa-location-dot"></i>
                                                            </div>
                                                            <div class="item__wrap">
                                                                <span class="item__label">Địa chỉ:</span>
                                                                <a href="https://maps.app.goo.gl/kjpVxAW2goAAK95g7"
                                                                   class="item__link" target="_blank">Đường 22
                                                                    Phường Hưng Thanhk Cái Răng</a>
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
        </div>

    </div>

@endsection

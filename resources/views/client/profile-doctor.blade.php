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
                    <a href="{{ route('client.news') }}">Thông tin</a>
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
                                <span class="highlight">{{ $doctorId[0]->lastName }}
                                    {{ $doctorId[0]->firstName }}</span>
                            </h1>
                            <p class="description">Chuyên khoa {{ $doctorId[0]->specialtyName }}</p>
                        </div>
                    </div>

                    <div class="col l-12 mc-12 c-12 medicines-section">
                        <div class="contact__form">
                            <div class="row gap-y-40">
                                <div class="col l-4 mc-12 c-12">
                                    <img src="{{ asset('storage/uploads/avatars/' . $doctorId[0]->avatar) }}"
                                        alt="Ảnh bác sĩ" class="img-thumbnail" style="">
                                    <div class="row bg-primary" style="margin-left: 2px">
                                        <div class="">
                                            <h2>CHỨC VỤ - BS. {{ $doctorId[0]->lastName }} {{ $doctorId[0]->firstName }}
                                            </h2>
                                            <p class="">
                                                Bác sĩ Chuyên {{ $doctorId[0]->specialtyName }}
                                            </p>
                                        </div>
                                        {{-- <div class="">
                                            <a href="#" rel="tag">BÁC SĨ KHOA {{ $doctorId[0]->specialtyName }}
                                            </a>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col l-8 mc-12 c-12">
                                    <div class="contact__main">
                                        <div class=" gap-y-20">
                                            {{-- <div class="col l-12 mc-12 c-12">
                                                <h4 class="title">Thông tin hành chính</h4>
                                            </div> --}}
                                            <div class="col l-12 mc-12 c-12">
                                                <div class="contact__list">
                                                    <div class="item contact__list">
                                                        <div class="">
                                                            <h4 class="highlight fw-bold">Bằng cấp</h4>
                                                        </div>
                                                        <div class="col">
                                                            <i class="fa fa-graduation-cap fs-4"
                                                                style="color: #00a253; font-size: 20px"></i>
                                                            <span
                                                                class="medicines-section">{!! $doctorId[0]->degree !!}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="contact__list" style="margin-top: 20px">
                                                    <div class="item contact__list">
                                                        <div class="">
                                                            <h4 class="highlight fw-bold">Công tác công việc</h4>
                                                        </div>
                                                        <div class="col">
                                                            <i class="fa fa-id-card fs-4"
                                                                style="color: #00a253; font-size: 20px"></i>
                                                            <span
                                                                class="medicines-section">{!! $doctorId[0]->work_experience !!}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="contact__list" style="margin-top: 20px">
                                                    <div class="item contact__list">
                                                        <div class="">
                                                            <h4 class="highlight fw-bold">Mô tả</h4>
                                                        </div>
                                                        <div class="col">
                                                            <i class="fa fa-briefcase fs-4"
                                                                style="color: #00a253; font-size: 20px"></i>
                                                            <span
                                                                class="medicines-section"><br>{!! $doctorId[0]->description !!}</span>
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
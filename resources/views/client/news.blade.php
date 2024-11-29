@extends('layouts.client.app')

@section('meta_title', '')

@section('content')
    <div class="main-body">
        <div class="news__page">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="breadcrumbs-nav">
                        <div class="item">
                            <a href="{{ route('client.home') }}" title="Trang chủ">Trang chủ</a>
                        </div>
                        <div class="item sep">/</div>
                        <div class="item">
                            <a href="{{ route('client.news') }}">Tin tức</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="news__page--frame news__list">
                <div class="container">
                    <div class="row gap-y-40">
                        <div class="col l-12 mc-12 c12">
                            <div class="box-heading">
                                <h1>Tin tức</h1>
                            </div>
                        </div>
                        <div class="col l-12 mc-12 c-12">
                            <div class="news__head">
                                <div class="row gap-y-40">
                                    <div class="col l-6 mc-12 c-12">
                                        <div class="news__featured">
                                            @foreach ($newblogs as $item)
                                                <div class="item">
                                                    <div class="item__frame">
                                                        <div class="item__thumb">
                                                            <a href="{{ route('client.detailnews', ['slug' => $item->slug]) }}"
                                                                class="item__thumb--link">
                                                                @if (!empty($item->thumbnail))
                                                                    <img src="data:image/jpeg;base64,{{ $item->thumbnail }}"
                                                                        alt="{{ $item->title }}" />
                                                                @else
                                                                    <img src="path/to/default/image.jpg"
                                                                        alt="Default Image" />
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="item__body">
                                                            <h2 class="item__title">
                                                                <a href="{{ route('client.detailnews', ['slug' => $item->slug]) }}"
                                                                    class="item__link title">{{ $item->title }}</a>
                                                            </h2>
                                                            <div class="item__body--wrap">
                                                                <a href="{{ route('client.news') }}"
                                                                    class="item__category">Tin tức</a>
                                                                <div class="sep"></div>
                                                                <div class="item__published">{{ $item->date }}</div>
                                                            </div>
                                                            <div class="item__description">
                                                                {{ $item->describe }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col l-6 mc-12 c-12">
                                        <div class="news__latest">
                                            <div class="news__latest--main news__list--row">
                                                @foreach ($newblogs as $item)
                                                    <div class="row gap-y-8">
                                                        <div class="col l-12 mc-12 c-12">
                                                            <div class="item">
                                                                <div class="item__frame">
                                                                    <div class="item__thumb">
                                                                        <a href="{{ route('client.detailnews', ['slug' => $item->slug]) }}"
                                                                            class="item__thumb--link">
                                                                            @if (!empty($item->thumbnail))
                                                                                <img src="data:image/jpeg;base64,{{ $item->thumbnail }}"
                                                                                    alt="{{ $item->title }}" />
                                                                            @else
                                                                                <img src="path/to/default/image.jpg"
                                                                                    alt="Default Image" />
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    <div class="item__body">
                                                                        <h2 class="item__title">
                                                                            <a href="{{ route('client.detailnews', ['slug' => $item->slug]) }}"
                                                                                class="item__link title">{{ $item->title }}</a>
                                                                        </h2>
                                                                        <div class="item__body--wrap">
                                                                            <a href="{{ route('client.news') }}"
                                                                                class="item__category">Tin tức</a>
                                                                            <div class="sep"></div>
                                                                            <div class="item__published">
                                                                                {{ $item->date }}</div>
                                                                        </div>
                                                                        <div class="item__description">
                                                                            {{ $item->describe }}
                                                                        </div>
                                                                    </div>
                                                                </div>
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
                        <div class="col l-12 mc-12 c-12">
                            <div class="news__main">
                                <div class="row gap-y-20">
                                    <div class="col-12 l-12 mc-12 c-12">
                                        <div class="box-title">Tổng hợp</div>
                                    </div>
                                    <div class="col l-12 mc-12 c-12">
                                        <div class="news__main--result">
                                            <div class="row gap-y-20">
                                                @foreach ($blogs as $blog)
                                                    <div class="col-4 l-4 mc-6 c-12">
                                                        <div class="item" style="padding: 0px 8px 0px 8px">
                                                            <div class="item__frame">
                                                                <div class="item__thumb">
                                                                    <a href="{{ route('client.detailnews', ['slug' => $blog->slug]) }}"
                                                                        class="item__thumb--link">
                                                                        @if (!empty($blog->thumbnail))
                                                                            <img src="data:image/jpeg;base64,{{ $blog->thumbnail }}"
                                                                                alt="{{ $blog->title }}" />
                                                                        @else
                                                                            <img src="path/to/default/image.jpg"
                                                                                alt="Default Image" />
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="item__body">
                                                                    <h2 class="item__title">
                                                                        <a href="{{ route('client.detailnews', ['slug' => $blog->slug]) }}"
                                                                            class="item__link title">{{ $blog->title }}</a>
                                                                    </h2>
                                                                    <div class="item__body--wrap">
                                                                        <a href="{{ route('client.news') }}"
                                                                            class="item__category">Tin tức</a>
                                                                        <div class="sep"></div>
                                                                        <div class="item__published">{{ $blog->date }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="item__description">
                                                                        {{ $blog->describe }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="box-btn-view-more">
                                                <div class="col l-12 mc-12 c-12 text-center">
                                                    {{$blogs->links()}}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(".news__main .btn-add").click(function() {
                                    var uri = "https://phongkhamtuean.com.vn/add_item";
                                    var num_items = $(".news__main--result .item").length;
                                    var param = new Object();
                                    param.offset = num_items;

                                    $.get(uri, param).done(function(data) {
                                        $(".news__main--result .row").append(data);
                                        var num_items_new = $(".news__main--result .item").length;

                                        if (num_items_new - 6 < num_items) {
                                            $(".news__main .box-action").hide();
                                        } else {
                                            $(".news__main .box-action").fadeIn("fast");
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(".news__featured").slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    infinite: true,
                    arrows: true,
                    dots: false,
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

            <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "BreadcrumbList",
              "itemListElement": [
                {
                  "@type": "ListItem",
                  "position": 1,
                  "name": "Home",
                  "item": ""
                },
                {
                  "@type": "ListItem",
                  "position": 2,
                  "name": "Tin tức",
                  "item": ""
                }
              ]
            }
        </script>
        </div>
    @endsection

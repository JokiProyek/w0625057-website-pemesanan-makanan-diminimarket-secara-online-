@extends('layouts.app')
@section('content')
    <main>
        <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
                                                                        "autoplay": {
                                                                          "delay": 5000
                                                                        },
                                                                        "slidesPerView": 1,
                                                                        "effect": "fade",
                                                                        "loop": true
                                                                      }'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="overflow-hidden position-relative h-100">
                        <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                            <img loading="lazy" src="{{ asset('assets/images/home/demo3/slideshow-character1.png')}}"
                                width="542" height="733" alt="Woman Fashion 1"
                                class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
                            <div class="character_markup type2">
                                <p
                                    class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                                    Dresses</p>
                            </div>
                        </div>
                        <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                            <h6
                                class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                                New Arrivals</h6>
                            <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Night Spring</h2>
                            <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">Dresses</h2>
                            <a href="#"
                                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                                Now</a>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="overflow-hidden position-relative h-100">
                        <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                            <img loading="lazy" src="{{ asset('assets/images/slideshow-character1.png')}}" width="400"
                                height="733" alt="Woman Fashion 1"
                                class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
                            <div class="character_markup">
                                <p
                                    class="text-uppercase font-sofia fw-bold animate animate_fade animate_rtl animate_delay-10">
                                    Summer
                                </p>
                            </div>
                        </div>
                        <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                            <h6
                                class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                                New Arrivals</h6>
                            <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Night Spring</h2>
                            <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">Dresses</h2>
                            <a href="#"
                                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                                Now</a>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="overflow-hidden position-relative h-100">
                        <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                            <img loading="lazy" src="{{ asset('assets/images/slideshow-character2.png')}}" width="400"
                                height="690" alt="Woman Fashion 2"
                                class="slideshow-character__img animate animate_fade animate_rtl animate_delay-10 w-auto h-auto" />
                        </div>
                        <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                            <h6
                                class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                                New Arrivals</h6>
                            <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">Night Spring</h2>
                            <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">Dresses</h2>
                            <a href="#"
                                class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div
                    class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
                </div>
            </div>
        </section>
        <div class="container mw-1620 bg-white border-radius-10">
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
            <section class="category-carousel container">
                <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">You Might Like</h2>

                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider" data-settings='{
                                                                              "autoplay": {
                                                                                "delay": 5000
                                                                              },
                                                                              "slidesPerView": 8,
                                                                              "slidesPerGroup": 1,
                                                                              "effect": "none",
                                                                              "loop": false,
                                                                              "navigation": {
                                                                                "nextEl": ".products-carousel__next-1",
                                                                                "prevEl": ".products-carousel__prev-1"
                                                                              },
                                                                              "breakpoints": {
                                                                                "320": {
                                                                                  "slidesPerView": 2,
                                                                                  "slidesPerGroup": 2,
                                                                                  "spaceBetween": 15
                                                                                },
                                                                                "768": {
                                                                                  "slidesPerView": 4,
                                                                                  "slidesPerGroup": 4,
                                                                                  "spaceBetween": 30
                                                                                },
                                                                                "992": {
                                                                                  "slidesPerView": 6,
                                                                                  "slidesPerGroup": 1,
                                                                                  "spaceBetween": 45,
                                                                                  "pagination": false
                                                                                },
                                                                                "1200": {
                                                                                  "slidesPerView": 8,
                                                                                  "slidesPerGroup": 1,
                                                                                  "spaceBetween": 60,
                                                                                  "pagination": false
                                                                                }
                                                                              }
                                                                            }'>
                        <div class="swiper-wrapper">
                            @foreach($categories as $category)
                                <div class="swiper-slide">
                                    <img loading="lazy" class="w-100 h-auto"
                                        src="{{ asset('uploads/categories')}}/{{ $category->image }}" width="124" height="124"
                                        alt="" />
                                    <div class="text-center">
                                        <a href="{{route('shop.index', ['categories' => $category->id])}}"
                                            class="menu-link fw-medium">{{$category->name}}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->

                    <div
                        class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_md" />
                        </svg>
                    </div><!-- /.products-carousel__prev -->
                    <div
                        class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_md" />
                        </svg>
                    </div><!-- /.products-carousel__next -->
                </div><!-- /.position-relative -->
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
            @if(count($sproducts) > 0)
                <section class="hot-deals container">
                    <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
                    <div class="row">
                        <div
                            class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                            <h2>Summer Sale</h2>
                            <h2 class="fw-bold">Up to 60% Off</h2>

                            <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                                data-date="18-3-2024" data-time="06:50">
                                <div class="day countdown-unit">
                                    <span class="countdown-num d-block"></span>
                                    <span class="countdown-word text-uppercase text-secondary">Days</span>
                                </div>

                                <div class="hour countdown-unit">
                                    <span class="countdown-num d-block"></span>
                                    <span class="countdown-word text-uppercase text-secondary">Hours</span>
                                </div>

                                <div class="min countdown-unit">
                                    <span class="countdown-num d-block"></span>
                                    <span class="countdown-word text-uppercase text-secondary">Mins</span>
                                </div>

                                <div class="sec countdown-unit">
                                    <span class="countdown-num d-block"></span>
                                    <span class="countdown-word text-uppercase text-secondary">Sec</span>
                                </div>
                            </div>

                            <a href="{{route('shop.index')}}"
                                class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
                        </div>
                        <div class="col-md-6 col-lg-8 col-xl-80per">
                            <div class="position-relative">
                                <div class="swiper-container js-swiper-slider" data-settings='{
                                                                                                  "autoplay": {
                                                                                                    "delay": 5000
                                                                                                  },
                                                                                                  "slidesPerView": 4,
                                                                                                  "slidesPerGroup": 4,
                                                                                                  "effect": "none",
                                                                                                  "loop": false,
                                                                                                  "breakpoints": {
                                                                                                    "320": {
                                                                                                      "slidesPerView": 2,
                                                                                                      "slidesPerGroup": 2,
                                                                                                      "spaceBetween": 14
                                                                                                    },
                                                                                                    "768": {
                                                                                                      "slidesPerView": 2,
                                                                                                      "slidesPerGroup": 3,
                                                                                                      "spaceBetween": 24
                                                                                                    },
                                                                                                    "992": {
                                                                                                      "slidesPerView": 3,
                                                                                                      "slidesPerGroup": 1,
                                                                                                      "spaceBetween": 30,
                                                                                                      "pagination": false
                                                                                                    },
                                                                                                    "1200": {
                                                                                                      "slidesPerView": 4,
                                                                                                      "slidesPerGroup": 1,
                                                                                                      "spaceBetween": 30,
                                                                                                      "pagination": false
                                                                                                    }
                                                                                                  }
                                                                                                }'>
                                    <div class="swiper-wrapper">
                                        @foreach($sproducts as $sproduct)
                                            <div class="swiper-slide product-card product-card_style3">
                                                <div class="pc__img-wrapper">
                                                    <a href="{{route('shop.product.details', $sproduct->slug)}}">
                                                        <img loading="lazy"
                                                            src="{{ asset('uploads/products')}}/{{ $sproduct->image }}" width="258"
                                                            height="313" alt="Cropped Faux leather Jacket" class="pc__img">
                                                        @if($sproduct->images)
                                                            <img loading="lazy"
                                                                src="{{ asset('uploads/products')}}/{{ $sproduct->images }}" width="258"
                                                                height="313" alt="Cropped Faux leather Jacket"
                                                                class="pc__img pc__img-second">
                                                        @endif
                                                    </a>
                                                </div>

                                                <div class="pc__info position-relative">
                                                    <h6 class="pc__title"><a
                                                            href="{{route('shop.product.details', $sproduct->slug)}}">{{$sproduct->name}}</a>
                                                    </h6>
                                                    <div class="product-card__price d-flex">
                                                        <span class="money price text-secondary">
                                                            <s>Rp{{ $sproduct->regular_price }}</s> Rp{{ $sproduct->sales_price }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div><!-- /.swiper-wrapper -->
                                </div><!-- /.swiper-container js-swiper-slider -->
                            </div><!-- /.position-relative -->
                        </div>
                    </div>
                </section>
            @endif
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="category-banner container">
                <div class="row">
                    @foreach($rproducts as $rproduct)
                        <div class="col-md-6">
                            <div class="category-banner__item border-radius-10 mb-5">
                                <img loading="lazy" class="h-auto" src="{{ asset('uploads/products')}}/{{ $rproduct->image }}"
                                    width="690" height="665" alt="" />
                                <div class="category-banner__item-mark">
                                    Starting at Rp{{$rproduct->regular_price}}
                                </div>
                                <div class="category-banner__item-content">
                                    <h3 class="mb-0">{{$rproduct->name}}</h3>
                                    <a href="{{route('shop.product.details', $rproduct->slug)}}"
                                        class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
            @if(count($fproducts) > 0)
                <section class="products-grid container">
                    <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

                    <div class="row">
                        @foreach($fproducts as $fproduct)
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                                    <div class="pc__img-wrapper">
                                        <a href="{{route('shop.product.details', $fproduct->slug)}}">
                                            <img loading="lazy" src="{{ asset('uploads/products')}}/{{ $fproduct->image }}"
                                                width="330" height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                                        </a>
                                    </div>

                                    <div class="pc__info position-relative">
                                        <h6 class="pc__title"><a href="{{route('shop.product.details', $fproduct->slug)}}">{{$fproduct->name}}</a></h6>
                                        <div class="product-card__price d-flex align-items-center">
                                            <span class="money price text-secondary">
                                                @if($fproduct->sales_price)
                                                    <s>Rp{{ $fproduct->regular_price }}</s> Rp{{ $fproduct->sales_price }}
                                                @else
                                                    Rp{{ $fproduct->regular_price }}
                                                @endif
                                            </span>
                                        </div>

                                        <div
                                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                            @if(Cart::instance('cart')->content()->where('id', $fproduct->id)->count() > 0)
                                                <a href="{{ route('cart.index') }}" class="btn-link btn-link_lg me-4 text-uppercase fw-medium btn-warning">Go to cart</a>
                                                @else
                                                <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                                                @csrf
                                                    <input type="hidden" name="id" value="{{ $fproduct->id }}" />
                                                    <input type="hidden" name="quantity" value="1" />
                                                    <input type="hidden" name="name" value="{{ $fproduct->name }}" />
                                                    <input type="hidden" name="image" value="{{ $fproduct->image }}" />
                                                    <input type="hidden" name="price" value="{{ $fproduct->regular_price}}" />
                                                <button
                                                class="btn-link btn-link_lg me-4 text-uppercase fw-medium "
                                                data-aside="cartDrawer" title="Add To Cart" type="submit">Add To Cart</button>
                                                </form>
                                                @endif
                                            
                                            <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                                data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                <span class="d-none d-xxl-block">Quick View</span>
                                                <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <use href="#icon_view" />
                                                    </svg></span>
                                            </button>
                                            <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist"
                                                title="Add To Wishlist">
                                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_heart" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div><!-- /.row -->

                    <div class="text-center mt-2">
                        <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="{{ route('shop.index') }}">Load More</a>
                    </div>
                </section>
            @endif
        </div>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

    </main>
@endsection
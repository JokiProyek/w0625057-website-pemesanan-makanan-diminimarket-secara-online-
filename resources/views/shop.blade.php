@extends('layouts.app')
@section('content')
  <style>
    .brand-list li, category-list li {
      line-height: 40px;
    }

    .brand-list li .chk-brand, .chk-vendor,
    .category-list li .chk-category {
      width: 1rem;
      height: 1rem;
      color: #e4e4e4;
      border: 0.125rem solid currentColor;
      border-radius: 0;
      margin-right: 0.75rem;
    }

    .filled-heart {
      color: orange;
    }

  </style>
  <main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">
    <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
      <div class="aside-header d-flex d-lg-none align-items-center">
      <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
      <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
      </div>

      <div class="pt-4 pt-lg-0"></div>

      <!-- Product Categories -->
      <div class="accordion" id="categories-list">
      <div class="accordion-item mb-4 pb-3 category-list">
        <h5 class="accordion-header" id="accordion-heading-1">
        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
          data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
          Product Categories
          <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
          <g aria-hidden="true" stroke="none" fill-rule="evenodd">
            <path
            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
          </g>
          </svg>
        </button>
        </h5>
        <div id="accordion-filter-1" class="accordion-collapse collapse show border-0"
        aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
        <div class="accordion-body px-0 pb-0 pt-3">
          @php
      $selectedCategories = explode(',', $f_categories ?? '');
      @endphp
          <ul class="list list-inline mb-0">
          @foreach ($categories as $category)
        <li class="list-item">
        <span class="menu-link py-1">
        <input type="checkbox" class="chk-category" name="categories" value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }} />
        {{ $category->name }}
        </span>
        <span class="text-right float-end">{{ $category->products->count() }}</span>
        </li>
      @endforeach

          </ul>
        </div>
        </div>
      </div>
      </div>

      {{-- --}}
      <!-- <div class="accordion" id="color-filters">
      <div class="accordion-item mb-4 pb-3">
      <h5 class="accordion-header" id="accordion-heading-1">
      <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
      data-bs-target="#accordion-filter-2" aria-expanded="true" aria-controls="accordion-filter-2">
      Color
      <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
      <g aria-hidden="true" stroke="none" fill-rule="evenodd">
      <path
      d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
      </g>
      </svg>
      </button>
      </h5>
      <div id="accordion-filter-2" class="accordion-collapse collapse show border-0"
      aria-labelledby="accordion-heading-1" data-bs-parent="#color-filters">
      <div class="accordion-body px-0 pb-0">
      <div class="d-flex flex-wrap">
      <a href="#" class="swatch-color js-filter" style="color: #0a2472"></a>
      <a href="#" class="swatch-color js-filter" style="color: #d7bb4f"></a>
      <a href="#" class="swatch-color js-filter" style="color: #282828"></a>
      <a href="#" class="swatch-color js-filter" style="color: #b1d6e8"></a>
      <a href="#" class="swatch-color js-filter" style="color: #9c7539"></a>
      <a href="#" class="swatch-color js-filter" style="color: #d29b48"></a>
      <a href="#" class="swatch-color js-filter" style="color: #e6ae95"></a>
      <a href="#" class="swatch-color js-filter" style="color: #d76b67"></a>
      <a href="#" class="swatch-color swatch_active js-filter" style="color: #bababa"></a>
      <a href="#" class="swatch-color js-filter" style="color: #bfdcc4"></a>
      </div>
      </div>
      </div>
      </div>
      </div> -->


      <!-- <div class="accordion" id="size-filters">
      <div class="accordion-item mb-4 pb-3">
      <h5 class="accordion-header" id="accordion-heading-size">
      <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
      data-bs-target="#accordion-filter-size" aria-expanded="true" aria-controls="accordion-filter-size">
      Sizes
      <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
      <g aria-hidden="true" stroke="none" fill-rule="evenodd">
      <path
      d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
      </g>
      </svg>
      </button>
      </h5>
      <div id="accordion-filter-size" class="accordion-collapse collapse show border-0"
      aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
      <div class="accordion-body px-0 pb-0">
      <div class="d-flex flex-wrap">
      <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XS</a>
      <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">S</a>
      <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">M</a>
      <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">L</a>
      <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XL</a>
      <a href="#" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter">XXL</a>
      </div>
      </div>
      </div>
      </div>
      </div> -->


      <div class="accordion" id="brand-filters">
      <div class="accordion-item mb-4 pb-3">
        <h5 class="accordion-header" id="accordion-heading-brand">
        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
          data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
          Vendors
          <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
          <g aria-hidden="true" stroke="none" fill-rule="evenodd">
            <path
            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
          </g>
          </svg>
        </button>
        </h5>
        <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0"
        aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
        <div class="search-field multi-select accordion-body px-0 pb-0">
          <select class="d-none" multiple name="total-numbers-list">
          <option value="1">Adidas</option>
          <option value="2">Balmain</option>
          <option value="3">Balenciaga</option>
          <option value="4">Burberry</option>
          <option value="5">Kenzo</option>
          <option value="5">Givenchy</option>
          <option value="5">Zara</option>
          </select>
          <div class="search-field__input-wrapper mb-3">
          <input type="text" name="search_text"
            class="search-field__input form-control form-control-sm border-light border-2" placeholder="Search" />
          </div>
          @php
      $selectedVendors = explode(',', $f_vendors ?? '');
      @endphp
          <ul class="multi-select__list list-unstyled">
          @foreach($vendors as $vendor)
            <li class="list-item">
                <label style="display: flex; justify-content: space-between; align-items: center; width: 100%; cursor: pointer;">
                    <input type="checkbox"
                          class="chk-vendor"
                          name="vendors"
                          value="{{ $vendor->id }}"
                          {{ in_array($vendor->id, $selectedVendors) ? 'checked' : '' }}
                          style="margin-right: 10px;" />
                    <span class="me-auto">{{ $vendor->name }}</span>
                    <span class="text-secondary">{{ $vendor->products->count() }}</span>
                </label>
            </li>
        @endforeach
          </ul>
        </div>
        </div>
      </div>
      </div>


      <div class="accordion" id="price-filters">
      <div class="accordion-item mb-4">
        <h5 class="accordion-header mb-2" id="accordion-heading-price">
        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse"
          data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
          Price
          <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
          <g aria-hidden="true" stroke="none" fill-rule="evenodd">
            <path
            d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
          </g>
          </svg>
        </button>
        </h5>
        <div id="accordion-filter-price" class="accordion-collapse collapse show border-0"
        aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
        <input class="price-range-slider" type="text" name="price_range" value="" data-slider-min="10"
          data-slider-max="10000000" data-slider-step="5" data-slider-value="[{{$min_price}}, {{ $max_price }}]" data-currency="Rp" />
        <div class="price-range__info d-flex align-items-center mt-2">
          <div class="me-auto">
          <span class="text-secondary">Min Price: </span>
          <span class="price-range__min">Rp1</span>
          </div>
          <div>
          <span class="text-secondary">Max Price: </span>
          <span class="price-range__max">Rp1,000,0000</span>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>

    <div class="shop-list flex-grow-1">
      <div class="mb-3 pb-2 pb-xl-3"></div>
      <div class="d-flex justify-content-between mb-4 pb-md-2">
      <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
        <a href="{{ route('shop.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
      </div>

      <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Page Size"
        id="pagesize" name="pagesize" style="margin-right: 20px;">
        <option value="12" {{$size == 12 ? 'selected' : ''}}>Show</option>
        <option value="24" {{$size == 24 ? 'selected' : ''}}>24</option>
        <option value="48" {{$size == 48 ? 'selected' : ''}}>48</option>
        <option value="102" {{$size == 102 ? 'selected' : ''}}>102</option>
        </select>

        <select class="shop-acs__select form-select w-auto border-0 py-0 order-1 order-md-0" aria-label="Sort Items"
        name="orderby" id="orderby">
        <option value="-1" {{$order == -1 ? 'selected' : ''}}>Default</option>
        <option value="1" {{$order == 1 ? 'selected' : ''}}>Date, New To Old</option>
        <option value="2" {{$order == 2 ? 'selected' : ''}}>Date, Old To New</option>
        <option value="3" {{$order == 3 ? 'selected' : ''}}>Price, Low To High</option>
        <option value="4" {{$order == 4 ? 'selected' : ''}}>Price, High To Low</option>
        </select>

        <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div>

        <div class="col-size align-items-center order-1 d-none d-lg-flex">
        <span class="text-uppercase fw-medium me-2">View</span>
        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="2">2</button>
        <button class="btn-link fw-medium me-2 js-cols-size" data-target="products-grid" data-cols="3">3</button>
        <button class="btn-link fw-medium js-cols-size" data-target="products-grid" data-cols="4">4</button>
        </div>

        <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
        <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
          <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10" fill="none"
          xmlns="http://www.w3.org/2000/svg">
          <use href="#icon_filter" />
          </svg>
          <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
        </button>
        </div>
      </div>
      </div>

      <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
      @foreach ($products as $product)
     <div class="product-card-wrapper">
            <div class="product-card mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <a href="{{route('shop.product.details', $product->slug)}}"><img loading="lazy" src="{{ asset('uploads/products')}}/{{ $product->image }}" width="330"
                          height="400" alt="{{$product->name}}" class="pc__img"></a>
                    </div>
                    <div class="swiper-slide">
                      @foreach(explode(',', $product->images) as $gimg)
                      <a href="{{route('shop.product.details', $product->slug)}}"><img loading="lazy" src="{{asset('uploads/products')}}/ {{ $product->image }}"
                          width="330" height="400" alt="{{$product->name}}" class="pc__img"></a>
                          @endforeach
                    </div>
                  </div>
                  <span class="pc__img-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                      xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_prev_sm" />
                    </svg></span>
                  <span class="pc__img-next"><svg width="7" height="11" viewBox="0 0 7 11"
                      xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_next_sm" />
                    </svg></span>
                </div>
                @if(Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                  <a href="{{ route('cart.index') }}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium btn-warning mb-3">Go to cart</a>
                @else
                <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                   @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}" />
                    <input type="hidden" name="quantity" value="1" />
                    <input type="hidden" name="name" value="{{ $product->name }}" />
                    <input type="hidden" name="image" value="{{ $product->image }}" />
                    <input type="hidden" name="price" value="{{ $product->regular_price}}" />
                <button
                  type="submit"
                  class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium"
                  data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                  </form>
                  @endif
              </div>

              <div class="pc__info position-relative">
                <p class="pc__category">{{$product->category->name}}</p>
                <h6 class="pc__title"><a href="{{route('shop.product.details', $product->slug)}}">{{ $product->name }}</a></h6>
                <div class="product-card__price d-flex">
                  <span class="money price">
                  @if($product->sales_price)
                  <s>Rp{{ $product->regular_price }}</s> Rp{{ $product->sales_price }}
                  @else
                  Rp{{$product->regular_price}}
                  @endif
                </span>
                </div>
                <div class="product-card__review d-flex align-items-center">
                  <div class="reviews-group d-flex">
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                    <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                      <use href="#icon_star" />
                    </svg>
                  </div>
                  <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
                </div>
                
              </div>
            </div>
          </div>
    @endforeach
      </div>

      <div class="divider"></div>
      <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
      {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
      </div>
    </div>
    </section>
  </main>


  <form id="frmfilter" method="GET" action="{{ route('shop.index') }}">

    <input type="hidden" name="page" value="{{$products->currentPage()}}">
    <input type="hidden" name="size" id="size" value="{{$size}}" />
    <input type="hidden" name="order" id="order" value="{{$order}}" />
    <input type="hidden" name="categories" id="hdncategories" />
    <input type="hidden" name="vendors" id="hdnvendors" />
    <input type="hidden" name="min_price" id="hdnminprice" />
    <input type="hidden" name="max_price" id="hdnmaxprice" value="{{ $max_price }}" />
  </form>

@endsection

@push('scripts')
  <script>
    $(function () {
    $("#pagesize").on("change", function () {
      $("#size").val($("#pagesize option:selected").val());
      $("#frmfilter").submit();
    });

    $("#orderby").on("change", function () {
      $("#order").val($("#orderby option:selected").val());
      $("#frmfilter").submit();
    });

    function updateFiltersAndSubmit() {
      const selectedCategories = [];
      $("input[name='categories']:checked").each(function () {
        selectedCategories.push($(this).val());
      });
      $("#hdncategories").val(selectedCategories.join(","));

      const selectedVendors = [];
      $("input[name='vendors']:checked").each(function () {
        selectedVendors.push($(this).val());
      });
      $("#hdnvendors").val(selectedVendors.join(","));

      $("#frmfilter").submit();
    }

    $("input[name='categories']").on("change", function () {
      updateFiltersAndSubmit();
    });

    $("input[name='vendors']").on("change", function () {
      updateFiltersAndSubmit();
    });

     $("[name='price_range']").on("change", function () {
        var min = $(this).val().split(',')[0];
        var max = $(this).val().split(',')[1];
        $("#hdnminprice").val(min);
        $("#hdnmaxprice").val(max);
        setTimeout(() => {
          $("#frmfilter").submit();
        }, 2000)
    });
    });
  </script>
@endpush
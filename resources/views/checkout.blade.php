@extends('layouts.app')
@section('content')

  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
    <h2 class="page-title">Shipping and Checkout</h2>
    <div class="checkout-steps">
      <a href="{{route('cart.index')}}" class="checkout-steps__item active">
      <span class="checkout-steps__item-number">01</span>
      <span class="checkout-steps__item-title">
        <span>Shopping Bag</span>
        <em>Manage Your Items List</em>
      </span>
      </a>
      <a href="javascrip:void(0)" class="checkout-steps__item active">
      <span class="checkout-steps__item-number">02</span>
      <span class="checkout-steps__item-title">
        <span>Checkout</span>
        <em>Checkout Your Items List</em>
      </span>
      </a>
      <a href="javascrip:void(0)" class="checkout-steps__item">
      <span class="checkout-steps__item-number">03</span>
      <span class="checkout-steps__item-title">
        <span>Confirmation</span>
        <em>Review And Submit Your Order</em>
      </span>
      </a>
    </div>
    <form name="checkout-form" action="{{ route('cart.place.an.order') }}" method="POST">
      @csrf
      <div class="checkout-form">
      <div class="billing-info__wrapper">
        <div class="row">
        <div class="col-6">
          <h4>TABLE DETAILS</h4>
        </div>
        <div class="col-6">
        </div>
        </div>

        <div class="row mt-5">
        <div class="col-md-6">
          <div class="form-floating my-3">
          <input type="text" class="form-control" name="table_number" required value="{{ old('table_number') }}">
          <label for="table_number">Table Number *</label>
          <span class="text-danger"></span>
          @error('table_number')<span class="text-danger">{{ $message }}</span>@enderror
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-floating my-3">
          <select class="form-select pt-2" id="type" name="type" required>
            <option value="dine-in">Dine-in</option>
            <option value="takeaway">Takeaway</option>
            <!-- <option value="reserved">Reserved</option> -->
          </select>
          <label for="type">Dine Type *</label>
          @error('capacity')<span class="text-danger">{{ $message }}</span>@enderror
          </div>
        </div>



        <div class="col-md-6">
          <div class="form-floating my-3">
          <input type="number" class="form-control" name="capacity" value="4" min="1" required
            value="{{ old('capacity') }}">
          <label for="capacity">Capacity (Seats) *</label>
          @error('capacity')<span class="text-danger">{{ $message }}</span>@enderror
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-floating my-3">
          <textarea class="form-control" name="description" style="height: 100px;"
            value="{{ old('description') }}"></textarea>
          <label for="description">Description (optional)</label>
          </div>
        </div>
        </div>

      </div>
      <div class="checkout__totals-wrapper">
        <div class="sticky-content">
        <div class="checkout__totals">
          <h3>Your Order</h3>
          <table class="checkout-cart-items">
          <thead>
            <tr>
            <th>PRODUCT</th>
            <th align="right">SUBTOTAL</th>
            </tr>
          </thead>
          <tbody>
            @foreach (Cart::instance('cart')->content() as $item)
        <tr>
        <td>{{ $item->name }} x {{ $item->qty }}</td>
        <td align="right">Rp{{ $item->subtotal() }}</td>
        </tr>
        @endforeach
          </tbody>
          </table>

          <table class="checkout-totals">
        <tbody>
        <tr>
        <th>Subtotal</th>
        <td>Rp{{Cart::instance('cart')->subtotal()}}</td>
        </tr>
        <!-- <tr>
      <th>Shipping</th>
      <td>Free</td>
      </tr>
      <tr>
      <th>VAT</th>
      <td>${{Cart::instance('cart')->tax()}}</td>
      </tr> -->
        <tr>
        <th>Total</th>
        <td>Rp{{Cart::instance('cart')->subtotal()}}</td>
        </tr>
        </tbody>
      </table>

        </div>
        <div class="checkout__payment-methods">
          <div class="form-check">
          <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode1" value="cash">
          <label class="form-check-label" for="mode1" name="mode">
            Cash
            <p class="option-detail">
            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
            magna posuere eget.
            </p>
          </label>
          @error('mode')<span class="text-danger">{{ $message }}</span>@enderror
          </div>
          <div class="form-check">
          <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode2" value="qris">
          <label class="form-check-label" for="mode2">
            Qris
            <p class="option-detail">
            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
            magna posuere eget.
            </p>
          </label>
          @error('mode')<span class="text-danger">{{ $message }}</span>@enderror
          </div>
        </div>
        <button class="btn btn-primary btn-checkout" type="submit">PLACE ORDER</button>
        </div>
      </div>
      </div>
    </form>
    </section>
  </main>

@endsection
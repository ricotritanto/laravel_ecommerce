@extends('layouts.ecommerce');

@section('title')
    <title>shopping cart - Laravel Ecommerce</title>
@endscetion

@section('content')
    <!-- Home banner area -->
        <section class="banner_area">
            <div class="banner_inner">
                <div class="container">
                    <div class="banner_content text-center">
                            <h2>shopping cart </h2>
                            <div class="page_link">
                                <a href="{{url('/') }}">Home</a>
                                <a href="{{url(route('front.list_cart')) }}">Cart</a>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- End banner area -->

    <!-- CART area -->
        <section class="cart_area">
            <div class="container">
                <div class="cart_inner">
                    <form action="{{('')}}" method="post">
                        @csrf
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse ($carts as $row)
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="{{ asset('storage/products/' . $row['product_image']) }}" width="100px" height="100px" alt="{{ $row['product_name'] }}">
                                                </div>
                                                <div class="media-body">
                                                    <p>{{ $row['product_name'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>Rp {{ number_format($row['product_price']) }}</h5>
                                        </td>
                                        <td>
                                            <div class="product_count">
                                            <!-- PERHATIKAN BAGIAN INI, NAMENYA KITA GUNAKAN ARRAY AGAR BISA MENYIMPAN LEBIH DARI 1 DATA -->
                                                <input type="text" name="qty[]" id="sst{{ $row['product_id'] }}" maxlength="12" value="{{ $row['qty'] }}" title="Quantity:" class="input-text qty">
                                                <input type="hidden" name="product_id[]" value="{{ $row['product_id'] }}" class="form-control">
                                            <!-- PERHATIKAN BAGIAN INI, NAMENYA KITA GUNAKAN ARRAY AGAR BISA MENYIMPAN LEBIH DARI 1 DATA -->
                            
                            
                                                <button onclick="var result = document.getElementById('sst{{ $row['product_id'] }}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                                class="increase items-count" type="button">
                                                    <i class="lnr lnr-chevron-up"></i>
                                                </button>
                                                <button onclick="var result = document.getElementById('sst{{ $row['product_id'] }}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                                class="reduced items-count" type="button">
                                                    <i class="lnr lnr-chevron-down"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>Rp {{ number_format($row['product_price'] * $row['qty']) }}</h5>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">Tidak ada belanjaan</td>
                                    </tr>
                                    @endforelse
                                    <tr class="bottom_button">
                                        <td>
                                            <button class="gray_btn">Update Cart</button>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </form>
                                    <tr>
                                        <td>

                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <h5>Subtotal</h5>
                                        </td>
                                        <td>
                                            <h5>Rp {{ number_format($subtotal) }}</h5>
                                        </td>
                                    </tr>
                                    

                                    <tr class="out_button_area">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="checkout_btn_inner">
                                                <a class="gray_btn" href="{{ route('front.product') }}">Continue Shopping</a>
                                                <a class="main_btn" href="{{ route('front.checkout') }}">Proceed to checkout</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
            </div>   
        </section>

@endsection
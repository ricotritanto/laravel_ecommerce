@extends('layouts.ecommerce')

@section('title')
	<title>Sale {{ $products->name}}</title>
@endsection

@section('content')
@include('layouts.ecommerce.module.navigation')
<!-- banner -->
<div class="banner banner10">
		<div class="container">
			<h2>Product</h2>
		</div>
	</div>
	<!-- //banner -->   
	<!-- breadcrumbs -->
	<div class="breadcrumb_dress">
		<div class="container">
			<ul>
				<li><a href="{{url('/')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a> <i>/</i></li>
				<li>Product</li>
			</ul>
		</div>
	</div>
    <!-- //breadcrumbs -->  
    
    <!-- single -->
	<div class="single">
		<div class="container">
			<div class="col-md-4 single-left">
				<div class="flexslider">
					<ul class="slides">
						<li data-thumb="{{ asset('storage/products/' . $products->image) }}">
							<div class="thumb-image"> <img src="{{ asset('storage/products/' . $products->image) }}"" data-imagezoom="true" class="img-responsive" alt=""> </div>
						</li>
					</ul>
				</div>
				<!-- flexslider -->
					<script defer src="{{ asset('ecommerce/thema-b/js/jquery.flexslider.js')}}"></script>
					<link rel="stylesheet" href="{{ asset('ecommerce/thema-b/css/flexslider.css')}}" type="text/css" media="screen" />
					<script>
					// Can also be used with $(document).ready()
					$(window).load(function() {
					  $('.flexslider').flexslider({
						animation: "slide",
						controlNav: "thumbnails"
					  });
					});
					</script>
				<!-- flexslider -->
				<!-- zooming-effect -->
					<script src="{{ asset('ecommerce/thema-b/js/imagezoom.js')}}"></script>
				<!-- //zooming-effect -->
			</div>
			<div class="col-md-8 single-right">
				<h3>{{ $products->name }}</h3>
				<div class="rating1">
					<span class="starRating">
						<input id="rating5" type="radio" name="rating" value="5">
						<label for="rating5">5</label>
						<input id="rating4" type="radio" name="rating" value="4">
						<label for="rating4">4</label>
						<input id="rating3" type="radio" name="rating" value="3" checked>
						<label for="rating3">3</label>
						<input id="rating2" type="radio" name="rating" value="2">
						<label for="rating2">2</label>
						<input id="rating1" type="radio" name="rating" value="1">
						<label for="rating1">1</label>
					</span>
				</div>
				<div class="description">
					<h5><i>Description</i></h5>
					<p>{!! $products->description !!}</p>
				</div>
				<div class="color-quality">					
					<div class="clearfix"> </div>
                </div>
                <div class="occasional">
					<h5>Weight :</h5>
					<div class="colr ert">
						<div class="check">
							<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i> </i>{{ $products->weight }} gr</label>
						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="simpleCart_shelfItem">
					<p><i class="item_price">Rp {{ number_format($products->price) }}</i></p>
				</div> 
			</div>
			<div class="clearfix"> </div>
		</div>
    </div> 
    <!-- Related Products -->
	<div class="w3l_related_products">
		<div class="container">
            <h3>Related Products</h3>
           	
			<ul id="flexiselDemo2">	 	 
				@forelse ($products1 as $row)
				<li>
					<div class="w3l_related_products_grid">
						<div class="agile_ecommerce_tab_left mobiles_grid">
							<div class="hs-wrapper hs-wrapper3">
								<img src="{{ asset('storage/products/' . $row->image) }}" alt=" " class="img-responsive" />
								<img src="{{ asset('storage/products/' . $row->image) }}" alt=" " class="img-responsive" />
							
							</div>
							<h5><a href="{{ url('/product/' . $row->slug) }}">{{$row->name}}</a></h5>
							<div class="simpleCart_shelfItem"> 
								<p class="flexisel_ecommerce_cart"><i class="item_price">Rp {{ number_format($row->price) }}</i></p>
							</div>
						</div>
					</div>
                </li>
                @endforeach
            </ul>
            
				<script type="text/javascript">
					$(window).load(function() {
						$("#flexiselDemo2").flexisel({
							visibleItems:4,
							animationSpeed: 1000,
							autoPlay: true,
							autoPlaySpeed: 3000,    		
							pauseOnHover: true,
							enableResponsiveBreakpoints: true,
							responsiveBreakpoints: { 
								portrait: { 
									changePoint:480,
									visibleItems: 1
								}, 
								landscape: { 
									changePoint:640,
									visibleItems:2
								},
								tablet: { 
									changePoint:768,
									visibleItems: 3
								}
							}
						});
						
					});
				</script>
				<script type="text/javascript" src="{{ asset('ecommerce/thema-b/js/jquery.flexisel.js')}}"></script>
		</div>
	</div>
    <!-- //Related Products -->

@endsection
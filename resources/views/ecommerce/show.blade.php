@extends('layouts.ecommerce')

@section('title')
	<title>Sale {{ $products->name}}</title>
@endsection

@section('content')
@include('layouts.ecommerce.module.navigation')
<!-- banner -->
<div class="banner banner10">
		<div class="container">
			<h2>Single Page</h2>
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
           	
			<ul id="flexiselDemo2">	 	 @forelse ($products1 as $row)
				<li>
					<div class="w3l_related_products_grid">
						<div class="agile_ecommerce_tab_left mobiles_grid">
							<div class="hs-wrapper hs-wrapper3">
								<img src="{{ asset('storage/products/' . $row->image) }}" alt=" " class="img-responsive" />
								<img src="{{ asset('storage/products/' . $row->image) }}" alt=" " class="img-responsive" />
								<div class="w3_hs_bottom">
									<div class="flex_ecommerce">
										<a href="#" data-toggle="modal" data-target="#myModal6"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
									</div>
								</div>
							</div>
							<h5><a href="single.html">{{$row->name}}</a></h5>
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
	<div class="modal video-modal fade" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModal6">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
				</div>
				<section>
					<div class="modal-body">
						<div class="col-md-5 modal_body_left">
							<img src="images/34.jpg" alt=" " class="img-responsive" />
						</div>
						<div class="col-md-7 modal_body_right">
							<h4>Musical Kids Toy</h4>
							<p>Ut enim ad minim veniam, quis nostrud 
								exercitation ullamco laboris nisi ut aliquip ex ea 
								commodo consequat.Duis aute irure dolor in 
								reprehenderit in voluptate velit esse cillum dolore 
								eu fugiat nulla pariatur. Excepteur sint occaecat 
								cupidatat non proident, sunt in culpa qui officia 
								deserunt mollit anim id est laborum.</p>
							<div class="rating">
								<div class="rating-left">
									<img src="images/star-.png" alt=" " class="img-responsive" />
								</div>
								<div class="rating-left">
									<img src="images/star-.png" alt=" " class="img-responsive" />
								</div>
								<div class="rating-left">
									<img src="images/star-.png" alt=" " class="img-responsive" />
								</div>
								<div class="rating-left">
									<img src="images/star.png" alt=" " class="img-responsive" />
								</div>
								<div class="rating-left">
									<img src="images/star.png" alt=" " class="img-responsive" />
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="modal_body_right_cart simpleCart_shelfItem">
								<p><span>$150</span> <i class="item_price">$100</i></p> 
								<form action="#" method="post">
									<input type="hidden" name="cmd" value="_cart">
									<input type="hidden" name="add" value="1"> 
									<input type="hidden" name="w3ls_item" value="Kids Toy"> 
									<input type="hidden" name="amount" value="100.00">   
									<button type="submit" class="w3ls-cart">Add to cart</button>
								</form>
							</div>
							<h5>Color</h5>
							<div class="color-quality">
								<ul>
									<li><a href="#"><span></span></a></li>
									<li><a href="#" class="brown"><span></span></a></li>
									<li><a href="#" class="purple"><span></span></a></li>
									<li><a href="#" class="gray"><span></span></a></li>
								</ul>
							</div>
						</div>
						<div class="clearfix"> </div>
					</div>
				</section>
			</div>
		</div>
	</div>

@endsection
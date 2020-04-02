@extends('layouts.ecommerce')

@section('title')
	<title>About Us</title>
@endsection

@section('content')
@include('layouts.ecommerce.module.navigation')
<!-- banner -->
<div class="banner banner1">
		<div class="container">
			<h2>Great Offers on <span>Camera</span> Flat <i>35% Discount</i></h2> 
		</div>
	</div> 
	<!-- breadcrumbs -->
	<div class="breadcrumb_dress">
		<div class="container">
			<ul>
				<li><a href="{{url('/')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a> <i>/</i></li>
				<li>Products</li>
			</ul>
		</div>
	</div>
    <!-- //breadcrumbs --> 
    
    <!-- mobiles -->
	<div class="mobiles">
		<div class="container">
			<div class="w3ls_mobiles_grids">
				<div class="col-md-4 w3ls_mobiles_grid_left">
					<div class="w3ls_mobiles_grid_left_grid">
						<h3>Categories</h3>
						<div class="w3ls_mobiles_grid_left_grid_sub">
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                              @foreach ($categories as $category)
							  <div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
								  <h4 class="panel-title asd">
									<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$category->id}}" aria-expanded="false" aria-controls="collapseTwo">
									  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>{{$category->name}}
									</a>
								  </h4>
								</div>
								<div id="{{$category->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								   <div class="panel-body panel_text">
                                    @foreach ($category->child as $child)
									<ul>
										<li><a href="{{ url('/category/' . $child->slug) }}">{{$child->name}}</a></li>
                                    </ul>
                                    @endforeach
								  </div>
								</div>
                              </div>
                              @endforeach
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8 w3ls_mobiles_grid_right">
					<div class="w3ls_mobiles_grid_right_grid2">
						<div class="w3ls_mobiles_grid_right_grid2_left">
							<h3>Showing Results: 0-1</h3>
						</div>						
						<div class="clearfix"> </div>
                    </div>
					<div class="w3ls_mobiles_grid_right_grid3">    
                        @forelse ($products as $row)                
						<div class="col-md-4 agileinfo_new_products_grid agileinfo_new_products_grid_mobiles">
							<div class="agile_ecommerce_tab_left mobiles_grid">                            
								<div class="hs-wrapper hs-wrapper2">
									<img src="{{ asset('storage/products/' . $row->image) }}" alt=" " class="img-responsive" />
									<img src="{{ asset('storage/products/' . $row->image) }}" alt=" " class="img-responsive" />
								</div>
								<h5><a href="{{ url('/product/' . $row->slug) }}">{{$row->name}}</a></h5> 
								<div class="simpleCart_shelfItem">
									<p><i class="item_price">Rp {{ number_format($row->price) }}</i></p>									
								</div> 
                            </div>                       
                        </div>
                        @endforeach
                        <div class="clearfix"> </div>
                    
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
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
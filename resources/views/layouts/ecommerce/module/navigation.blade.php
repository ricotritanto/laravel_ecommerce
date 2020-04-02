<!-- navigation -->
<div class="navigation">
    <div class="container">
        <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header nav_2">
                <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div> 
            <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
                <ul class="nav navbar-nav">
                    <li><a href="{{url('/')}}" class="act">Home</a></li>	
                    <!-- Mega Menu -->
                    <li class="dropdown">
                        <a href="{{ route('front.product')}}" class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
                        <ul class="dropdown-menu multi-column columns-3">
                            <div class="row">
                            @foreach ($categories as $category)
                                <div class="col-sm-3">
                                    <ul class="multi-column-dropdown">                                    
                                        <h6>{{$category->name}}</h6>
                                        @foreach ($category->child as $child)
                                        <li><a href="{{ url('/category/' . $child->slug) }}">{{$child->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                                <div class="clearfix"></div>
                            </div>
                        </ul>
                    </li>
                    <li><a href="{{ route('front.about') }}">About Us</a></li> 
                    <li><a href="{{ route('front.contact') }}">Contact Us</a></li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- //navigation -->
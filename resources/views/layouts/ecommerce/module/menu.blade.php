
<ul class="nav navbar-nav center_nav pull-right">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('front.index') }}">Home</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('front.product') }}">Product</a>
       
        <!-- <ul class="dropdown-menu"> @foreach ($categories as $category)
            <li class="nav-item submenu dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropright" role="button" href="#">{{$category->name}}</a>  
            </li>
            @endforeach
        </ul> -->
    </li>

    <li class="nav-item submenu dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop</a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a class="nav-link" href="category.html">Shop Category</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url(route('front.list_cart'))}}">Shop Cart</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('customer.orders')}}">Confirmation</a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('front.contact') }}">Contact</a>
    </li>
</ul>

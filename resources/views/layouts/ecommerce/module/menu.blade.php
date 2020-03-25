
<ul class="nav navbar-nav center_nav pull-right">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('front.index') }}">Home</a>
    </li>

    <li class="nav-item submenu dropdown">
        <a class="nav-link dropdown-toggle" href="{{ route('front.product') }}" data-toggle="dropdown" role="button">Product</a>
        <ul class="dropdown-menu">
        @foreach ($categories as $category)
            <li class="nav-item dropdown-right">
                <a class="nav-link dropdown-toggle" data-toggle="dropright" role="button" href="#">{{$category->name}}</a>                
                <ul class="nav-item dropdown-content">               
                @foreach($category->child as $child)
                    <li class="nav-item dropdown-right">
                        <a class="nav-link dropdown-toggle" data-toggle="dropright" role="button" href="#">{{ $child->name}}</a>
                    </li>     
                @endforeach           
                </ul>
            </li>
            @endforeach
        </ul>
    </li>

    <li class="nav-item submenu dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop</a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a class="nav-link" href="category.html">Shop Category</a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="contact.html">Contact</a>
    </li>
</ul>

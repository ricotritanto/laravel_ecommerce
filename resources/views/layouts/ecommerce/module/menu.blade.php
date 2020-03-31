<ul class="nav navbar-nav center_nav pull-right">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('front.index') }}">Home</a>
    </li>
    <li class="nav-item submenu dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="{{ route('front.product') }}" role="button" aria-haspopup="true" aria-expanded="false">Product</a>
        <ul class="dropdown-menu">
            @forelse ($category as $row)
            <li class="nav-item">
                <a href="" class="nav-link">$row->name</a>
            </li>
            @empty
                        <div class="col-md-12">
                            <h3 class="text-center">Empty Product</h3>
                        </div>
            @endforelse
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
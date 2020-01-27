<nav class="sidebar-nav">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon icon-speedometer"></i> Dashboard
            </a>
        </li>

        <li class="nav-title">MANAJEMEN PRODUCTS</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('category.index')}}">
                <i class="nav-icon icon-drop"></i> Category
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('product.index')}}">
                <i class="nav-icon icon-drop"></i> Products
            </a>
        </li>

        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-settings"></i> Setting
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon icon-puzzle"></i> Toko
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
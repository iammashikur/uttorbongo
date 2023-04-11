<style>
.brand-image {
    height: 35px !important;
    width: 30px !important;
    object-fit: cover !important;
    object-position: left !important;
    margin: 0px;
    margin-left: 0.4rem !important;
    margin-top: unset !important;
}

.brand-title {
    height: 35px !important;
    width: 80px !important;
    object-fit: cover !important;
    object-position: right !important;
}
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <div class="brand-image">
            <img src="https://ubongo.com.bd/assets/media/logos/logo.svg" alt="Vemto Logo" class="brand-image">
        </div>
        <span class="brand-text font-weight-light"><img src="https://ubongo.com.bd/assets/media/logos/logo.svg" class="brand-title" alt="Vemto Logo"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://ubongo.com.bd/storage/3pWHgQ5Mm3HFemk8sZxnHccxJIAtwHvOQxfru0XD.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Mashikur Rahman</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">

                @auth
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="nav-icon fa-duotone fa-heart-pulse"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>


                    @can('view-any', App\Models\Product::class)
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link">

                                <i class="nav-icon fa-duotone fa-laptop-mobile"></i>

                                <p>
                                    Products

                                </p>

                            </a>
                        </li>
                    @endcan



                    @can('view-any', App\Models\ProductCategory::class)
                        <li class="nav-item">
                            <a href="{{ route('product-categories.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-rectangle-vertical-history"></i>

                                <p>
                                    Product Categories

                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\Seller::class)
                        <li class="nav-item">
                            <a href="{{ route('sellers.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-user-hair"></i>

                                <p>
                                    Sellers

                                </p>

                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\Supplier::class)
                        <li class="nav-item">
                            <a href="{{ route('suppliers.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-truck-field"></i>

                                <p>
                                    Suppliers

                                </p>

                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\SupplierReturn::class)
                        <li class="nav-item">
                            <a href="{{ route('supplier-returns.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-house-person-return"></i>

                                <p>
                                    Supplier Returns

                                </p>

                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\Shop::class)
                        <li class="nav-item">
                            <a href="{{ route('shops.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-shop"></i>

                                <p>
                                    Shops

                                </p>

                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\Branch::class)
                        <li class="nav-item">
                            <a href="{{ route('branches.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-code-branch"></i>

                                <p>
                                    Branches

                                </p>


                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\User::class)
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-user-group-crown"></i>

                                <p>
                                    Users

                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\Sale::class)
                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-cart-plus"></i>

                                <p>
                                    Sales

                                </p>

                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\Brand::class)
                        <li class="nav-item">
                            <a href="{{ route('brands.index') }}" class="nav-link">

                                <i class="nav-icon fa-duotone fa-frame"></i>
                                <p>
                                    Brands

                                </p>

                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\Buyer::class)
                        <li class="nav-item">
                            <a href="{{ route('buyers.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-user-tie"></i>

                                <p>
                                    Buyers

                                </p>


                            </a>
                        </li>
                    @endcan
                    @can('view-any', App\Models\Due::class)
                        <li class="nav-item">
                            <a href="{{ route('dues.index') }}" class="nav-link">
                                <i class="nav-icon fa-duotone fa-envelope-open-dollar"></i>

                                <p>
                                    Dues

                                </p>



                            </a>
                        </li>
                    @endcan


                    @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) ||
                            Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-duotone fa-user-lock"></i>
                                <p>
                                    Access Management


                                    <i class="nav-icon right fa-duotone fa-arrow-left"></i>

                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view-any', Spatie\Permission\Models\Role::class)
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}" class="nav-link">
                                            <i class="nav-icon icon ion-md-radio-button-off"></i>
                                            <p>Roles</p>
                                        </a>
                                    </li>
                                @endcan

                                @can('view-any', Spatie\Permission\Models\Permission::class)
                                    <li class="nav-item">
                                        <a href="{{ route('permissions.index') }}" class="nav-link">
                                            <i class="nav-icon icon ion-md-radio-button-off"></i>
                                            <p>Permissions</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                @endauth


                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="nav-icon fa-duotone fa-sign-out-alt"></i>
                            <p>{{ __('Logout') }}</p>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

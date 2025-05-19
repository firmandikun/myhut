<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ url('/') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
        </a>
    </div>

    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li class="dropdown">
                <a href="/">
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- PRODUCT --}}
            <li class="sidebar-menu-group-title">Product</li>
            <li>
                <a href="/products/list">
                    <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                    <span>List Product</span>
                </a>
            </li>
            @if(Auth::user()->role === 'admin')
                <li>
                    <a href="/products/create">
                        <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                        <span>Create Product</span>
                    </a>
                </li>
            @endif

            {{-- CATEGORY --}}
            <li class="sidebar-menu-group-title">Categories</li>
            <li>
                <a href="/categories">
                    <iconify-icon icon="solar:layers-minimalistic-outline" class="menu-icon"></iconify-icon>
                    <span>List Category</span>
                </a>
            </li>
            @if(Auth::user()->role === 'admin')
                <li>
                    <a href="/categories/create">
                        <iconify-icon icon="solar:add-circle-linear" class="menu-icon"></iconify-icon>
                        <span>Create Category</span>
                    </a>
                </li>
            @endif

            {{-- OPERATIONAL CATEGORIES --}}
            <li class="sidebar-menu-group-title">Operational Categories</li>
            <li>
                <a href="/operations">
                    <iconify-icon icon="mdi:clipboard-list-outline" class="menu-icon"></iconify-icon>
                    <span>List Operational</span>
                </a>
            </li>
            @if(Auth::user()->role === 'admin')
                <li>
                    <a href="/operations/create">
                        <iconify-icon icon="mdi:plus-box-outline" class="menu-icon"></iconify-icon>
                        <span>Create Operational</span>
                    </a>
                </li>
            @endif

            <li>
                <a href="/operations/categories/list">
                    <iconify-icon icon="mdi:clipboard-list-outline" class="menu-icon"></iconify-icon>
                    <span>List Operational Category</span>
                </a>
            </li>
            @if(Auth::user()->role === 'admin')
                <li>
                    <a href="/operations/categories/create">
                        <iconify-icon icon="mdi:plus-box-outline" class="menu-icon"></iconify-icon>
                        <span>Create Operational Category</span>
                    </a>
                </li>
            @endif

            {{-- STORE --}}
            <li class="sidebar-menu-group-title">Store</li>
            <li>
                <a href="/stores">
                    <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                    <span>List Store</span>
                </a>
            </li>
            @if(Auth::user()->role === 'admin')
                <li>
                    <a href="/stores/create">
                        <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                        <span>Create Store</span>
                    </a>
                </li>
            @endif

            {{-- TRANSACTIONS --}}
            <li class="sidebar-menu-group-title">Transactions</li>
            <li>
                <a href="/transactions">
                    <iconify-icon icon="solar:cart-outline" class="menu-icon"></iconify-icon>
                    <span>Sales Transactions</span>
                </a>
            </li>
            @if(Auth::user()->role === 'admin')
                <li>
                    <a href="/transactions/create">
                        <iconify-icon icon="heroicons:plus-circle" class="menu-icon"></iconify-icon>
                        <span>Create Sales Transaction</span>
                    </a>
                </li>
            @endif

            <li>
                <a href="/purchases">
                    <iconify-icon icon="solar:bag-outline" class="menu-icon"></iconify-icon>
                    <span>Purchase Transactions</span>
                </a>
            </li>
            @if(Auth::user()->role === 'admin')
                <li>
                    <a href="/purchases/create">
                        <iconify-icon icon="heroicons:plus-circle" class="menu-icon"></iconify-icon>
                        <span>Create Purchase Transaction</span>
                    </a>
                </li>
            @endif

            {{-- REPORT --}}
            <li>
                <a href="/transactions/report">
                    <iconify-icon icon="solar:chart-line-outline" class="menu-icon"></iconify-icon>
                    <span>Report</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">

        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ url('backend/images/FutureCRM.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ url('backend/images/FutureCRM.png') }}" alt="" height="25">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ url('backend/images/FutureCRM.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ url('backend/images/FutureCRM.png') }}" alt="" height="25">
            </span>
        </a>





        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                            Dashboard</span>
                    </a>
                </li>
                @can('manage_bankers')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('bankers.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                            Bankers</span>
                    </a>
                </li>
                @endcan
                @can('manage_clients')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('clients.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                            Clients</span>
                    </a>
                </li>
                @endcan

                @can('request_bank_account')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('bank-accounts.create') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                             Request a bank account</span>
                    </a>
                </li>
                @endcan
              
                @can('request_debit_card')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('card-requests.create') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                             Request a card</span>
                    </a>
                </li>
                @endcan
                @can('approve_bank_accounts')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('bank-accounts.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                            Bank Accounts Requests</span>
                    </a>
                </li>
                @endcan
                @can('approve_debit_cards')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('card-requests.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                            Debit Cards Requests</span>
                    </a>
                </li>
                @endcan
                @can('view_all_accounts')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('bank-accounts.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                            Bank Accounts</span>
                    </a>
                </li>
                @endcan
                @can('view_all_cards')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('bank-accounts.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                            Cards</span>
                    </a>
                </li>
                @endcan
                @can('view_own_transactions')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('transactions.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                            Transactions</span>
                    </a>
                </li>
                @endcan
                @can('view_transactions')
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('transactions.create') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-Dashboard">
                            Create Transactions</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
     
        </ul>
    </div>
    <!-- Sidebar -->
</div>

<div class="sidebar-background"></div>
</div>

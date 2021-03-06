<nav class="hidden position-fixed d-flex flex-column justify-content-between p-3" id="sidebar">
    <div id="toggleNav" class="justify-content-center align-items-center">
        <i class="fas fa-lg fa-bars"></i>
    </div>
    <div id="navTop">
        <a href="{{ route('home') }}">
            <div class="d-flex justify-content-center align-items-center flex-wrap border-bottom pb-5">
                <i class="far fa-money-bill-alt fa-3x" id="logoIcon"></i>
                <span class="ml-2" id="logotype">BitChest</span>
            </div>
        </a>
        <ul class="my-5 p-0">
            <a href="{{ route('currencies.index') }}">
                <li class="sidebar-item d-flex align-items-center mb-2 @if($section == 'currencies') active @endif">
                    <i class="fab fa-lg fa-bitcoin"></i>
                    <span class="text-capitalize ml-2">Les cryptomonnaies</span>
                </li>
            </a>
            @if (Auth::user()->status == 'client')
                <a href="{{ route('wallet') }}">
                    <li class="sidebar-item d-flex align-items-center mb-2 @if($section == 'wallet') active @endif">
                        <i class="fas fa-lg fa-wallet"></i>
                        <span class="text-capitalize ml-2">Mon portefeuille</span>
                    </li>
                </a>
            @endif
            @if (Auth::user()->status == 'admin')
                <a href="{{ route('users.index') }}">
                    <li class="sidebar-item d-flex align-items-center mb-2 @if($section == 'users') active @endif">
                        <i class="fas fa-lg fa-users"></i>
                        <span class="text-capitalize ml-2">Les utilisateurs</span>
                    </li>
                </a>
            @endif
            <a href="{{ route('account.edit') }}">
                <li class="sidebar-item d-flex align-items-center mb-2 @if($section == 'account') active @endif">
                    <i class="fas fa-lg fa-user-circle"></i>
                    <span class="text-capitalize ml-2">Mon compte</span>
                </li>
            </a>
        </ul>
        @if (Auth::user()->status == 'client')
            <div>
                <span class="text-capitalize">Mon solde : </span>
                <span id="balance">{{ session('balance') }} {{ config('currency')['symbol'] }}</span>
            </div>
        @endif
    </div>
    <div id="navBottom" class="d-flex justify-content-between">
        <a href="{{ route('logout') }}" class="flex-grow-1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <div class="sidebar-item d-flex align-items-center">
                <i class="fas fa-lg fa-sign-out-alt"></i>
                <span class="text-capitalize ml-2">Déconnexion</span>
            </div>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <div class="sidebar-item align-items-center justify-content-end flex-grow-1" id="closeNav">
            <i class="fas fa-lg fa-times-circle"></i>
            <span class="text-capitalize ml-2">Fermer</span>
        </div>
    </div>
</nav>

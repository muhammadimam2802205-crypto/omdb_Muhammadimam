<div class="main-sidebar sidebar-style-2" tabindex="1" style="overflow: hidden; outline: none;">
    <aside id="sidebar-wrapper">

        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">
                {{ Auth::user()->name ?? __('Guest') }}
            </a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">Ac</a>
        </div>

        <ul class="sidebar-menu">

            <li class="menu-header">
                {{ __('Pages') }}
            </li>

            <li class="dropdown active">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-film"></i>

                    <span>{{ __('Movies') }}</span>
                </a>

                <ul class="dropdown-menu">

                    <li>
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            {{ __('Search Movies') }}
                        </a>
                    </li>

                    <li>
                        <a class="nav-link" href="{{ route('Fav') }}">
                            {{ __('My Favorites') }}
                        </a>
                    </li>

                </ul>
            </li>

        </ul>
    </aside>
</div>
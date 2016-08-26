<nav class="uk-navbar main-nav">

    <a class="uk-navbar-brand uk-hidden-small" href="/">#fsociety</a>

    <ul class="uk-navbar-nav uk-hidden-small">

        {{--<li class="uk-parent" data-uk-dropdown>--}}
        {{--<a href="">Parent</a>--}}
        {{--<div class="uk-dropdown uk-dropdown-navbar">--}}
        {{--<ul class="uk-nav uk-nav-navbar">--}}
        {{--<li class="uk-nav-header">Header</li>--}}
        {{--<li><a href="#">Item</a></li>--}}
        {{--<li><a href="#">Item</a></li>--}}
        {{--<li class="uk-nav-divider"></li>--}}
        {{--<li><a href="#">Separated item</a></li>--}}
        {{--<li class="uk-parent">--}}
        {{--<a href="#">Parent</a>--}}
        {{--<ul class="uk-nav-sub">--}}
        {{--<li><a href="#">Sub item</a>--}}
        {{--<ul>--}}
        {{--<li><a href="#">Sub item</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</div>--}}
        {{--</li>--}}

        {{--<li class="uk-parent uk-active" data-uk-dropdown>--}}
        {{--<a href="">Active</a>--}}
        {{--<div class="uk-dropdown uk-dropdown-navbar">--}}
        {{--<div class="uk-panel">Lorem ipsum dolor sit amet, consectetur <a href="#">adipisicing</a> elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>--}}
        {{--</div>--}}
        {{--</li>--}}
        <li>
            <a href="{{route('chat')}}">
                Chat
            </a>
        </li>
        <li>
            {{--<a href="">ARG Links</a>--}}
        </li>

    </ul>
    <ul class="uk-navbar-nav uk-navbar-flip">
        @if (Auth::guest())
            <li><a href="{{ url('/login') }}">Login</a></li>
            <li><a href="{{ url('/register') }}">Register</a></li>
        @else
            <li class="uk-parent" data-uk-dropdown>
                <a href="">{{ Auth::user()->name }} <i class="uk-icon-caret-down"></i></a>
                <div class="uk-dropdown uk-dropdown-navbar">
                    <ul class="uk-nav uk-nav-navbar">
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
    </ul>
    <a href="#" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas="{target:'#offcanvas-1'}"></a>
</nav>
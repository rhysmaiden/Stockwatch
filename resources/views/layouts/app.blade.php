<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stock Watch') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="app-wrapper">
<!-- <flash-message class="myCustomClass"></flash-message> -->
    <aside>
        <button class="button-base toggle" @click="toggleNavbar()" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <font-awesome-icon icon="bars" size="lg"/>
        </button>

        <a class="logo" v-bind:class="[isActive ? 'full' : 'mini']" href="{{ url('/') }}">
            @include('logo')
        </a>
    </aside>
    <nav id="menu" role="navigation" class="sidebar-nav" v-bind:class="[isActive ? 'open' : 'closed']">
        @guest
        @else
            <div class="profile-wrap">
                <!-- turn back on when profile pics work -->
            <!-- <img src="{{ asset('/storage/avatar-default.svg') }}" title="Profile image" class="profile-pic" /> -->
                <div class="profile-name">
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </div>
        @endguest

        <ul class="sidebar-nav-list">
            <li>
                <a href="/dashboard" title="Dashboard" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="columns" fixed-width />
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Dashboard</span>
                </a>
            </li>
            @if(in_array(\App\Models\Season::current()->status, ['open','closed']))
            <li>
                <a href="/trades" title="Trades" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="chart-line" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Trade</span> </a>
            </li>
            <li>
                <a href="/projections" title="Projections" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="eye" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Projections</span> </a>
            </li>
            @endif
            <li>
                <a href="/leaderboard" title="Leaderboard" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="award" fixed-width />
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Leaderboard</span>
                </a>
            </li>
            <li class="last-item">
                <a href="/account" title="Account" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="user-circle" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Account</span> </a>
            </li>
            @if(!\Auth::user()->permissions->isEmpty() || !\Auth::user()->roles->isEmpty())
                <li>
                    <a href="/admin" title="Admin" class="item-wrap">
                        <figure>
                            <font-awesome-icon icon="user-shield" fixed-width/>
                        </figure>
                        <span v-bind:class="[isActive ? 'full' : 'mini']">Admin</span> </a>
                </li>
            @endif
            <li>
                <a href="/faq" title="Frequently Asked Questions" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="info-circle" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">FAQ</span> </a>
            </li>

            @guest
                <li>
                    <a class="item-wrap" title="Login" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li>
                        <a class="item-wrap" title="Register" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li>
                    <a href="{{ env('FEEDBACK_URL') }}" title="Bug Reports" class="item-wrap">
                        <figure>
                            <font-awesome-icon icon="bug" fixed-width/>
                        </figure>
                        <span v-bind:class="[isActive ? 'full' : 'mini']">Report a Bug</span> </a>
                </li>
                <li>
                    <a class="item-wrap" title="Logout" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <figure>
                            <font-awesome-icon icon="sign-out-alt" fixed-width/>
                        </figure>
                        <span v-bind:class="[isActive ? 'full' : 'mini']">{{ __('Logout') }}</span> </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
        <div class="native-collapse-wrap sidebar-collapse mg-btm-md">
            <details>
                <summary>
                    <div class="chevron">
                        <span v-bind:class="[isActive ? 'full' : 'mini']">Social</span>
                        <font-awesome-icon class="chevron-icon" icon="chevron-down" fixed-width/>
                    </div>
                </summary>
                <ul class="sidebar-nav-list">
                    <li>
                        <a href="https://robhasawebsite.com/shows/big-brother-podcast-rhap/big-brother-canada-big-brother/" title="Rob Has a Podcast" class="item-wrap" target="_blank" rel="noreferrer noopener">
                            <figure>
                                <font-awesome-icon icon="microphone" fixed-width/>
                            </figure>
                            <span v-bind:class="[isActive ? 'full' : 'mini']">Podcasts</span> </a>
                    </li>
                    <li>
                        <a href="https://www.twitch.tv/taranarmstrong/" title="Taran's Twitch Stream" class="item-wrap" target="_blank" rel="noreferrer noopener">
                            <figure>
                                <font-awesome-icon :icon="['fab', 'twitch']" fixed-width/>
                            </figure>
                            <span v-bind:class="[isActive ? 'full' : 'mini']">Twitch</span> </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/ArmstrongTaran" title="Taran on Twitter" class="item-wrap" target="_blank" rel="noreferrer noopener">
                            <figure>
                                <font-awesome-icon :icon="['fab', 'twitter']" fixed-width/>
                            </figure>
                            <span v-bind:class="[isActive ? 'full' : 'mini']">Twitter</span> </a>
                    </li>
                </ul>
            </details>
        </div>
    </nav>
    <main id="panel" class="app-content">
        @if(Auth::user()->id === 58)
            <div id="collision-banner" class="ohno flash__message">
                <p>
                    There has been an issue detected with this account. You may have experienced this as your
                    username changing or the wrong stocks being purchased. (If you have observed neither of
                    these effects and you think you may be seeing this message in error, you are welcome to
                    reach out to us at the email below for confirmation)
                </p>
                <p>
                    Unfortunately, correcting the issue will result in the complete loss of any data associated
                    with this account. To continue playing the Stockwatch, please sign in using a different social network.
                </p>
                <p>
                    Since the market is already closed for the week, if you email us us at
                    <a href="mailto:hello@realitystockwatch.com">hello@realitystockwatch.com</a> with both your new
                    username and the social network you signed in with, we will assign your account a credit to
                    compensate for the loss of stocks.
                </p>
            </div>
        @endif
        @yield('content')
    </main>
    <footer class="footer">
        <ul>
            <li>
                <a href="/tos" title="Terms of Service"> Terms of Service </a>
            </li>
            <li>
                <a href="/privacy" title="Privacy Policy"> Privacy Policy </a>
            </li>
            <li>
                <a href="mailto:hello@realitystockwatch.com" title="Email StockWatch"> hello@realitystockwatch.com </a>
            </li>
        </ul>

        <p>&copy; {{ date('Y') }} Reality Stock Watch. All Rights Reserved.</p>
    </footer>
</div>
@include('fathom')
</body>
</html>

@auth
@php($notifications = notifications())
@endauth
        <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __("Liman Sistem Yönetimi") }}</title>

    <!-- Scripts -->

    <script src="{{asset('js/liman.js')}}"></script>
    <script src="{{ asset('js/bootstrap-native-v4.min.js') }}"></script>

    <!-- Styles -->

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa.min.css') }}">

    @if(\Session::has('dark_mode'))
        <link rel="stylesheet" href="{{ asset('css/dark.css') }}">
    @endif
</head>
<body style="display: block">
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0">
    <span class="navbar-brand col-sm-3 col-md-2 mr-0" style="cursor: default">
        <span style="line-height: 30px;padding-left: 30px;cursor: pointer;" onclick="location.href = '{{route('home')}}'"><b>{{ __("Liman") }}</b></span></span>
    @auth
        <input class="form-control form-control-dark w-80" type="text" placeholder="{{ __("Arama") }}"
               aria-label="{{ __("Arama") }}" onkeyup="search();" id="search_input">
        <ul class="dropdown" style="list-style: none;margin-bottom:0px">
        <span class="px-3 text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
              style="cursor: pointer;">
            @if(count($notifications) > 0)
                <i id="full_bell" style="position: absolute;top:20%;left: 60%;" class="fas fa-bell bell" onclick="read()"></i>
            @else
                <i id="empty_bell" style="position: absolute;top:20%;left: 60%;" class="far fa-bell"></i>
            @endif
        </span>
            <ul id="notificationDiv" class="dropdown-menu shadow-lg border-dark"
                style="width: 400px;margin-left: -250px;">
                @include('__system__.notifications',$notifications)
            </ul>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item text-nowrap">
                <form action="#" onsubmit="return request('{{route('set_locale')}}',this,reload)"
                      style="cursor: pointer;">
                    @if (Session::get('locale') == "en")
                        <input type="hidden" name="locale" value="tr">
                        <button class="btn btn-link text-white-">
                            English
                        </button>
                    @else
                        <input type="hidden" name="locale" value="en">
                        <button class="btn btn-link text-white">
                            Türkçe
                        </button>
                    @endif

                </form>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item text-nowrap">
                <form action="#" onsubmit="return request('{{route('set_theme')}}',this,reload)"
                      style="cursor: pointer;">
                    @if (Session::has('dark_mode'))
                        <button class="btn btn-link text-white-">
                            Gece
                        </button>
                    @else
                        <button class="btn btn-link text-white">
                            Gunduz
                        </button>
                    @endif

                </form>
            </li>
        </ul>
        <ul class="navbar-nav px-2">
            <li class="nav-item text-nowrap" style="cursor: pointer;">
                <a class="nav-link text-white" onclick="return request('{{route('logout')}}',new FormData(),reload)"><i
                            class="fas fa-sign-out-alt"></i></a>
            </li>
        </ul>
    @endauth
</nav>
<div class="container-fluid">
    <div class="row">
        @auth
            <div class="sidebar">
                <ul class="sidebar-nav">
                    <li>
                        <a href="{{route('home')}}">
                            <i class="fas fa-home"></i>&nbsp;
                            <span>{{ __("Genel Durum") }}</span>
                            <span class="badge badge-info badge-pill" id="home_notifications"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('servers')}}">
                            <i class="fas fa-server"></i>&nbsp;
                            <span>{{ __("Sunucular") }}</span>
                            <span class="badge badge-info badge-pill" id="server_notifications"></span>
                        </a>
                    </li>
                    @foreach($extensions as $extension)
                        @p('extension',$extension->_id)
                        <li>
                            <a href="/l/{{$extension->_id}}">
                                @if($extension->icon)
                                    <i class="fas fa-{{$extension->icon}}"></i>&nbsp;
                                @else
                                    <i class="fas fa-circle"></i>&nbsp;
                                @endif
                                <span>{{ __($extension->name) }}</span>
                                <span class="badge badge-info badge-pill"
                                      id="{{strtolower($extension->name)}}_notifications"></span>
                            </a>
                        </li>
                        @endp
                    @endforeach
                    @p('script')
                    <li>
                        <a href="{{route('scripts')}}">
                            <i class="fas fa-subscript"></i>&nbsp;
                            <span>{{ __("Betikler") }}</span>
                            <span class="badge badge-info badge-pill" id="script_notifications"></span>
                        </a>
                    </li>
                    @endp
                    <li>
                        <a href="{{route('keys')}}">
                            <i class="fas fa-key"></i>&nbsp;
                            <span>{{ __("Anahtarlar") }}</span>
                            <span class="badge badge-info badge-pill" id="key_notifications"></span>
                        </a>
                    </li>
                    @p('extension_manager')
                    <li>
                        <a href="{{route('extensions_settings')}}">
                            <i class="fas fa-plus"></i>&nbsp;
                            <span>{{ __("Eklentiler") }}</span>
                            <span class="badge badge-info badge-pill" id="extensions_notifications"></span>
                        </a>
                    </li>
                    @endp
                    @p('settings')
                    <li>
                        <a href="{{route('settings')}}">
                            <i class="fas fa-cog"></i>&nbsp;
                            <span>{{ __("Ayarlar") }}</span>
                            <span class="badge badge-info badge-pill" id="settings_notifications"></span>
                        </a>
                    </li>
                    @endp
                    @if(Auth::user()->isAdmin() == false)
                        <li>
                            <a href="{{route('request_permission')}}">
                                <i class="fas fa-lock"></i>&nbsp;
                                <span>{{ __("Yetki Talebi") }}</span>
                                <span class="badge badge-info badge-pill" id="request_notifications"></span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{route('request_list')}}">
                                <i class="fas fa-lock"></i>&nbsp;
                                <span>{{ __("Yetki Talepleri") }}</span>
                                <span class="badge badge-info badge-pill" id="request_list_notifications"></span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        @endauth
        <main role="main">
            @yield('content')
        </main>
    </div>
    @include('__system__.loading')
</div>
<script>
    function read(){
        document.getElementById("full_bell").className="far fa-bell";
    }
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $rtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pacyaya') — {{ __('ui.site_tagline') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="{{ $rtl ? 'rtl' : '' }}">
<div class="banner"><b>{{ __('ui.banner_new') }}</b> {{ __('ui.banner_text') }} <a href="{{ route('printers.index') }}">{{ __('ui.banner_cta') }} {{ $arrow }}</a></div>
<header class="nav">
    <div class="container">
        <div class="nav-left">
            <a class="brand" href="{{ route('home') }}"><i>P</i>acyaya</a>
            <nav class="nav-links">
                <a href="{{ route('templates.index') }}">{{ __('ui.nav_mockups') }}</a>
                <a href="{{ route('tools.dieline') }}">{{ __('ui.nav_dielines') }}</a>
                <a href="{{ route('tools.index') }}">{{ __('ui.nav_tools') }}</a>
                <a href="{{ route('printers.index') }}">{{ __('ui.nav_printers') }}</a>
                <a href="{{ route('pricing') }}">{{ __('ui.nav_pricing') }}</a>
            </nav>
        </div>
        <nav class="nav-links">
            <a class="lang" href="{{ route('lang', $rtl ? 'en' : 'ar') }}">🌐 {{ __('ui.lang_switch') }}</a>
            @auth
                <a href="{{ route('designs.index') }}">{{ __('ui.nav_designs') }}</a>
                <a href="{{ route('orders.index') }}">{{ __('ui.nav_orders') }}</a>
                @if(auth()->user()->isAdmin())<a href="{{ route('admin.dashboard') }}">{{ __('ui.nav_admin') }}</a>@endif
                <form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button class="link">{{ __('ui.logout') }}</button></form>
            @else
                <a class="btn sm" href="{{ route('login') }}">{{ __('ui.login') }}</a>
            @endauth
        </nav>
    </div>
</header>
<main class="container">
    @if(session('status'))<div class="flash">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="errors">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
</main>
@yield('content')
<footer class="footer">
    <div class="container">
        <div class="cols">
            <div><a class="brand" href="{{ route('home') }}" style="display:inline"><i>P</i>acyaya</a>
                <p style="font-size:13px;color:#8b86a3;max-width:260px">{{ __('ui.footer_tag') }}</p></div>
            <div><h5>{{ __('ui.nav_mockups') }}</h5>
                <a href="{{ route('templates.index') }}">{{ __('ui.all_mockups') }}</a>
                @foreach(['box-mockups','pouch-bag-mockups','bottle-mockups','can-jar-mockups','tube-mockups','cup-container-mockups','food-packaging','gift-boxes'] as $s)
                    <a href="{{ route('templates.index', ['category' => $s]) }}">{{ __('catalog.categories.' . $s) !== 'catalog.categories.' . $s ? __('catalog.categories.' . $s) : ucwords(str_replace('-', ' ', $s)) }}</a>
                @endforeach</div>
            <div><h5>{{ __('ui.nav_dielines') }}</h5>
                @foreach(['tuck','tray','lid','envelope'] as $ty)
                    <a href="{{ route('tools.dieline', ['type' => $ty]) }}">{{ __('ui.dl_' . $ty) }}</a>
                @endforeach</div>
            <div><h5>{{ __('ui.nav_tools') }}</h5>
                <a href="{{ route('tools.index') }}">{{ __('ui.all_tools') }}</a>
                <a href="{{ route('tools.dieline') }}">{{ __('ui.dieline_maker') }}</a>
                <a href="{{ route('designs.index') }}">{{ __('ui.creator3d') }}</a>
                <a href="{{ route('printers.index') }}">{{ __('ui.print_market') }}</a>
                <h5 style="margin-top:22px">{{ __('ui.company') }}</h5>
                <a href="{{ route('pricing') }}">{{ __('ui.nav_pricing') }}</a>
                <a href="{{ route('login') }}">{{ __('ui.login') }}</a>
                <a href="{{ route('register') }}">{{ __('ui.register') }}</a></div>
        </div>
        <div class="copy"><span>© {{ date('Y') }} Pacyaya</span><span>{{ __('ui.privacy') }}</span></div>
    </div>
</footer>
@stack('scripts')
</body>
</html>

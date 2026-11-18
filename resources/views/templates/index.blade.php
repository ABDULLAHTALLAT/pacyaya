@extends('layouts.app')
@section('title', __('ui.mk_title'))
@php use App\Support\Photo; @endphp
@section('content')
<div class="container mk">
    <aside class="mk-side">
        <a class="mk-item {{ !$active ? 'on' : '' }}" href="{{ route('templates.index') }}">▢ {{ __('ui.all') }}</a>
        @foreach($categories as $c)
            <a class="mk-item {{ $active === $c->slug ? 'on' : '' }}" href="{{ route('templates.index', ['category' => $c->slug]) }}">
                <span>{{ $c->icon }}</span> {{ $c->label }}
            </a>
        @endforeach
    </aside>
    <div class="mk-main">
        <div class="mk-banner">
            <div class="mk-bn-txt">
                <div class="crumb"><a href="{{ route('home') }}">{{ __('ui.home') }}</a> / <span>{{ __('ui.nav_mockups') }}</span></div>
                <h1><span class="purple">{{ $rtl ? '⬅' : '➜' }}</span> {{ __('ui.mk_title') }}</h1>
                <p>{{ __('ui.mk_desc') }}</p>
                <form method="GET" class="mk-search">
                    @if($active)<input type="hidden" name="category" value="{{ $active }}">@endif
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('ui.search_ph') }}">
                    <button>🔍</button>
                </form>
            </div>
            <div class="mk-bn-img">
                @if($hero = Photo::find('categories', 'box-mockups'))<img src="{{ $hero }}" alt="">@endif
            </div>
        </div>
        <div class="mk-bar">
            <span>{{ __('ui.mk_count', ['n' => $templates->count()]) }}</span>
            <form method="GET">
                @if($active)<input type="hidden" name="category" value="{{ $active }}">@endif
                @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                {{ __('ui.sort_by') }}
                <select name="sort" onchange="this.form.submit()">
                    <option value="popular" @selected(request('sort', 'popular') === 'popular')>{{ __('ui.sort_popular') }}</option>
                    <option value="name" @selected(request('sort') === 'name')>{{ __('ui.sort_name') }}</option>
                    <option value="new" @selected(request('sort') === 'new')>{{ __('ui.sort_new') }}</option>
                </select>
            </form>
        </div>
        <div class="mk-grid">
            @forelse($templates as $t)
            @php($img = Photo::find('templates', $t->slug) ?: Photo::find('categories', $t->category->slug))
            <a class="mk-card" href="{{ route('designs.create', $t) }}">
                <div class="mk-img">
                    <span class="b3d">3D</span>
                    @if($img)<img src="{{ $img }}" alt="{{ $t->label }}" loading="lazy">@else @include('partials.product-thumb', ['shape' => $t->shape, 'color' => $t->default_color])@endif
                </div>
                <div class="mk-name">{{ $t->label }}</div>
                <div class="mk-sw"><i style="background:{{ $t->default_color }}"></i><i style="background:#e5e5e8"></i></div>
            </a>
            @empty
                <p>{{ __('ui.none_found') }}</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

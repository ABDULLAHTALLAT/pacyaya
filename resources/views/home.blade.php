@extends('layouts.app')
@php
    use App\Support\Photo;
    $shapeMap = ['bottle-mockups' => 'bottle', 'water-bottle-mockups' => 'bottle', 'supplement-bottle-mockups' => 'bottle', 'can-jar-mockups' => 'cylinder', 'tube-mockups' => 'cylinder', 'cup-container-mockups' => 'cylinder'];
@endphp
@php
    $sliderFiles = collect(glob(public_path('images/slider/*.{jpg,jpeg,png,webp}'), GLOB_BRACE) ?: [])->map(fn ($f) => asset('images/slider/' . basename($f)))->values();
    $svgTiles = [['box','#d6c7ff'],['bottle','#a5f3fc'],['cylinder','#fde68a'],['box','#fbcfe8'],['bottle','#bbf7d0'],['cylinder','#fecaca'],['box','#fed7aa'],['bottle','#c4b5fd']];
@endphp
@section('content')
<section class="hero">
    <div class="container">
        <h1>{{ __('ui.home_title1') }}<br>{{ __('ui.home_title2') }} <span class="purple">Pacyaya</span> @include('partials.eyes')</h1>
        <div class="grid c3">
            <a class="fcard g1" href="{{ route('templates.index') }}"><h3>{{ __('ui.card_mockup') }}</h3><span class="arrow">{{ $arrow }}</span>
                <div class="slider">
                    @foreach([0, 1] as $r)
                    <div class="row {{ $r ? 'r2' : '' }}">
                        @for($loop2 = 0; $loop2 < 2; $loop2++)
                            @if($sliderFiles->count())
                                @foreach($sliderFiles->slice($r * 3)->concat($sliderFiles->take($r * 3)) as $f)<div class="tile"><img src="{{ $f }}" alt=""></div>@endforeach
                            @else
                                @foreach(collect($svgTiles)->slice($r * 4)->concat(collect($svgTiles)->take($r * 4)) as $t)<div class="tile">@include('partials.product-thumb', ['shape' => $t[0], 'color' => $t[1]])</div>@endforeach
                            @endif
                        @endfor
                    </div>
                    @endforeach
                </div></a>
            <a class="fcard g2" href="{{ route('tools.dieline') }}"><h3>{{ __('ui.card_dieline') }}</h3><span class="arrow">{{ $arrow }}</span>
                @if($cardPhoto = Photo::find('home', 'card-dieline'))<img class="fphoto" src="{{ $cardPhoto }}" alt="">@else<div class="fart dl-art" data-type="tuck" data-color="1"></div>@endif</a>
            <a class="fcard g3" href="{{ route('printers.index') }}"><h3>{{ __('ui.print_market') }}</h3><span class="arrow">{{ $arrow }}</span>
                <div class="fart">@include('partials.product-thumb', ['shape' => 'box', 'color' => '#fbcfe8'])@include('partials.product-thumb', ['shape' => 'box', 'color' => '#bbf7d0'])</div></a>
        </div>
    </div>
</section>

<section class="section"><div class="container">
    <h2 class="h-arrow">{{ __('ui.top_mockups') }}</h2>
    <div class="grid c4">
        @foreach($categories->take(12) as $c)
        <a class="ccard" href="{{ route('templates.index', ['category' => $c->slug]) }}">
            <div><h4>{{ $c->label }}</h4><small>{{ $c->templates_count }}</small><div style="margin-top:14px">{{ $arrow }}</div></div>
            <div class="cart">@include('partials.product-thumb', ['shape' => $shapeMap[$c->slug] ?? 'box', 'color' => $c->color, 'slug' => $c->slug, 'kind' => 'categories'])</div>
        </a>
        @endforeach
    </div>
    <p style="margin-top:22px"><a class="btn" href="{{ route('templates.index') }}">{{ __('ui.view_all_mockups') }} {{ $arrow }}</a></p>
</div></section>

<section class="section"><div class="container">
    <h2 class="h-arrow">{{ __('ui.top_dielines') }}</h2>
    <div class="grid c4">
        @foreach(['tuck','tray','lid','envelope'] as $ty)
        <a class="ccard dlcard" href="{{ route('tools.dieline', ['type' => $ty]) }}">
            <div><h4>{{ __('ui.dl_' . $ty) }}</h4><div style="margin-top:34px">{{ $arrow }}</div></div>
            <div class="cart dl-art" data-type="{{ $ty }}"></div>
        </a>
        @endforeach
    </div>
    <p style="margin-top:22px"><a class="btn" href="{{ route('tools.dieline') }}">{{ __('ui.open_dieline_maker') }} {{ $arrow }}</a></p>
</div></section>

<section class="section lav"><div class="container">
    <h2 class="h-arrow">{{ __('ui.stunning_tools') }}</h2>

    <div class="tool">
        <div class="vis v1">
            @if($p = Photo::find('home', 'tool1'))<img src="{{ $p }}" alt="" class="vis-img">@else<div class="stage" id="hero-stage" style="height:300px;background:none"></div>@endif
        </div>
        <div class="txt"><h3>{{ __('ui.tool1_title') }}</h3><p>{{ __('ui.tool1_text') }}</p>
            <div><a class="btn" href="{{ route('templates.index') }}">{{ __('ui.tool1_cta') }}</a> <a class="btn ghost" href="{{ route('tools.index') }}">{{ __('ui.learn_more') }}</a></div></div>
    </div>

    <div class="tool">
        <div class="txt"><h3>{{ __('ui.tool2_title') }}</h3><p>{{ __('ui.tool2_text') }}</p>
            <div><a class="btn" href="{{ route('tools.dieline') }}">{{ __('ui.tool2_cta') }}</a> <a class="btn ghost" href="{{ route('tools.index') }}">{{ __('ui.learn_more') }}</a></div></div>
        <div class="vis v2">
            @if($p = Photo::find('home', 'tool2'))<img src="{{ $p }}" alt="" class="vis-img">@else<div class="dl-art" data-type="tuck" data-color="1" style="width:90%;height:260px"></div>@endif
        </div>
    </div>

    <div class="tool">
        <div class="vis v3">
            @if($p = Photo::find('home', 'tool3'))<img src="{{ $p }}" alt="" class="vis-img">@else<div style="height:240px">@include('partials.product-thumb', ['shape' => 'box', 'color' => '#6c2bff'])</div>@endif
        </div>
        <div class="txt"><h3>{{ __('ui.tool3_title') }}</h3><p>{{ __('ui.tool3_text') }}</p>
            <div><a class="btn" href="{{ route('templates.index') }}">{{ __('ui.tool3_cta') }}</a> <a class="btn ghost" href="{{ route('tools.index') }}">{{ __('ui.learn_more') }}</a></div></div>
    </div>

    <div class="tool">
        <div class="txt"><h3>{{ __('ui.tool4_title') }}</h3><p>{{ __('ui.tool4_text') }}</p>
            <div><a class="btn" href="{{ route('printers.index') }}">{{ __('ui.tool4_cta') }}</a> <a class="btn ghost" href="{{ route('tools.index') }}">{{ __('ui.learn_more') }}</a></div></div>
        <div class="vis v4">
            @if($p = Photo::find('home', 'tool4'))<img src="{{ $p }}" alt="" class="vis-img">@else<div style="height:240px;display:flex;gap:10px">@include('partials.product-thumb', ['shape' => 'box', 'color' => '#bbf7d0'])@include('partials.product-thumb', ['shape' => 'box', 'color' => '#fbcfe8'])</div>@endif
        </div>
    </div>
</div></section>

<section class="section"><div class="container">
    <h2 class="h-arrow">{{ __('ui.popular') }}</h2>
    <div class="grid c4">
        @foreach($featured as $t)
        <a class="card" href="{{ route('designs.create', $t) }}">
            <div class="thumb" style="background:{{ $t->default_color }}33">@include('partials.product-thumb', ['shape' => $t->shape, 'color' => $t->default_color, 'slug' => $t->slug, 'kind' => 'templates'])</div>
            <h3>{{ $t->label }}</h3><p>{{ $t->width }} × {{ $t->height }} × {{ $t->depth }} {{ __('ui.cm') }}</p>
        </a>
        @endforeach
    </div>
</div></section>

<section class="cta"><div class="container">
    <h2>{{ __('ui.cta_start') }} <span class="purple">{{ $rtl ? '⬅' : '➜' }}</span> PACYAYA! @include('partials.eyes')</h2>
    <a class="pill" href="{{ route('tools.index') }}">{{ __('ui.view_all_tools') }} <span class="purple">{{ $arrow }}</span></a>
</div></section>
@endsection
@push('scripts')
<script src="{{ asset('js/dielines.js') }}"></script>
<script src="{{ asset('js/eyes.js') }}"></script>
<script>
    document.querySelectorAll('.dl-art').forEach(function (el) {
        var svg = PacDieline.build(el.dataset.type, 100, 60, 140, 0.5, true);
        el.innerHTML = svg.replace('<svg ', '<svg style="width:100%;height:100%" ');
        if (el.dataset.color) el.querySelectorAll('g').forEach(function (g, i) { g.setAttribute('stroke', i ? '#2563eb' : '#e11d48'); });
    });
</script>
@if(!App\Support\Photo::find('home', 'tool1'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('js/box3d.js') }}"></script>
<script>
    var hero = new Box3D(document.getElementById('hero-stage'), {shape: 'box', w: 24, h: 10, d: 18, color: '#6c2bff', text: 'Pacyaya', fontSize: 90});
    setInterval(function () { hero.toggle(); }, 3500);
</script>
@endif
@endpush

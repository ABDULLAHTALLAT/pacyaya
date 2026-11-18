@extends('layouts.app')
@section('title', __('ui.nav_printers'))
@section('content')
<section class="section"><div class="container">
    <h2 class="h-arrow">{{ __('ui.printers_title') }}</h2><p class="sub">{{ __('ui.printers_sub') }}</p>
    <div class="grid c3">
        @foreach($printers as $p)
        <div class="card">
            <div class="thumb" style="background:{{ $p->color }}66">@include('partials.product-thumb', ['shape' => 'box', 'color' => $p->color, 'slug' => $p->slug, 'kind' => 'printers'])</div>
            <h3>{{ $p->name }}</h3>
            <p>{{ $p->city }}, {{ $p->country }}</p>
            <p style="margin:8px 0">{{ $p->description }}</p>
            <span class="chip">★ {{ $p->rating }}</span>
            <span class="chip">{{ __('ui.from') }} {{ number_format($p->price_per_unit, 2) }}</span>
            <span class="chip">{{ __('ui.min') }} {{ $p->min_qty }}</span>
            <span class="chip">{{ $p->lead_days }} {{ __('ui.days') }}</span>
        </div>
        @endforeach
    </div>
</div></section>
@endsection

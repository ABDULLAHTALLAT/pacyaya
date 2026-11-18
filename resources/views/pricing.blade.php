@extends('layouts.app')
@section('title', __('ui.nav_pricing'))
@section('content')
<section class="section"><div class="container">
    <h2 class="h-arrow">{{ __('ui.nav_pricing') }}</h2>
    <p class="sub">{{ __('ui.pricing_sub') }}</p>
    <div class="grid c3">
        <div class="plan"><h3>{{ __('ui.plan_designer') }}</h3><div class="price">{{ __('ui.free') }}</div>
            <ul><li>{{ __('ui.pf1') }}</li><li>{{ __('ui.pf2') }}</li><li>{{ __('ui.pf3') }}</li><li>{{ __('ui.pf4') }}</li></ul>
            <a class="btn" href="{{ route('register') }}">{{ __('ui.get_started') }}</a></div>
        <div class="plan"><h3>{{ __('ui.plan_print') }}</h3><div class="price">{{ __('ui.per_order') }}</div>
            <ul><li>{{ __('ui.pf5') }}</li><li>{{ __('ui.pf6') }}</li><li>{{ __('ui.pf7') }}</li></ul>
            <a class="btn ghost" href="{{ route('printers.index') }}">{{ __('ui.nav_printers') }}</a></div>
        <div class="plan"><h3>{{ __('ui.plan_studio') }}</h3><div class="price">{{ __('ui.soon') }}</div>
            <ul><li>{{ __('ui.pf8') }}</li><li>{{ __('ui.pf9') }}</li><li>{{ __('ui.pf10') }}</li></ul>
            <span class="btn ghost" style="opacity:.5;cursor:default">{{ __('ui.not_available') }}</span></div>
    </div>
</div></section>
@endsection

@extends('layouts.app')
@section('title', __('ui.nav_designs'))
@section('content')
<section class="section"><div class="container">
    <h2 class="h-arrow">{{ __('ui.nav_designs') }}</h2><p class="sub">{{ __('ui.my_designs_sub') }}</p>
    <div class="grid c4">
        @forelse($designs as $d)
        <div class="card">
            <div class="thumb" style="background:{{ $d->color }}33">@include('partials.product-thumb', ['shape' => $d->shape, 'color' => $d->color, 'slug' => $d->template->slug, 'kind' => 'templates'])</div>
            <h3>{{ $d->name }}</h3>
            <p>{{ $d->template->label }} · {{ $d->width }}×{{ $d->height }}×{{ $d->depth }} {{ __('ui.cm') }}</p>
            <p style="margin-top:10px;display:flex;gap:6px;flex-wrap:wrap">
                <a class="btn sm" href="{{ route('designs.edit', $d) }}">{{ __('ui.edit') }}</a>
                <a class="btn sm ghost" href="{{ route('orders.create', $d) }}">{{ __('ui.ed_order') }}</a>
                <form method="POST" action="{{ route('designs.destroy', $d) }}" class="inline" onsubmit="return confirm('{{ __('ui.confirm_delete') }}')">@csrf @method('DELETE')<button class="btn sm danger">{{ __('ui.delete') }}</button></form>
            </p>
        </div>
        @empty
            <p>{{ __('ui.no_designs') }} <a href="{{ route('templates.index') }}" class="purple">{{ __('ui.pick_template') }}</a></p>
        @endforelse
    </div>
</div></section>
@endsection

@extends('layouts.app')
@section('title', __('ui.orders_title'))
@section('content')
<section class="section"><div class="container">
    <h2 class="h-arrow">{{ __('ui.orders_title') }}</h2>
    <table class="table">
        <tr><th>#</th><th>{{ __('ui.col_design') }}</th><th>{{ __('ui.col_printer') }}</th><th>{{ __('ui.col_qty') }}</th><th>{{ __('ui.col_total') }}</th><th>{{ __('ui.col_status') }}</th><th>{{ __('ui.col_date') }}</th></tr>
        @forelse($orders as $o)
        <tr>
            <td>{{ $o->id }}</td><td>{{ $o->design->name }}</td><td>{{ $o->printer->name }}</td>
            <td>{{ $o->quantity }}</td><td>{{ number_format($o->total, 2) }}</td>
            <td><span class="badge">{{ __('ui.status_' . $o->status) }}</span></td><td>{{ $o->created_at->format('Y-m-d') }}</td>
        </tr>
        @empty
        <tr><td colspan="7">{{ __('ui.no_orders') }}</td></tr>
        @endforelse
    </table>
</div></section>
@endsection

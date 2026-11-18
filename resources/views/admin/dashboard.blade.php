@extends('layouts.app')
@section('title', __('ui.nav_admin'))
@section('content')
<section class="section"><div class="container">
    <h2 class="h-arrow">{{ __('ui.dashboard') }}</h2>
    <div class="grid c4" style="margin-bottom:26px">
        @foreach($stats as $label => $value)
        <div class="card"><p>{{ __('ui.stat_' . strtolower($label)) }}</p><div class="stat">{{ $value }}</div></div>
        @endforeach
    </div>
    <h2 class="h-arrow">{{ __('ui.latest_orders') }}</h2>
    <table class="table">
        <tr><th>#</th><th>{{ __('ui.customer') }}</th><th>{{ __('ui.col_design') }}</th><th>{{ __('ui.col_printer') }}</th><th>{{ __('ui.col_qty') }}</th><th>{{ __('ui.col_total') }}</th><th>{{ __('ui.col_status') }}</th></tr>
        @foreach($orders as $o)
        <tr>
            <td>{{ $o->id }}</td><td>{{ $o->user->name }}</td><td>{{ $o->design->name }}</td><td>{{ $o->printer->name }}</td>
            <td>{{ $o->quantity }}</td><td>{{ number_format($o->total, 2) }}</td>
            <td>
                <form method="POST" action="{{ route('admin.orders.update', $o) }}" style="display:flex;gap:6px">@csrf @method('PATCH')
                    <select name="status">@foreach($statuses as $s)<option value="{{ $s }}" @selected($o->status === $s)>{{ __('ui.status_' . $s) }}</option>@endforeach</select>
                    <button class="btn sm">{{ __('ui.save') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div></section>
@endsection

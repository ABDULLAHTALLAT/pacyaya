@extends('layouts.app')
@section('title', __('ui.order_prints'))
@section('content')
<div class="container" style="max-width:720px;padding:30px 24px">
    <h2 class="h-arrow">{{ __('ui.order_prints') }}: {{ $design->name }}</h2>
    <form method="POST" action="{{ route('orders.store', $design) }}" class="card">@csrf
        <label>{{ __('ui.col_printer') }}</label>
        <select name="printer_id" required>
            @foreach($printers as $p)
                <option value="{{ $p->id }}" @selected(old('printer_id') == $p->id)>{{ $p->name }} — {{ $p->city }} · {{ __('ui.from') }} {{ number_format($p->price_per_unit, 2) }} · {{ __('ui.min') }} {{ $p->min_qty }} · {{ $p->lead_days }} {{ __('ui.days') }}</option>
            @endforeach
        </select>
        <label>{{ __('ui.col_qty') }}</label><input type="number" name="quantity" value="{{ old('quantity', 100) }}" min="1" required>
        <label>{{ __('ui.contact_name') }}</label><input type="text" name="contact_name" value="{{ old('contact_name', auth()->user()->name) }}" required>
        <label>{{ __('ui.phone') }}</label><input type="text" name="phone" value="{{ old('phone') }}" required>
        <label>{{ __('ui.address') }}</label><textarea name="address" rows="3" required>{{ old('address') }}</textarea>
        <label>{{ __('ui.notes') }}</label><textarea name="notes" rows="2">{{ old('notes') }}</textarea>
        <p style="margin-top:16px"><button class="btn purple">{{ __('ui.place_order') }}</button></p>
    </form>
</div>
@endsection

@extends('layouts.app')
@section('title', __('ui.register'))
@section('content')
<div class="auth card">
    <h2>{{ __('ui.create_account') }}</h2>
    <form method="POST" action="{{ route('register') }}">@csrf
        <label>{{ __('ui.name') }}</label><input type="text" name="name" value="{{ old('name') }}" required>
        <label>{{ __('ui.email') }}</label><input type="email" name="email" value="{{ old('email') }}" required>
        <label>{{ __('ui.password') }}</label><input type="password" name="password" required>
        <label>{{ __('ui.confirm_password') }}</label><input type="password" name="password_confirmation" required>
        <p><button class="btn">{{ __('ui.register') }}</button></p>
    </form>
</div>
@endsection

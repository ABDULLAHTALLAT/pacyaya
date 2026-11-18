@extends('layouts.app')
@section('title', __('ui.login'))
@section('content')
<div class="auth card">
    <h2>{{ __('ui.welcome_back') }}</h2>
    <form method="POST" action="{{ route('login') }}">@csrf
        <label>{{ __('ui.email') }}</label><input type="email" name="email" value="{{ old('email') }}" required>
        <label>{{ __('ui.password') }}</label><input type="password" name="password" required>
        <label><input type="checkbox" name="remember" value="1"> {{ __('ui.remember') }}</label>
        <p><button class="btn">{{ __('ui.login') }}</button></p>
    </form>
    <p>{{ __('ui.no_account') }} <a class="purple" href="{{ route('register') }}">{{ __('ui.create_one') }}</a></p>
</div>
@endsection

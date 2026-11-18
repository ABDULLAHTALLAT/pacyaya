@extends('layouts.app')
@section('title', __('ui.nav_tools'))
@section('content')
<section class="section"><div class="container">
    <h2 class="h-arrow">{{ __('ui.stunning_tools') }}</h2>
    <div class="grid c2">
        <a class="card" href="{{ route('templates.index') }}"><h3>{{ __('ui.tool1_title') }}</h3><p>{{ __('ui.tool1_text') }}</p></a>
        <a class="card" href="{{ route('tools.dieline') }}"><h3>{{ __('ui.tool2_title') }}</h3><p>{{ __('ui.tool2_text') }}</p></a>
        <a class="card" href="{{ route('designs.index') }}"><h3>{{ __('ui.tool3_title') }}</h3><p>{{ __('ui.tool3_text') }}</p></a>
        <a class="card" href="{{ route('printers.index') }}"><h3>{{ __('ui.tool4_title') }}</h3><p>{{ __('ui.tool4_text') }}</p></a>
    </div>
</div></section>
@endsection

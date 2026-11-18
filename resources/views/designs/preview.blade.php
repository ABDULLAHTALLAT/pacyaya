@extends('layouts.app')
@section('title', $design->name)
@section('content')
<div class="container" style="padding:24px 0">
    <h2 class="h-arrow">{{ $design->name }}</h2>
    <p class="sub">{{ $design->template->label }} · {{ $design->width }}×{{ $design->height }}×{{ $design->depth }} {{ __('ui.cm') }} · {{ $design->user->name }}</p>
    <div class="stage" id="stage" style="height:560px;border:1px solid var(--line)">
        <div class="toolbar"><button type="button" class="btn sm ghost" id="b-open">{{ __('ui.open_close') }}</button> <button type="button" class="btn sm" id="b-png">{{ __('ui.download_png') }}</button></div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('js/box3d.js') }}"></script>
<script src="{{ asset('js/patterns.js') }}"></script>
<script>
    var box = new Box3D(document.getElementById('stage'), {
        shape: @json($design->shape), w: {{ $design->width }}, h: {{ $design->height }}, d: {{ $design->depth }},
        color: @json($design->color), text: @json($design->text), textColor: @json($design->text_color),
        fontSize: {{ $design->font_size }},
        image: @json($design->image_url) || (@json($design->pattern) ? PacPatterns.url(@json($design->pattern)) : null)
    });
    document.getElementById('b-png').addEventListener('click', function () {
        var a = document.createElement('a');
        a.href = box.snapshot();
        a.download = 'pacyaya-mockup.png';
        a.click();
    });
    document.getElementById('b-open').addEventListener('click', function () { box.toggle(); });
</script>
@endpush

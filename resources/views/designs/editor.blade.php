@extends('layouts.editor')
@section('title', ($design->exists ? __('ui.ed_edit') : __('ui.ed_new')) . ' — Pacyaya')
@section('content')
<form method="POST" enctype="multipart/form-data" class="ped"
      action="{{ $design->exists ? route('designs.update', $design) : route('designs.store') }}">
    @csrf
    @if($design->exists) @method('PUT') @endif
    <input type="hidden" name="template_id" value="{{ $template->id }}">
    <input type="hidden" name="pattern" id="f-pattern" value="{{ old('pattern', $design->pattern) }}">

    <header class="ped-top">
        <a class="ped-logo" href="{{ route('home') }}"><i>P</i></a>
        <span class="ped-title">{{ __('ui.card_mockup') }}</span>
        <a class="ped-ico" href="{{ route('designs.index') }}" title="{{ __('ui.nav_designs') }}">☰</a>
        <input class="ed-name" type="text" name="name" value="{{ old('name', $design->name) }}" required>
        <span class="ed-spacer"></span>
        @if($design->exists)<a class="btn ghost sm" href="{{ route('orders.create', $design) }}">{{ __('ui.ed_order') }}</a>@endif
        <button type="button" class="ped-ico" id="b-share" title="{{ __('ui.mode_share') }}">⤴</button>
        <button class="btn ghost sm">{{ $design->exists ? __('ui.ed_save_changes') : __('ui.ed_save') }}</button>
        <button type="button" class="btn purple sm" id="b-png">{{ __('ui.ed_export') }}</button>
    </header>

    <div class="ped-work">
        <div class="stage" id="stage"></div>
        <div class="dlv" id="dl-view" hidden></div>

        <nav class="ped-rail">
            <button type="button" class="on" data-tab="edit"><span>✎</span>{{ __('ui.tab_edit') }}</button>
            <a href="{{ route('templates.index') }}"><span>📦</span>{{ __('ui.ed_models') }}</a>
            <hr>
            <button type="button" data-tab="size"><span>📐</span>{{ __('ui.tab_size') }}</button>
            <button type="button" data-tab="color"><span>🎨</span>{{ __('ui.tab_color') }}</button>
            <button type="button" data-tab="text"><span>🔤</span>{{ __('ui.tab_text') }}</button>
        </nav>

        <aside class="ped-panel">
            <div class="pane" data-pane="edit">
                <h4>{{ __('ui.ed_upload_images') }}</h4>
                <label class="drop" for="f-image">
                    <span class="drop-ico">🖼️</span>
                    <span class="btn purple sm">⬆ {{ __('ui.ed_upload_btn') }}</span>
                </label>
                <input type="file" name="image" id="f-image" accept="image/*" hidden>
                @if($design->image_path)<label class="chk"><input type="checkbox" name="remove_image" value="1"> {{ __('ui.remove_art') }}</label>@endif
                <p class="link-line"><a href="#" id="b-dl-dieline">{{ __('ui.ed_dl_dieline') }}</a></p>
                <h4 style="margin-top:14px">{{ __('ui.art_library') }}</h4>
                <div class="patterns" id="patterns"></div>
                <button type="button" class="cardrow" data-go="size"><small>{{ __('ui.ed_custom_size') }}</small><b id="size-badge"></b><i>{{ $arrow }}</i></button>
            </div>
            <div class="pane" data-pane="size" hidden>
                <h4>{{ __('ui.dims_title') }}</h4>
                <label>{{ __('ui.dl_length') }} ({{ __('ui.cm') }})</label><input type="number" step="0.5" name="width" id="f-w" value="{{ old('width', $design->width) }}">
                <label>{{ __('ui.dl_height') }} ({{ __('ui.cm') }})</label><input type="number" step="0.5" name="height" id="f-h" value="{{ old('height', $design->height) }}">
                <label>{{ __('ui.dl_width') }} ({{ __('ui.cm') }})</label><input type="number" step="0.5" name="depth" id="f-d" value="{{ old('depth', $design->depth) }}">
            </div>
            <div class="pane" data-pane="color" hidden>
                <h4>{{ __('ui.box_color') }}</h4>
                <input type="color" name="color" id="f-color" value="{{ old('color', $design->color) }}">
            </div>
            <div class="pane" data-pane="text" hidden>
                <h4>{{ __('ui.tab_text') }}</h4>
                <label>{{ __('ui.text') }}</label><input type="text" name="text" id="f-text" value="{{ old('text', $design->text) }}">
                <label>{{ __('ui.text_color') }}</label><input type="color" name="text_color" id="f-tcolor" value="{{ old('text_color', $design->text_color) }}">
                <label>{{ __('ui.font_size') }}</label><input type="number" name="font_size" id="f-size" value="{{ old('font_size', $design->font_size) }}">
            </div>
        </aside>

        <div class="ped-tools">
            <button type="button" id="t-spin" class="on" title="{{ __('ui.spin') }}">⟳</button>
            <button type="button" id="t-reset" title="{{ __('ui.ed_reset') }}">⌖</button>
            <button type="button" id="t-dieline" title="{{ __('ui.mode_dieline') }}">✂</button>
        </div>

        <div class="ped-bottom">
            <button type="button" id="z-out">−</button>
            <button type="button" id="z-in">+</button>
            <span class="sep"></span>
            <small>{{ __('ui.ed_open') }}</small>
            <input type="range" id="open-range" min="0" max="100" value="0">
            <small>{{ __('ui.ed_close') }}</small>
            <span class="sep"></span>
            <button type="button" data-view="front" title="Front">▣</button>
            <button type="button" data-view="top" title="Top">▤</button>
            <button type="button" data-view="side" title="Side">▥</button>
            <span class="sep"></span>
            <button type="button" id="t-png2" class="wm">⬇ PNG</button>
        </div>
    </div>
</form>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('js/box3d.js') }}"></script>
<script src="{{ asset('js/patterns.js') }}"></script>
<script src="{{ asset('js/dielines.js') }}"></script>
<script>
    var $ = function (id) { return document.getElementById(id); };
    var SHAPE = @json($template->shape);
    var SHARE = @json($design->exists ? route('designs.preview', $design->uuid) : null);
    var box = new Box3D($('stage'), {
        shape: SHAPE, w: parseFloat($('f-w').value), h: parseFloat($('f-h').value), d: parseFloat($('f-d').value),
        color: $('f-color').value, text: $('f-text').value, textColor: $('f-tcolor').value,
        fontSize: parseInt($('f-size').value, 10),
        image: @json($design->image_url) || (@json($design->pattern) ? PacPatterns.url(@json($design->pattern)) : null)
    });
    var dielineOn = false;

    function dims() {
        var w = parseFloat($('f-w').value) || 10, h = parseFloat($('f-h').value) || 10, d = parseFloat($('f-d').value) || 10;
        box.update({ w: w, h: h, d: d });
        $('size-badge').textContent = Math.round(w * 10) + ' × ' + Math.round(h * 10) + ' × ' + Math.round(d * 10) + ' mm';
        if (dielineOn) drawDieline();
    }
    function drawDieline() {
        if (SHAPE !== 'box') { $('dl-view').innerHTML = '<p style="padding:30px">{{ __('ui.dieline_na') }}</p>'; return; }
        var svg = PacDieline.build('tuck', $('f-w').value * 10, $('f-d').value * 10, $('f-h').value * 10, 0.5, false);
        $('dl-view').innerHTML = svg.replace(/ width="[^"]*mm" height="[^"]*mm"/, ' style="width:100%;height:100%"');
    }
    ['f-w', 'f-h', 'f-d'].forEach(function (i) { $(i).addEventListener('input', dims); });
    dims();
    $('f-color').addEventListener('input', function (e) { box.update({ color: e.target.value }); });
    $('f-text').addEventListener('input', function (e) { box.update({ text: e.target.value }); });
    $('f-tcolor').addEventListener('input', function (e) { box.update({ textColor: e.target.value }); });
    $('f-size').addEventListener('input', function (e) { box.update({ fontSize: parseInt(e.target.value, 10) || 48 }); });
    $('f-image').addEventListener('change', function (e) {
        var f = e.target.files[0];
        if (!f) return;
        var r = new FileReader();
        r.onload = function () { box.update({ image: r.result }); };
        r.readAsDataURL(f);
    });

    var pbox = $('patterns');
    PacPatterns.names.forEach(function (n) {
        var d = document.createElement('div');
        d.className = 'pat' + ($('f-pattern').value === n ? ' on' : '');
        d.style.backgroundColor = '#c4b5fd';
        d.style.backgroundImage = 'url("' + PacPatterns.url(n) + '")';
        d.addEventListener('click', function () {
            var on = $('f-pattern').value === n;
            $('f-pattern').value = on ? '' : n;
            Array.prototype.forEach.call(pbox.children, function (c) { c.classList.remove('on'); });
            if (!on) d.classList.add('on');
            $('f-image').value = '';
            box.update({ image: on ? null : PacPatterns.url(n) });
        });
        pbox.appendChild(d);
    });

    function openPane(name) {
        document.querySelectorAll('.ped-rail button').forEach(function (x) { x.classList.toggle('on', x.dataset.tab === name); });
        document.querySelectorAll('.pane').forEach(function (p) { p.hidden = p.dataset.pane !== name; });
    }
    document.querySelectorAll('.ped-rail button').forEach(function (b) { b.addEventListener('click', function () { openPane(b.dataset.tab); }); });
    document.querySelectorAll('[data-go]').forEach(function (b) { b.addEventListener('click', function () { openPane(b.dataset.go); }); });

    function png() {
        var a = document.createElement('a');
        a.href = box.snapshot();
        a.download = 'pacyaya-mockup.png';
        a.click();
    }
    $('b-png').addEventListener('click', png);
    $('t-png2').addEventListener('click', png);

    $('z-in').addEventListener('click', function () { box.zoom(0.15); });
    $('z-out').addEventListener('click', function () { box.zoom(-0.15); });
    $('open-range').addEventListener('input', function (e) { box.setOpen(e.target.value / 100); });
    document.querySelectorAll('[data-view]').forEach(function (b) { b.addEventListener('click', function () { box.view(b.dataset.view); $('t-spin').classList.remove('on'); }); });
    $('t-spin').addEventListener('click', function () { this.classList.toggle('on', box.spin()); });
    $('t-reset').addEventListener('click', function () { box.resetView(); $('t-spin').classList.add('on'); });
    $('t-dieline').addEventListener('click', function () {
        dielineOn = !dielineOn;
        this.classList.toggle('on', dielineOn);
        $('dl-view').hidden = !dielineOn;
        $('stage').style.visibility = dielineOn ? 'hidden' : 'visible';
        if (dielineOn) drawDieline();
    });
    $('b-dl-dieline').addEventListener('click', function (e) {
        e.preventDefault();
        if (SHAPE !== 'box') { alert(@json(__('ui.dieline_na'))); return; }
        var svg = PacDieline.build('tuck', $('f-w').value * 10, $('f-d').value * 10, $('f-h').value * 10, 0.5, false);
        var a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([svg], { type: 'image/svg+xml' }));
        a.download = 'pacyaya-dieline.svg';
        a.click();
    });
    $('b-share').addEventListener('click', function () {
        if (!SHARE) { alert(@json(__('ui.save_first_share'))); return; }
        if (navigator.clipboard) navigator.clipboard.writeText(SHARE);
        this.textContent = '✓';
    });
</script>
@endpush

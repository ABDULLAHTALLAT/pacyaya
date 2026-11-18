@extends('layouts.app')
@section('title', __('ui.dieline_maker'))
@section('content')
<div class="editor">
    <div class="card">
        <h3>{{ __('ui.dieline_maker') }}</h3>
        <label>{{ __('ui.dl_type') }}</label>
        <select id="dl-type">
            @foreach(['tuck','tray','lid','envelope'] as $ty)
                <option value="{{ $ty }}" @selected(request('type', 'tuck') === $ty)>{{ __('ui.dl_' . $ty) }}</option>
            @endforeach
        </select>
        <label>{{ __('ui.dl_length') }}</label><input type="number" id="dl-l" value="100">
        <label>{{ __('ui.dl_width') }}</label><input type="number" id="dl-w" value="60">
        <label>{{ __('ui.dl_height') }}</label><input type="number" id="dl-h" value="140">
        <label>{{ __('ui.dl_material') }}</label>
        <select id="dl-mat">
            <option value="0.3">{{ __('ui.mat_300') }}</option>
            <option value="0.45">{{ __('ui.mat_450') }}</option>
            <option value="1.5">{{ __('ui.mat_e') }}</option>
            <option value="3">{{ __('ui.mat_b') }}</option>
        </select>
        <p style="margin-top:16px"><button class="btn" id="dl-download" type="button">{{ __('ui.dl_download') }}</button>
        <button class="btn ghost" id="dl-print" type="button">{{ __('ui.dl_print') }}</button></p>
        <p class="sub" style="font-size:13px">{{ __('ui.dl_legend') }}</p>
    </div>
    <div class="stage" style="cursor:default;background:#fff;padding:20px;border:1px solid var(--line)" id="dl-stage"></div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('js/dielines.js') }}"></script>
<script>
(function () {
    var $ = function (id) { return document.getElementById(id); };
    var svgText = '';
    function build() {
        svgText = PacDieline.build($('dl-type').value, $('dl-l').value, $('dl-w').value, $('dl-h').value, $('dl-mat').value, false);
        $('dl-stage').innerHTML = svgText.replace(/ width="[^"]*mm" height="[^"]*mm"/, ' style="width:100%;height:100%"');
    }
    ['dl-type', 'dl-l', 'dl-w', 'dl-h', 'dl-mat'].forEach(function (id) { $(id).addEventListener('input', build); });
    $('dl-download').addEventListener('click', function () {
        var a = document.createElement('a');
        a.href = URL.createObjectURL(new Blob([svgText], { type: 'image/svg+xml' }));
        a.download = 'pacyaya-dieline-' + $('dl-type').value + '.svg';
        a.click();
    });
    $('dl-print').addEventListener('click', function () {
        var w = window.open('', '_blank');
        w.document.write('<html><body style="margin:0">' + svgText + '</body></html>');
        w.document.close();
        w.print();
    });
    build();
})();
</script>
@endpush

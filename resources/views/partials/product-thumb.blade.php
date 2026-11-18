@php
    $photo = null;
    if (!empty($slug) && !empty($kind)) {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            $rel = "images/{$kind}/{$slug}.{$ext}";
            if (file_exists(public_path($rel))) { $photo = $rel; break; }
        }
    }
@endphp
@if($photo)
<img src="{{ asset($photo) }}" alt="{{ $slug }}" loading="lazy" class="pimg">
@else
@php($c = $color ?? '#c4b5fd')
@php($s = $shape ?? 'box')
<svg viewBox="0 0 160 120" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="{{ $s }}">
    <ellipse cx="80" cy="108" rx="48" ry="7" fill="#3b3354" opacity=".12"/>
    @if($s === 'cylinder')
        <rect x="45" y="30" width="70" height="72" fill="{{ $c }}"/>
        <rect x="45" y="30" width="22" height="72" fill="#fff" opacity=".25"/>
        <rect x="95" y="30" width="20" height="72" fill="#000" opacity=".12"/>
        <ellipse cx="80" cy="102" rx="35" ry="9" fill="{{ $c }}"/>
        <ellipse cx="80" cy="102" rx="35" ry="9" fill="#000" opacity=".12"/>
        <ellipse cx="80" cy="30" rx="35" ry="9" fill="#e5e1f2"/>
        <ellipse cx="80" cy="30" rx="26" ry="5" fill="#fff" opacity=".6"/>
    @elseif($s === 'bottle')
        <rect x="54" y="52" width="52" height="52" rx="10" fill="{{ $c }}"/>
        <rect x="54" y="52" width="16" height="52" rx="8" fill="#fff" opacity=".28"/>
        <path d="M62 52 Q62 36 70 32 L90 32 Q98 36 98 52 Z" fill="{{ $c }}"/>
        <rect x="70" y="18" width="20" height="16" fill="{{ $c }}"/>
        <rect x="68" y="8" width="24" height="12" rx="3" fill="#d6d3e0"/>
        <rect x="64" y="70" width="32" height="18" rx="3" fill="#fff" opacity=".7"/>
    @else
        <polygon points="40,40 85,26 130,40 85,54" fill="#fff" opacity=".6"/>
        <polygon points="40,40 85,54 85,102 40,88" fill="{{ $c }}"/>
        <polygon points="85,54 130,40 130,88 85,102" fill="{{ $c }}"/>
        <polygon points="85,54 130,40 130,88 85,102" fill="#000" opacity=".14"/>
        <polygon points="40,40 85,26 130,40 85,54" fill="{{ $c }}" opacity=".5"/>
        <polygon points="52,60 74,67 74,86 52,79" fill="#fff" opacity=".35"/>
    @endif
</svg>
@endif

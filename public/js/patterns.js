(function (global) {
  var S = 512;
  function wrap(inner) {
    return '<svg xmlns="http://www.w3.org/2000/svg" width="' + S + '" height="' + S + '" viewBox="0 0 ' + S + ' ' + S + '">' + inner + '</svg>';
  }
  var W = 'rgba(255,255,255,.35)';
  var gens = {
    stripes: function () { var o = ''; for (var i = 0; i < 16; i++) o += '<rect x="' + (i * 32) + '" y="0" width="16" height="' + S + '" fill="' + W + '"/>'; return o; },
    dots: function () { var o = ''; for (var y = 0; y < 8; y++) for (var x = 0; x < 8; x++) o += '<circle cx="' + (x * 64 + 32) + '" cy="' + (y * 64 + 32) + '" r="12" fill="' + W + '"/>'; return o; },
    waves: function () { var o = ''; for (var y = 0; y < 8; y++) o += '<path d="M0 ' + (y * 64 + 32) + ' Q 64 ' + (y * 64) + ' 128 ' + (y * 64 + 32) + ' T 256 ' + (y * 64 + 32) + ' T 384 ' + (y * 64 + 32) + ' T 512 ' + (y * 64 + 32) + '" stroke="' + W + '" stroke-width="10" fill="none"/>'; return o; },
    grid: function () { var o = ''; for (var i = 0; i <= 8; i++) o += '<rect x="' + (i * 64 - 3) + '" y="0" width="6" height="' + S + '" fill="' + W + '"/><rect x="0" y="' + (i * 64 - 3) + '" width="' + S + '" height="6" fill="' + W + '"/>'; return o; },
    chevron: function () { var o = ''; for (var y = 0; y < 10; y++) o += '<polyline points="0,' + (y * 56 + 40) + ' 256,' + (y * 56) + ' 512,' + (y * 56 + 40) + '" stroke="' + W + '" stroke-width="14" fill="none"/>'; return o; },
    stars: function () { var o = ''; for (var y = 0; y < 5; y++) for (var x = 0; x < 5; x++) { var cx = x * 100 + 56 + (y % 2 ? 40 : 0), cy = y * 100 + 56; o += '<polygon fill="' + W + '" points="' + [0,1,2,3,4].map(function (k) { var a = -Math.PI / 2 + k * 4 * Math.PI / 5; return (cx + 28 * Math.cos(a)).toFixed(1) + ',' + (cy + 28 * Math.sin(a)).toFixed(1); }).join(' ') + '"/>'; } return o; }
  };
  global.PacPatterns = {
    names: Object.keys(gens),
    svg: function (name) { return gens[name] ? wrap(gens[name]()) : null; },
    url: function (name) { var s = this.svg(name); return s ? 'data:image/svg+xml;utf8,' + encodeURIComponent(s) : null; }
  };
})(window);

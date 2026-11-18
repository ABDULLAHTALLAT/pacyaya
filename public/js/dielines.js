(function (global) {
  function line(x1, y1, x2, y2) { return '<line x1="' + x1 + '" y1="' + y1 + '" x2="' + x2 + '" y2="' + y2 + '"/>'; }
  function poly(pts, closed) {
    return '<' + (closed ? 'polygon' : 'polyline') + ' fill="none" points="' + pts.map(function (p) { return p[0] + ',' + p[1]; }).join(' ') + '"/>';
  }
  function out(w, h, cut, fold, label, compact) {
    var sw = compact ? 1.6 : 0.6;
    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' + w + ' ' + h + '"' +
      (compact ? ' preserveAspectRatio="xMidYMid meet"' : ' width="' + w + 'mm" height="' + h + 'mm"') + '>' +
      '<g stroke="' + (compact ? '#b8b3cc' : '#e11d48') + '" stroke-width="' + sw + '" fill="none">' + cut + '</g>' +
      '<g stroke="' + (compact ? '#cfcbe0' : '#2563eb') + '" stroke-width="' + (sw * 0.8) + '" stroke-dasharray="4 3" fill="none">' + fold + '</g>' +
      (compact ? '' : '<text x="12" y="' + (h - 6) + '" font-size="7" fill="#8a82a3" font-family="Arial">' + label + '</text>') + '</svg>';
  }

  function tuck(L, W, H, t, compact) {
    var g = 15, tuckH = Math.max(12, W * 0.3), pad = 20, f = t;
    var xs = [g, g + L + f, g + L + W + 2 * f, g + 2 * L + W + 3 * f, g + 2 * L + 2 * W + 4 * f];
    var topY = pad + W + tuckH, botY = topY + H, cut = '', fold = '';
    var totalW = xs[4] + pad, totalH = botY + W + tuckH + pad;
    cut += poly([[xs[0], topY], [pad, topY + 10], [pad, botY - 10], [xs[0], botY]]);
    for (var i = 0; i < 4; i++) fold += line(xs[i], topY, xs[i], botY);
    cut += line(xs[4], topY, xs[4], botY);
    fold += line(xs[0], topY, xs[4], topY) + line(xs[0], botY, xs[4], botY);
    var lidTop = topY - W;
    cut += poly([[xs[2], topY], [xs[2], lidTop], [xs[3], lidTop], [xs[3], topY]]);
    fold += line(xs[2], lidTop, xs[3], lidTop);
    cut += poly([[xs[2] + 4, lidTop], [xs[2] + 8, lidTop - tuckH], [xs[3] - 8, lidTop - tuckH], [xs[3] - 4, lidTop]]);
    [[xs[1], xs[2]], [xs[3], xs[4]]].forEach(function (p) {
      cut += poly([[p[0], topY], [p[0] + 4, topY - W * 0.7], [p[1] - 4, topY - W * 0.7], [p[1], topY]]);
      cut += poly([[p[0], botY], [p[0] + 4, botY + W * 0.7], [p[1] - 4, botY + W * 0.7], [p[1], botY]]);
    });
    var lidBot = botY + W;
    cut += poly([[xs[0], botY], [xs[0], lidBot], [xs[1], lidBot], [xs[1], botY]]);
    fold += line(xs[0], lidBot, xs[1], lidBot);
    cut += poly([[xs[0] + 4, lidBot], [xs[0] + 8, lidBot + tuckH], [xs[1] - 8, lidBot + tuckH], [xs[1] - 4, lidBot]]);
    cut += line(xs[2], botY, xs[3], botY);
    return { w: totalW, h: totalH, cut: cut, fold: fold };
  }

  function trayParts(L, W, H, ox, oy) {
    var x0 = ox + H, y0 = oy + H, cut = '', fold = '';
    cut += poly([[x0, oy], [x0 + L, oy], [x0 + L, y0], [x0 + L + H, y0], [x0 + L + H, y0 + W], [x0 + L, y0 + W],
      [x0 + L, y0 + W + H], [x0, y0 + W + H], [x0, y0 + W], [ox, y0 + W], [ox, y0], [x0, y0]], true);
    fold += line(x0, y0, x0 + L, y0) + line(x0 + L, y0, x0 + L, y0 + W) + line(x0 + L, y0 + W, x0, y0 + W) + line(x0, y0 + W, x0, y0);
    return { cut: cut, fold: fold, w: L + 2 * H, h: W + 2 * H };
  }

  function tray(L, W, H) {
    var p = trayParts(L, W, H, 20, 20);
    return { w: p.w + 40, h: p.h + 40, cut: p.cut, fold: p.fold };
  }

  function lid(L, W, H) {
    var lh = Math.max(10, H * 0.4);
    var a = trayParts(L, W, H, 20, 20);
    var b = trayParts(L + 2, W + 2, lh, 20 + a.w + 20, 20);
    return { w: a.w + b.w + 60, h: Math.max(a.h, b.h) + 40, cut: a.cut + b.cut, fold: a.fold + b.fold };
  }

  function envelope(L, W) {
    var x0 = 20 + L * 0.3, topF = W * 0.45, y0 = 20 + topF, sw = L * 0.3, bf = W * 0.45;
    var cut = poly([[x0, y0], [x0 + L / 2, y0 - topF], [x0 + L, y0], [x0 + L, y0 + W * 0.1], [x0 + L + sw, y0 + W * 0.35],
      [x0 + L + sw, y0 + W * 0.65], [x0 + L, y0 + W * 0.9], [x0 + L, y0 + W], [x0 + L * 0.8, y0 + W + bf], [x0 + L * 0.2, y0 + W + bf],
      [x0, y0 + W], [x0, y0 + W * 0.9], [x0 - sw, y0 + W * 0.65], [x0 - sw, y0 + W * 0.35], [x0, y0 + W * 0.1]], true);
    var fold = line(x0, y0, x0 + L, y0) + line(x0 + L, y0, x0 + L, y0 + W) + line(x0 + L, y0 + W, x0, y0 + W) + line(x0, y0 + W, x0, y0);
    return { w: x0 + L + sw + 20, h: y0 + W + bf + 20, cut: cut, fold: fold };
  }

  global.PacDieline = {
    types: ['tuck', 'tray', 'lid', 'envelope'],
    build: function (type, L, W, H, t, compact, label) {
      L = +L || 50; W = +W || 30; H = +H || 50; t = +t || 0.5;
      var r = type === 'tray' ? tray(L, W, H) : type === 'lid' ? lid(L, W, H) : type === 'envelope' ? envelope(L, W) : tuck(L, W, H, t, compact);
      return out(Math.round(r.w), Math.round(r.h), r.cut, r.fold, label || (L + ' x ' + W + ' x ' + H + ' mm'), compact);
    }
  };
})(window);

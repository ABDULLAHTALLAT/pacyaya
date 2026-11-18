(function () {
  var eyes = Array.prototype.slice.call(document.querySelectorAll('.eyes .eye'));
  if (!eyes.length) return;

  function look(x, y) {
    eyes.forEach(function (eye) {
      var shape = eye.querySelector('ellipse');
      var pupil = eye.querySelector('.pupil');
      var r = shape.getBoundingClientRect();
      var cx = r.left + r.width / 2, cy = r.top + r.height / 2;
      var dx = x - cx, dy = y - cy;
      var dist = Math.sqrt(dx * dx + dy * dy) || 1;
      var k = Math.min(1, dist / 160);
      var ox = (dx / dist) * 6.5 * k;
      var oy = (dy / dist) * 9 * k;
      pupil.setAttribute('transform', 'translate(' + ox.toFixed(2) + ' ' + oy.toFixed(2) + ')');
    });
  }

  document.addEventListener('mousemove', function (e) { look(e.clientX, e.clientY); });
  document.addEventListener('touchmove', function (e) {
    if (e.touches[0]) look(e.touches[0].clientX, e.touches[0].clientY);
  }, { passive: true });
})();

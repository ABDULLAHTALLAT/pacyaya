(function (global) {
  function Box3D(container, opts) {
    var self = this;
    var state = Object.assign({ shape: 'box', w: 20, h: 10, d: 14, color: '#c4b5fd', text: '', textColor: '#ffffff', fontSize: 64, image: null }, opts || {});
    var width = container.clientWidth, height = container.clientHeight;

    var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 500);
    var renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, preserveDrawingBuffer: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.setSize(width, height);
    container.appendChild(renderer.domElement);

    scene.add(new THREE.AmbientLight(0xffffff, 0.75));
    var sun = new THREE.DirectionalLight(0xffffff, 0.6);
    sun.position.set(10, 20, 15);
    scene.add(sun);

    var canvas = document.createElement('canvas');
    canvas.width = canvas.height = 1024;
    var texture = new THREE.CanvasTexture(canvas);
    var imageEl = null;

    var root = new THREE.Group();
    scene.add(root);
    var lidPivot = null, lidMode = 'hinge', lidBase = 0;
    var openAmt = 0, lidAngle = 0, autoRotate = true;
    var rotX = 0.35, rotY = -0.6, zoom = 1;

    function paint() {
      var c = canvas.getContext('2d');
      c.fillStyle = state.color;
      c.fillRect(0, 0, 1024, 1024);
      if (imageEl) {
        var r = Math.max(1024 / imageEl.width, 1024 / imageEl.height);
        var iw = imageEl.width * r, ih = imageEl.height * r;
        c.drawImage(imageEl, (1024 - iw) / 2, (1024 - ih) / 2, iw, ih);
      }
      if (state.text) {
        c.fillStyle = state.textColor;
        c.font = '700 ' + (state.fontSize * 2) + 'px Inter, Arial, sans-serif';
        c.textAlign = 'center';
        c.textBaseline = 'middle';
        c.fillText(state.text, 512, 512, 940);
      }
      texture.needsUpdate = true;
    }

    function build() {
      while (root.children.length) {
        var o = root.children[0];
        root.remove(o);
        if (o.geometry) o.geometry.dispose();
      }
      var k = 0.1, w = state.w * k, h = state.h * k, d = state.d * k, t = 0.02;
      var outer = new THREE.MeshStandardMaterial({ map: texture, roughness: 0.6, side: THREE.DoubleSide });
      var inner = new THREE.MeshStandardMaterial({ color: 0xf5f3ff, roughness: 0.9, side: THREE.DoubleSide });
      var metal = new THREE.MeshStandardMaterial({ color: 0xd6d3e0, roughness: 0.3, metalness: 0.6 });
      var none = new THREE.MeshBasicMaterial({ visible: false });
      lidMode = state.shape === 'box' ? 'hinge' : 'lift';
      lidPivot = new THREE.Group();

      if (state.shape === 'box') {
        var body = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), [outer, outer, none, outer, outer, outer]);
        body.position.y = h / 2;
        root.add(body);
        var floor = new THREE.Mesh(new THREE.PlaneGeometry(w - t * 2, d - t * 2), inner);
        floor.rotation.x = -Math.PI / 2;
        floor.position.y = t * 2;
        root.add(floor);
        lidPivot.position.set(0, h, -d / 2);
        var lid = new THREE.Mesh(new THREE.BoxGeometry(w, t * 2, d), [outer, outer, outer, inner, outer, outer]);
        lid.position.set(0, t, d / 2);
        lidPivot.add(lid);
        lidBase = h;
      } else if (state.shape === 'cylinder') {
        var r = w / 2;
        var cb = new THREE.Mesh(new THREE.CylinderGeometry(r, r, h, 64, 1, false), [outer, metal, metal]);
        cb.position.y = h / 2;
        root.add(cb);
        var cap = new THREE.Mesh(new THREE.CylinderGeometry(r * 1.02, r * 1.02, h * 0.08, 64), [outer, metal, metal]);
        cap.position.y = h * 0.04;
        lidPivot.add(cap);
        lidPivot.position.set(0, h, 0);
        lidBase = h;
      } else {
        var br = w / 2, bh = h * 0.68;
        var bb = new THREE.Mesh(new THREE.CylinderGeometry(br, br, bh, 64), [outer, outer, outer]);
        bb.position.y = bh / 2;
        root.add(bb);
        var sh = new THREE.Mesh(new THREE.CylinderGeometry(br * 0.34, br, h * 0.14, 64), [outer, outer, outer]);
        sh.position.y = bh + h * 0.07;
        root.add(sh);
        var nk = new THREE.Mesh(new THREE.CylinderGeometry(br * 0.34, br * 0.34, h * 0.08, 32), [outer, outer, outer]);
        nk.position.y = bh + h * 0.14 + h * 0.04;
        root.add(nk);
        var bc = new THREE.Mesh(new THREE.CylinderGeometry(br * 0.4, br * 0.4, h * 0.1, 32), [metal, metal, metal]);
        bc.position.y = h * 0.05;
        lidPivot.add(bc);
        lidPivot.position.set(0, h * 0.9, 0);
        lidBase = h * 0.9;
      }
      root.add(lidPivot);

      var sc = document.createElement('canvas');
      sc.width = sc.height = 128;
      var sx = sc.getContext('2d');
      var gr = sx.createRadialGradient(64, 64, 4, 64, 64, 62);
      gr.addColorStop(0, 'rgba(40,30,80,0.32)');
      gr.addColorStop(1, 'rgba(40,30,80,0)');
      sx.fillStyle = gr;
      sx.fillRect(0, 0, 128, 128);
      var sm = new THREE.Mesh(new THREE.PlaneGeometry(Math.max(w, d) * 2.2, Math.max(w, d) * 2.2),
        new THREE.MeshBasicMaterial({ map: new THREE.CanvasTexture(sc), transparent: true, depthWrite: false }));
      sm.rotation.x = -Math.PI / 2;
      sm.position.y = 0.002;
      root.add(sm);

      var size = Math.max(w, h, d);
      camera.position.set(0, size * 0.9, size * 3.2);
      camera.lookAt(0, h / 2, 0);
      root.userData.center = h / 2;
    }

    function resize() {
      var w = container.clientWidth, h = container.clientHeight;
      renderer.setSize(w, h);
      camera.aspect = w / h;
      camera.updateProjectionMatrix();
    }
    window.addEventListener('resize', resize);

    var dragging = false, lx = 0, ly = 0;
    var el = renderer.domElement;
    el.addEventListener('pointerdown', function (e) { dragging = true; autoRotate = false; lx = e.clientX; ly = e.clientY; el.setPointerCapture(e.pointerId); });
    el.addEventListener('pointerup', function () { dragging = false; });
    el.addEventListener('pointermove', function (e) {
      if (!dragging) return;
      rotY += (e.clientX - lx) * 0.01;
      rotX = Math.max(-1.2, Math.min(1.2, rotX + (e.clientY - ly) * 0.01));
      lx = e.clientX; ly = e.clientY;
    });
    el.addEventListener('wheel', function (e) { e.preventDefault(); zoom = Math.max(0.5, Math.min(2, zoom + e.deltaY * 0.001)); }, { passive: false });

    function tick() {
      requestAnimationFrame(tick);
      if (autoRotate) rotY += 0.006;
      var target = -Math.PI * 0.62 * openAmt;
      lidAngle += (target - lidAngle) * 0.08;
      if (lidPivot) {
        if (lidMode === 'hinge') lidPivot.rotation.x = lidAngle;
        else lidPivot.position.y = lidBase - lidAngle * 0.35;
      }
      root.rotation.y = rotY;
      root.rotation.x = rotX * 0.5;
      root.position.y = Math.sin(Date.now() / 900) * 0.05 - (root.userData.center || 0) * 0.5;
      camera.zoom = 1 / zoom;
      camera.updateProjectionMatrix();
      renderer.render(scene, camera);
    }

    self.update = function (patch) {
      Object.assign(state, patch);
      if ('image' in patch) {
        if (!patch.image) { imageEl = null; paint(); }
        else {
          var img = new Image();
          img.crossOrigin = 'anonymous';
          img.onload = function () { imageEl = img; paint(); };
          img.src = patch.image;
        }
      }
      paint();
      if ('w' in patch || 'h' in patch || 'd' in patch || 'shape' in patch) build();
    };
    self.snapshot = function () { renderer.render(scene, camera); return renderer.domElement.toDataURL('image/png'); };
    self.toggle = function () { openAmt = openAmt > 0.5 ? 0 : 1; return openAmt; };
    self.setOpen = function (v) { openAmt = Math.max(0, Math.min(1, v)); };
    self.zoom = function (d) { zoom = Math.max(0.5, Math.min(2.5, zoom - d)); };
    self.view = function (name) {
      autoRotate = false;
      if (name === 'front') { rotY = 0; rotX = 0; }
      else if (name === 'top') { rotY = 0; rotX = 1.2; }
      else if (name === 'side') { rotY = Math.PI / 2; rotX = 0; }
    };
    self.resetView = function () { rotX = 0.35; rotY = -0.6; zoom = 1; autoRotate = true; };
    self.spin = function () { autoRotate = !autoRotate; return autoRotate; };

    paint();
    build();
    if (state.image) self.update({ image: state.image });
    tick();
  }
  global.Box3D = Box3D;
})(window);

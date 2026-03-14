/**
 * Animated Shader Hero - Vanilla JS WebGL background
 * Ported from React component for PHP/vanilla stack
 * Supports WebGL2 with WebGL1 fallback for Safari and older browsers
 */
(function () {
  'use strict';

  // WebGL2 shader (uses out vec4)
  const shaderSourceWebGL2 = `#version 300 es
precision highp float;
out vec4 O;
uniform vec2 resolution;
uniform float time;
#define FC gl_FragCoord.xy
#define T time
#define R resolution
#define MN min(R.x,R.y)
float rnd(vec2 p) {
  p=fract(p*vec2(12.9898,78.233));
  p+=dot(p,p+34.56);
  return fract(p.x*p.y);
}
float noise(in vec2 p) {
  vec2 i=floor(p), f=fract(p), u=f*f*(3.-2.*f);
  float a=rnd(i), b=rnd(i+vec2(1,0)), c=rnd(i+vec2(0,1)), d=rnd(i+1.);
  return mix(mix(a,b,u.x),mix(c,d,u.x),u.y);
}
float fbm(vec2 p) {
  float t=.0, a=1.; mat2 m=mat2(1.,-.5,.2,1.2);
  for (int i=0; i<5; i++) {
    t+=a*noise(p);
    p*=2.*m;
    a*=.5;
  }
  return t;
}
float clouds(vec2 p) {
  float d=1., t=.0;
  for (float i=.0; i<3.; i++) {
    float a=d*fbm(i*10.+p.x*.2+.2*(1.+i)*p.y+d+i*i+p);
    t=mix(t,d,a);
    d=a;
    p*=2./(i+1.);
  }
  return t;
}
void main(void) {
  vec2 uv=(FC-.5*R)/MN,st=uv*vec2(2,1);
  vec3 col=vec3(0);
  float bg=clouds(vec2(st.x+T*.5,-st.y));
  uv*=1.-.3*(sin(T*.2)*.5+.5);
  for (float i=1.; i<12.; i++) {
    uv+=.1*cos(i*vec2(.1+.01*i, .8)+i*i+T*.5+.1*uv.x);
    vec2 p=uv;
    float d=length(p);
    col+=.00125/d*(cos(sin(i)*vec3(1,2,3))+1.);
    float b=noise(i+p+bg*1.731);
    col+=.002*b/length(max(p,vec2(b*p.x*.02,p.y)));
    col=mix(col,vec3(bg*.25,bg*.137,bg*.05),d);
  }
  O=vec4(col,1);
}`;

  // WebGL1 shader (uses gl_FragColor) - Safari/older browser fallback
  const shaderSourceWebGL1 = `precision highp float;
uniform vec2 resolution;
uniform float time;
#define FC gl_FragCoord.xy
#define T time
#define R resolution
#define MN min(R.x,R.y)
float rnd(vec2 p) {
  p=fract(p*vec2(12.9898,78.233));
  p+=dot(p,p+34.56);
  return fract(p.x*p.y);
}
float noise(in vec2 p) {
  vec2 i=floor(p), f=fract(p), u=f*f*(3.-2.*f);
  float a=rnd(i), b=rnd(i+vec2(1,0)), c=rnd(i+vec2(0,1)), d=rnd(i+1.);
  return mix(mix(a,b,u.x),mix(c,d,u.x),u.y);
}
float fbm(vec2 p) {
  float t=.0, a=1.; mat2 m=mat2(1.,-.5,.2,1.2);
  for (int i=0; i<5; i++) {
    t+=a*noise(p);
    p*=2.*m;
    a*=.5;
  }
  return t;
}
float clouds(vec2 p) {
  float d=1., t=.0;
  for (float i=.0; i<3.; i++) {
    float a=d*fbm(i*10.+p.x*.2+.2*(1.+i)*p.y+d+i*i+p);
    t=mix(t,d,a);
    d=a;
    p*=2./(i+1.);
  }
  return t;
}
void main(void) {
  vec2 uv=(FC-.5*R)/MN,st=uv*vec2(2,1);
  vec3 col=vec3(0);
  float bg=clouds(vec2(st.x+T*.5,-st.y));
  uv*=1.-.3*(sin(T*.2)*.5+.5);
  for (float i=1.; i<12.; i++) {
    uv+=.1*cos(i*vec2(.1+.01*i, .8)+i*i+T*.5+.1*uv.x);
    vec2 p=uv;
    float d=length(p);
    col+=.00125/d*(cos(sin(i)*vec3(1,2,3))+1.);
    float b=noise(i+p+bg*1.731);
    col+=.002*b/length(max(p,vec2(b*p.x*.02,p.y)));
    col=mix(col,vec3(bg*.25,bg*.137,bg*.05),d);
  }
  gl_FragColor=vec4(col,1);
}`;

  const vertexSrcWebGL2 = `#version 300 es
precision highp float;
in vec4 position;
void main(){gl_Position=position;}`;
  const vertexSrcWebGL1 = `attribute vec4 position;
void main(){gl_Position=position;}`;

  class WebGLRenderer {
    constructor(canvas, scale) {
      this.canvas = canvas;
      this.scale = scale;
      const opts = { alpha: false, antialias: false, powerPreference: 'high-performance' };
      this.gl = canvas.getContext('webgl2', opts) || canvas.getContext('webgl', opts);
      this.isWebGL2 = !!(canvas.getContext('webgl2', opts));
      if (!this.gl) return;
      this.gl.viewport(0, 0, canvas.width * scale, canvas.height * scale);
      this.program = null;
      this.vs = null;
      this.fs = null;
      this.buffer = null;
      this.mouseMove = [0, 0];
      this.mouseCoords = [0, 0];
      this.pointerCoords = [0, 0];
      this.nbrOfPointers = 0;
      this.vertices = [-1, 1, -1, -1, 1, 1, 1, -1];
    }

    setup() {
      const gl = this.gl;
      if (!gl) return;
      const vertexSrc = this.isWebGL2 ? vertexSrcWebGL2 : vertexSrcWebGL1;
      const fragmentSrc = this.isWebGL2 ? shaderSourceWebGL2 : shaderSourceWebGL1;
      this.vs = gl.createShader(gl.VERTEX_SHADER);
      this.fs = gl.createShader(gl.FRAGMENT_SHADER);
      gl.shaderSource(this.vs, vertexSrc);
      gl.compileShader(this.vs);
      gl.shaderSource(this.fs, fragmentSrc);
      gl.compileShader(this.fs);
      this.program = gl.createProgram();
      gl.attachShader(this.program, this.vs);
      gl.attachShader(this.program, this.fs);
      gl.linkProgram(this.program);
      if (!gl.getProgramParameter(this.program, gl.LINK_STATUS)) {
        console.error(gl.getProgramInfoLog(this.program));
      }
    }

    init() {
      const gl = this.gl;
      if (!gl || !this.program) return;
      this.buffer = gl.createBuffer();
      gl.bindBuffer(gl.ARRAY_BUFFER, this.buffer);
      gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(this.vertices), gl.STATIC_DRAW);
      const position = gl.getAttribLocation(this.program, 'position');
      gl.enableVertexAttribArray(position);
      gl.vertexAttribPointer(position, 2, gl.FLOAT, false, 0, 0);
      this.uResolution = gl.getUniformLocation(this.program, 'resolution');
      this.uTime = gl.getUniformLocation(this.program, 'time');
      this.uMove = gl.getUniformLocation(this.program, 'move');
      this.uTouch = gl.getUniformLocation(this.program, 'touch');
      this.uPointerCount = gl.getUniformLocation(this.program, 'pointerCount');
      this.uPointers = gl.getUniformLocation(this.program, 'pointers');
    }

    updateMouse(coords) { this.mouseCoords = coords; }
    updatePointerCoords(coords) { this.pointerCoords = coords; }
    updatePointerCount(n) { this.nbrOfPointers = n; }
    updateMove(deltas) { this.mouseMove = deltas; }
    updateScale(scale) {
      this.scale = scale;
      if (this.gl) this.gl.viewport(0, 0, this.canvas.width * scale, this.canvas.height * scale);
    }

    render(now) {
      const gl = this.gl;
      if (!gl || !this.program || gl.getProgramParameter(this.program, gl.DELETE_STATUS)) return;
      gl.clearColor(0, 0, 0, 1);
      gl.clear(gl.COLOR_BUFFER_BIT);
      gl.useProgram(this.program);
      gl.bindBuffer(gl.ARRAY_BUFFER, this.buffer);
      gl.uniform2f(this.uResolution, this.canvas.width, this.canvas.height);
      gl.uniform1f(this.uTime, now * 1e-3);
      if (this.uMove) gl.uniform2f(this.uMove, this.mouseMove[0], this.mouseMove[1]);
      if (this.uTouch) gl.uniform2f(this.uTouch, this.mouseCoords[0], this.mouseCoords[1]);
      if (this.uPointerCount) gl.uniform1i(this.uPointerCount, this.nbrOfPointers);
      if (this.uPointers) gl.uniform2fv(this.uPointers, this.pointerCoords);
      gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
    }

    reset() {
      const gl = this.gl;
      if (!gl || !this.program) return;
      if (this.vs) { gl.detachShader(this.program, this.vs); gl.deleteShader(this.vs); }
      if (this.fs) { gl.detachShader(this.program, this.fs); gl.deleteShader(this.fs); }
      gl.deleteProgram(this.program);
    }
  }

  class PointerHandler {
    constructor(element, scale) {
      this.scale = scale;
      this.pointers = new Map();
      this.lastCoords = [0, 0];
      this.moves = [0, 0];
      const map = (el, s, x, y) => [x * s, el.height - y * s];

      element.addEventListener('pointerdown', (e) => {
        this.pointers.set(e.pointerId, map(element, this.scale, e.clientX, e.clientY));
      });
      element.addEventListener('pointerup', (e) => {
        if (this.pointers.size === 1) this.lastCoords = Array.from(this.pointers.values())[0];
        this.pointers.delete(e.pointerId);
      });
      element.addEventListener('pointerleave', (e) => {
        if (this.pointers.size === 1) this.lastCoords = Array.from(this.pointers.values())[0];
        this.pointers.delete(e.pointerId);
      });
      element.addEventListener('pointermove', (e) => {
        this.lastCoords = [e.clientX, e.clientY];
        this.pointers.set(e.pointerId, map(element, this.scale, e.clientX, e.clientY));
        this.moves = [this.moves[0] + e.movementX, this.moves[1] + e.movementY];
      });
    }
    get count() { return this.pointers.size; }
    get move() { return this.moves; }
    get coords() {
      const vals = Array.from(this.pointers.values());
      return vals.length > 0 ? vals.flat() : [0, 0];
    }
    get first() {
      const vals = Array.from(this.pointers.values());
      return vals.length > 0 ? vals[0] : this.lastCoords;
    }
  }

  function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  }

  function initHeroShader() {
    const container = document.getElementById('hero-shader-section');
    if (!container) return;
    const canvas = container.querySelector('.hero-shader-canvas');
    if (!canvas) return;

    if (prefersReducedMotion()) {
      canvas.style.backgroundColor = '#000';
      return;
    }

    const dpr = Math.max(1, 0.5 * window.devicePixelRatio);
    const renderer = new WebGLRenderer(canvas, dpr);
    if (!renderer.gl) {
      canvas.style.display = 'none';
      return;
    }
    const pointers = new PointerHandler(canvas, dpr);
    renderer.setup();
    renderer.init();

    function resize() {
      canvas.width = window.innerWidth * dpr;
      canvas.height = window.innerHeight * dpr;
      renderer.updateScale(dpr);
    }
    resize();

    let rafId;
    function loop(now) {
      renderer.updateMouse(pointers.first);
      renderer.updatePointerCount(pointers.count);
      renderer.updatePointerCoords(pointers.coords);
      renderer.updateMove(pointers.move);
      renderer.render(now);
      rafId = requestAnimationFrame(loop);
    }
    loop(0);

    window.addEventListener('resize', resize);
    return () => {
      window.removeEventListener('resize', resize);
      if (rafId) cancelAnimationFrame(rafId);
      renderer.reset();
    };
  }

  function runInit() {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function onReady() {
        requestAnimationFrame(initHeroShader);
      });
    } else {
      requestAnimationFrame(initHeroShader);
    }
  }
  runInit();
})();

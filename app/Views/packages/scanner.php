<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>

<style>
/* ══════════════════════════════════
   PÁGINA PRINCIPAL
══════════════════════════════════ */
.scn-page { padding: 24px 20px; }

.scn-hero {
    background: linear-gradient(135deg, #0e1525 0%, #1d2744 100%);
    border-radius: 20px;
    padding: 36px 32px;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
    margin-bottom: 28px;
}
.scn-hero-text h3 { font-size: 1.5rem; font-weight: 800; margin: 0 0 6px; }
.scn-hero-text p  { margin: 0; opacity: .6; font-size: .9rem; }

.btn-abrir-scanner {
    background: #00e676;
    color: #0e1525;
    border: none;
    border-radius: 14px;
    padding: 14px 28px;
    font-size: 1rem;
    font-weight: 800;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: transform .15s, box-shadow .15s;
    box-shadow: 0 4px 18px rgba(0,230,118,.4);
    flex-shrink: 0;
    white-space: nowrap;
}
.btn-abrir-scanner:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(0,230,118,.55);
}
.btn-abrir-scanner i { font-size: 1.2rem; }

#pnl-placeholder {
    background: #fff;
    border: 2px dashed #dde2ec;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    min-height: 280px;
    color: #ced4da;
    text-align: center;
    padding: 40px 20px;
}
#pnl-placeholder i { font-size: 4rem; opacity: .3; }
#pnl-placeholder p  { margin: 0; font-size: .95rem; color: #adb5bd; }

#pnl-loading {
    display: none;
    min-height: 280px;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 14px;
}
#pnl-error {
    display: none;
    min-height: 180px;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 12px;
    color: #dc3545;
    text-align: center;
}
#pnl-error i { font-size: 3rem; }
#pnl-result  { display: none; }

/* ══════════════════════════════════
   OVERLAY CÁMARA (fullscreen)
══════════════════════════════════ */
#cam-overlay {
    position: fixed;
    inset: 0;
    z-index: 1050;
    background: #000;
    display: none;
    flex-direction: column;
}
#cam-overlay.show { display: flex; }

#cam-feed {
    position: absolute;
    inset: 0;
}
#cam-feed video,
#cam-feed > div > video {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    display: block !important;
}
#cam-feed > div > select,
#cam-feed > div > button,
#cam-feed > div > br { display: none !important; }
#cam-feed > div { width: 100% !important; height: 100% !important; }

#cam-topbar {
    position: absolute;
    top: 0; left: 0; right: 0;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    background: linear-gradient(to bottom, rgba(0,0,0,.72), transparent);
}
.cam-title { color: #fff; font-weight: 700; font-size: 1rem; }
#btn-cerrar-cam {
    background: rgba(255,255,255,.15);
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 42px; height: 42px;
    font-size: 20px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    backdrop-filter: blur(4px);
    transition: background .15s;
}
#btn-cerrar-cam:hover { background: rgba(255,255,255,.28); }

#qr-frame {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -55%);
    width: min(72vw, 300px);
    height: min(72vw, 300px);
    box-shadow: 0 0 0 9999px rgba(0,0,0,.55);
    border-radius: 4px;
    pointer-events: none;
    z-index: 5;
}
.qc {
    position: absolute;
    width: 32px; height: 32px;
    border: 3.5px solid #fff;
    transition: border-color .12s, box-shadow .12s;
}
.qc.tl { top:-1px;    left:-1px;    border-right:none; border-bottom:none; border-radius:7px 0 0 0; }
.qc.tr { top:-1px;    right:-1px;   border-left:none;  border-bottom:none; border-radius:0 7px 0 0; }
.qc.bl { bottom:-1px; left:-1px;    border-right:none; border-top:none;    border-radius:0 0 0 7px; }
.qc.br { bottom:-1px; right:-1px;   border-left:none;  border-top:none;    border-radius:0 0 7px 0; }

@keyframes cornerPulse {
    0%, 100% { opacity: .6; }
    50%       { opacity: 1; box-shadow: 0 0 8px rgba(255,255,255,.5); }
}
.qc { animation: cornerPulse 2s ease-in-out infinite; }
.qc.tl { animation-delay: 0s;   }
.qc.tr { animation-delay: .5s;  }
.qc.bl { animation-delay: 1s;   }
.qc.br { animation-delay: 1.5s; }
#qr-frame.ok .qc {
    border-color: #00e676;
    box-shadow: 0 0 10px rgba(0,230,118,.8);
    animation: none; opacity: 1;
}

#truck-road {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 36px;
    background: linear-gradient(to top, rgba(0,0,0,.6), transparent);
    border-radius: 0 0 4px 4px;
    overflow: hidden;
}
#truck-road::after {
    content: '';
    position: absolute;
    bottom: 9px; left: 0; right: 0;
    height: 2px;
    background: repeating-linear-gradient(
        90deg,
        rgba(255,255,255,.28) 0, rgba(255,255,255,.28) 14px,
        transparent 14px, transparent 26px
    );
    animation: roadScroll 1.1s linear infinite;
}
@keyframes roadScroll { to { background-position-x: 40px; } }
#scan-truck {
    position: absolute;
    bottom: 8px;
    font-size: 22px;
    line-height: 1;
    filter: drop-shadow(0 2px 6px rgba(0,0,0,.7));
    animation: truckDrive 3.6s linear infinite;
}
@keyframes truckDrive {
    0%   { left: 4px;               transform: scaleX(1);  }
    45%  { left: calc(100% - 32px); transform: scaleX(1);  }
    50%  { left: calc(100% - 32px); transform: scaleX(-1); }
    95%  { left: 4px;               transform: scaleX(-1); }
    100% { left: 4px;               transform: scaleX(1);  }
}

#cam-bottom {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    z-index: 10;
    padding: 16px 18px 28px;
    background: linear-gradient(to top, rgba(0,0,0,.78) 60%, transparent);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
.cam-hint { color: rgba(255,255,255,.55); font-size: .82rem; }
.manual-row { display: flex; gap: 8px; width: 100%; max-width: 380px; }
.manual-row input {
    flex: 1; background: rgba(255,255,255,.1); color: #fff;
    border: 1.5px solid rgba(255,255,255,.22); border-radius: 10px;
    padding: 9px 14px; font-size: .87rem; text-transform: uppercase;
    letter-spacing: .05em; outline: none;
    transition: border-color .2s, background .2s;
}
.manual-row input::placeholder { color: rgba(255,255,255,.35); }
.manual-row input:focus { border-color: rgba(255,255,255,.5); background: rgba(255,255,255,.16); }
.manual-row button {
    background: rgba(255,255,255,.18); color: #fff;
    border: 1.5px solid rgba(255,255,255,.25); border-radius: 10px;
    padding: 9px 18px; cursor: pointer; transition: background .15s;
}
.manual-row button:hover { background: rgba(255,255,255,.28); }

#cam-placeholder {
    position: absolute; inset: 0; z-index: 3;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 14px; color: rgba(255,255,255,.6);
    font-size: .9rem; text-align: center;
    background: #000; pointer-events: none;
}

/* ══════════════════════════════════
   FLASH
══════════════════════════════════ */
#g-flash {
    position: fixed; inset: 0; z-index: 9999;
    display: none; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 18px; pointer-events: none;
}
#g-flash.go {
    display: flex;
    animation: gFadeInOut .65s ease-out forwards;
    background: rgba(0,210,100,.84);
    backdrop-filter: blur(4px);
}
@keyframes gFadeInOut {
    0% { opacity: 0; } 16% { opacity: 1; } 70% { opacity: 1; } 100% { opacity: 0; }
}
.g-check {
    width: 96px; height: 96px; background: #fff;
    border-radius: 50%; display: flex; align-items: center;
    justify-content: center; font-size: 42px; color: #00c853;
    box-shadow: 0 8px 32px rgba(0,0,0,.25);
}
.g-check.pop { animation: checkPop .45s cubic-bezier(.34,1.56,.64,1) .08s both; }
@keyframes checkPop {
    from { transform: scale(.2); opacity: 0; }
    to   { transform: scale(1);  opacity: 1; }
}
.g-text { color: #fff; font-size: 1.18rem; font-weight: 700; }
.g-text.fadein { animation: gTextIn .3s ease-out .18s both; }
@keyframes gTextIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ══════════════════════════════════
   TARJETA RESULTADO
══════════════════════════════════ */
.res-card {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 16px; overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    animation: resSlide .38s cubic-bezier(.22,1,.36,1) forwards;
}
@keyframes resSlide {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.res-card-body { padding: 20px; }
.pkg-photo {
    width: 100%; max-height: 200px; object-fit: cover;
    border-radius: 10px; border: 1px solid #e9ecef;
    cursor: zoom-in; transition: opacity .15s;
}
.pkg-photo:hover { opacity: .88; }
.info-row { padding: 5px 0; border-bottom: 1px solid #f5f5f5; display: flex; flex-direction: column; }
.info-row:last-child { border-bottom: none; }
.info-lbl { font-size: .71rem; color: #adb5bd; text-transform: uppercase; letter-spacing: .4px; font-weight: 600; }
.info-val  { font-size: .92rem; color: #212529; }
.stat-badge { font-size: .8rem; padding: 4px 10px; border-radius: 20px; }

/* ══════════════════════════════════
   MODAL FOTO
══════════════════════════════════ */
#photo-modal {
    position: fixed; inset: 0; z-index: 10000;
    background: rgba(0,0,0,.94); backdrop-filter: blur(6px);
    display: none; align-items: center; justify-content: center;
    cursor: zoom-out;
}
#photo-modal.show { display: flex; }
#photo-modal-img {
    max-width: 90vw; max-height: 88vh;
    border-radius: 14px; object-fit: contain;
    box-shadow: 0 12px 50px rgba(0,0,0,.7);
    animation: photoIn .25s ease-out;
    cursor: default;
}
@keyframes photoIn {
    from { transform: scale(.82); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}
#photo-modal-close {
    position: absolute; top: 18px; right: 22px;
    background: rgba(255,255,255,.12); color: #fff;
    border: none; border-radius: 50%;
    width: 42px; height: 42px; font-size: 22px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background .15s;
}
#photo-modal-close:hover { background: rgba(255,255,255,.25); }
#photo-modal-caption { position: absolute; bottom: 20px; color: rgba(255,255,255,.55); font-size: .85rem; }
</style>

<!-- ── FLASH ── -->
<div id="g-flash">
    <div class="g-check" id="g-check"><i class="fa-solid fa-check"></i></div>
    <div class="g-text"  id="g-text">¡Paquete encontrado!</div>
</div>

<!-- ── MODAL FOTO ── -->
<div id="photo-modal" onclick="cerrarFotoModal()">
    <button id="photo-modal-close" onclick="cerrarFotoModal()">×</button>
    <img id="photo-modal-img" src="" alt="Foto">
    <div id="photo-modal-caption"></div>
</div>

<!-- ══ OVERLAY CÁMARA (cubre todo, z-index > navbar) ══ -->
<div id="cam-overlay">

    <div id="cam-placeholder">
        <div class="spinner-border text-light" style="width:2.4rem;height:2.4rem"></div>
        <span>Iniciando cámara…</span>
    </div>

    <div id="cam-feed"></div>

    <div id="qr-frame">
        <div class="qc tl"></div>
        <div class="qc tr"></div>
        <div class="qc bl"></div>
        <div class="qc br"></div>
        <div id="truck-road">
            <span id="scan-truck">🚚</span>
        </div>
    </div>

    <div id="cam-topbar">
        <span class="cam-title"><i class="fa-solid fa-qrcode me-2"></i>Escanear paquete</span>
        <button id="btn-cerrar-cam" title="Cerrar">×</button>
    </div>

    <div id="cam-bottom">
        <span class="cam-hint">Apunta al código QR del paquete</span>
        <div class="manual-row">
            <input type="text" id="manual-qr" placeholder="O ingresa el código…" maxlength="20" autocomplete="off">
            <button id="btn-manual"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>

</div>

<!-- ══ PÁGINA NORMAL ══ -->
<div class="scn-page">

    <div class="scn-hero">
        <div class="scn-hero-text">
            <h3><i class="fa-solid fa-qrcode me-2"></i>Escáner QR</h3>
            <p>Escanea el código de un paquete para ver su información en tiempo real</p>
        </div>
        <button class="btn-abrir-scanner" id="btn-abrir-cam">
            <i class="fa-solid fa-camera"></i>
            Abrir Escáner
        </button>
    </div>

    <div id="pnl-placeholder">
        <i class="fa-solid fa-qrcode"></i>
        <p>Abre el escáner o ingresa un código<br>para ver la información del paquete</p>
    </div>

    <div id="pnl-loading">
        <div class="spinner-border text-primary" style="width:2.8rem;height:2.8rem"></div>
        <span class="text-muted">Buscando paquete…</span>
    </div>

    <div id="pnl-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p id="err-msg" class="fw-semibold mb-0"></p>
        <button onclick="reiniciarScanner()" class="btn btn-sm btn-outline-danger mt-1">
            <i class="fa-solid fa-rotate me-1"></i>Intentar de nuevo
        </button>
    </div>

    <div id="pnl-result"></div>

</div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
const STS = {
    pendiente:    ['Pendiente',    'warning'],
    recolectado:  ['Recolectado',  'info'],
    en_casillero: ['En casillero', 'primary'],
    entregado:    ['Entregado',    'success'],
    no_retirado:  ['No retirado',  'secondary'],
    devuelto:     ['Devuelto',     'danger'],
    cancelado:    ['Cancelado',    'dark'],
};
const SVC = { 1:'Punto fijo', 2:'Personalizado', 3:'Recolecta', 4:'Casillero' };

let qrReader = null;
let locked   = false;

document.getElementById('btn-abrir-cam').addEventListener('click', abrirCamara);
document.getElementById('btn-cerrar-cam').addEventListener('click', cerrarCamara);

function abrirCamara() {
    document.getElementById('cam-overlay').classList.add('show');
    document.body.style.overflow = 'hidden';
    iniciarEscaner();
}

function cerrarCamara() {
    if (qrReader) { qrReader.stop().catch(() => {}); qrReader = null; }
    locked = false;
    document.getElementById('cam-overlay').classList.remove('show');
    document.getElementById('cam-feed').innerHTML = '';
    document.getElementById('qr-frame').classList.remove('ok');
    document.getElementById('scan-truck').style.animationPlayState = 'running';
    document.getElementById('manual-qr').value = '';
    const ph = document.getElementById('cam-placeholder');
    ph.innerHTML = `<div class="spinner-border text-light" style="width:2.4rem;height:2.4rem"></div><span>Iniciando cámara…</span>`;
    ph.style.display = 'flex';
    document.body.style.overflow = '';
}

function iniciarEscaner() {
    locked   = false;
    qrReader = new Html5Qrcode('cam-feed');
    qrReader.start(
        { facingMode: 'environment' },
        { fps: 15, aspectRatio: 1.77 },
        onQrDetected,
        () => {}
    ).then(() => {
        document.getElementById('cam-placeholder').style.display = 'none';
    }).catch(err => {
        console.error(err);
        const ph = document.getElementById('cam-placeholder');
        ph.innerHTML = `<i class="fa-solid fa-video-slash" style="font-size:3rem;opacity:.5"></i>
            <span>No se pudo acceder a la cámara.<br>Verifica los permisos del navegador.</span>`;
    });
}

function onQrDetected(raw) {
    if (locked) return;
    locked = true;
    document.getElementById('qr-frame').classList.add('ok');
    document.getElementById('scan-truck').style.animationPlayState = 'paused';
    if (qrReader) { qrReader.stop().catch(() => {}); qrReader = null; }

    dispararFlash();
    cerrarCamara();
    showPanel('loading');

    fetch(`/packages/scan-buscar?qr=${encodeURIComponent(raw.trim())}`)
        .then(r  => r.json())
        .then(d  => { if (d.found) renderResultado(d.package); else mostrarError(d.message || 'No encontrado.'); })
        .catch(() => mostrarError('Error de conexión.'));
}

function dispararFlash() {
    const flash = document.getElementById('g-flash');
    const check = document.getElementById('g-check');
    const txt   = document.getElementById('g-text');
    flash.classList.add('go'); check.classList.add('pop'); txt.classList.add('fadein');
    setTimeout(() => {
        flash.classList.remove('go'); check.classList.remove('pop'); txt.classList.remove('fadein');
    }, 700);
}

document.getElementById('btn-manual').addEventListener('click', () => {
    const v = document.getElementById('manual-qr').value.trim().toUpperCase();
    if (!v) return;
    cerrarCamara();
    showPanel('loading');
    fetch(`/packages/scan-buscar?qr=${encodeURIComponent(v)}`)
        .then(r  => r.json())
        .then(d  => { if (d.found) renderResultado(d.package); else mostrarError(d.message || 'No encontrado.'); })
        .catch(() => mostrarError('Error de conexión.'));
});
document.getElementById('manual-qr').addEventListener('keydown', e => {
    if (e.key === 'Enter') document.getElementById('btn-manual').click();
});

function renderResultado(p) {
    const fmt = v => (v != null && v !== '' && parseFloat(v) !== 0) ? '$' + parseFloat(v).toFixed(2) : '—';
    const x   = s => String(s || '—').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

    const [sL, sC] = STS[p.estatus] || [p.estatus, 'secondary'];
    let destino = '—';
    if      (p.tipo_servicio == 1) destino = p.point_name || '—';
    else if (p.tipo_servicio == 2) destino = p.destino_personalizado || '—';
    else if (p.tipo_servicio == 3) destino = p.lugar_recolecta_paquete || '—';
    else if (p.tipo_servicio == 4) destino = p.external_location_nombre || p.numero_casillero || 'Casillero';

    const ubic = [p.departamento_nombre, p.municipio_nombre, p.colonia_nombre].filter(Boolean).join(' → ');
    const pend = parseFloat(p.flete_pendiente || 0);
    const pCls = pend > 0 ? 'text-danger fw-semibold' : 'text-muted';
    const fE   = p.foto_url ? p.foto_url.replace(/'/g, "\\'") : '';
    const cE   = p.cliente  ? p.cliente.replace(/'/g,  "\\'") : '';

    const fotoHtml = p.foto_url
        ? `<img src="${x(p.foto_url)}" class="pkg-photo mb-2"
               onclick="abrirFotoModal('${fE}','Paquete #${p.id} — ${cE}')"
               onerror="this.style.display='none'" alt="Foto">`
        : `<div class="d-flex align-items-center justify-content-center bg-light rounded mb-2"
               style="height:130px;color:#ced4da">
             <i class="fa-solid fa-image" style="font-size:2.5rem"></i>
           </div>`;

    const ubicRow = ubic ? `<div class="info-row"><span class="info-lbl">Ubicación</span><span class="info-val small">${x(ubic)}</span></div>` : '';
    const comRow  = p.comentarios ? `<div class="info-row"><span class="info-lbl">Comentarios</span><span class="info-val small text-muted">${x(p.comentarios)}</span></div>` : '';

    document.getElementById('pnl-result').innerHTML = `
    <div class="res-card">
      <div class="res-card-body">
        <div class="d-flex justify-content-between align-items-start mb-3 gap-2">
          <div>
            <h5 class="fw-bold mb-1">Paquete #${x(p.id)}</h5>
            <span class="badge bg-${sC} stat-badge">${x(sL)}</span>
          </div>
          <button onclick="reiniciarScanner()"
              class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 flex-shrink-0">
            <i class="fa-solid fa-camera"></i><span>Escanear otro</span>
          </button>
        </div>
        <div class="row g-3">
          <div class="col-sm-4">
            ${fotoHtml}
          </div>
          <div class="col-sm-8">
            <div class="info-row"><span class="info-lbl">Cliente</span><span class="info-val fw-semibold">${x(p.cliente)}</span></div>
            <div class="info-row"><span class="info-lbl">Vendedor</span><span class="info-val">${x(p.seller_name)}</span></div>
            <div class="info-row"><span class="info-lbl">Tipo de servicio</span><span class="info-val">${SVC[p.tipo_servicio] || p.tipo_servicio}</span></div>
            <div class="info-row"><span class="info-lbl">Fecha ingreso</span><span class="info-val">${x(p.fecha_ingreso)}</span></div>
            <div class="info-row"><span class="info-lbl">Destino</span><span class="info-val">${x(destino)}</span></div>
            ${ubicRow}
          </div>
        </div>
        <hr class="my-3">
        <div class="row g-2">
          <div class="col-4">
            <div class="info-row"><span class="info-lbl">Monto</span><span class="info-val">${fmt(p.monto)}</span></div>
          </div>
          <div class="col-4">
            <div class="info-row"><span class="info-lbl">Flete total</span><span class="info-val">${fmt(p.flete_total)}</span></div>
            <div class="info-row"><span class="info-lbl">Pagado</span><span class="info-val text-success fw-semibold">${fmt(p.flete_pagado)}</span></div>
          </div>
          <div class="col-4">
            <div class="info-row"><span class="info-lbl">Pendiente</span><span class="info-val ${pCls}">${fmt(pend)}</span></div>
          </div>
        </div>
        ${comRow}
        <div class="d-flex gap-2 mt-3 flex-wrap">
          <a href="/packages/${p.id}" class="btn btn-sm btn-primary" target="_blank">
            <i class="fa-solid fa-eye me-1"></i>Ver detalle
          </a>
          <a href="/packages/${p.id}/label" class="btn btn-sm btn-outline-dark" target="_blank">
            <i class="fa-solid fa-print me-1"></i>Imprimir viñeta
          </a>
        </div>
      </div>
    </div>`;

    showPanel('result');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function mostrarError(msg) { document.getElementById('err-msg').textContent = msg; showPanel('error'); }
function showPanel(which) {
    document.getElementById('pnl-placeholder').style.display = which === 'placeholder' ? 'flex'  : 'none';
    document.getElementById('pnl-loading').style.display     = which === 'loading'     ? 'flex'  : 'none';
    document.getElementById('pnl-error').style.display       = which === 'error'       ? 'flex'  : 'none';
    document.getElementById('pnl-result').style.display      = which === 'result'      ? 'block' : 'none';
}
function reiniciarScanner() {
    document.getElementById('pnl-result').innerHTML = '';
    showPanel('placeholder');
    abrirCamara();
}

function abrirFotoModal(url, cap) {
    document.getElementById('photo-modal-img').src = url;
    document.getElementById('photo-modal-caption').textContent = cap || '';
    document.getElementById('photo-modal').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function cerrarFotoModal() {
    document.getElementById('photo-modal').classList.remove('show');
    document.getElementById('photo-modal-img').src = '';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { cerrarFotoModal(); cerrarCamara(); }
});
</script>

<?= $this->endSection() ?>

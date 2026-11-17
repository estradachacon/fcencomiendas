<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<style>
/* ── Bootstrap Datepicker: tamaño y usabilidad ── */
.datepicker {
    font-size: 15px;
}
.datepicker .datepicker-switch,
.datepicker .prev,
.datepicker .next {
    font-size: 15px;
    padding: 10px 14px;
}
.datepicker table tr td,
.datepicker table tr th {
    width: 42px;
    height: 42px;
    font-size: 14px;
}
.datepicker table tr th.dow {
    font-size: 12px;
    color: #6c757d;
}
/* ── días con paquetes ── */
.datepicker table tr td.day.has-pkgs {
    background: rgba(8,145,178,.18) !important;
    border: 2px solid #0891b2 !important;
    border-radius: 4px !important;
    font-weight: 700 !important;
    color: #083344 !important;
}
.datepicker table tr td.day.has-pkgs:hover,
.datepicker table tr td.day.has-pkgs.focused {
    background: rgba(8,145,178,.35) !important;
}

    /* ===== SELECT2 + BOOTSTRAP FIX ===== */
.select2-container .select2-selection--single {
    height: calc(2.25rem + 5px);
    padding: .375rem .75rem;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.5; padding-left: 0;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: calc(2.25rem + 2px);
}
.select2-container { width: 100% !important; }

/* ── Evitar que Select2 expanda el mainbody ── */
.select2-dropdown {
    max-width: calc(100vw - 24px) !important;
    box-sizing: border-box !important;
    overflow: hidden;
}
.select2-results__options { overflow-x: hidden; }
/* Permitir que el dropdown salga del card sin clip */
.card-body { overflow: visible !important; }

/* ── Card headers ── */
.trk-card-hdr {
    background: linear-gradient(135deg, #083344 0%, #0c5f78 60%, #0891b2 100%);
    color: #fff; padding: 14px 20px; border-radius: .375rem .375rem 0 0;
    display: flex; align-items: center; justify-content: space-between;
}
.trk-card-hdr h5 { margin: 0; font-size: .95rem; font-weight: 700; }
.trk-card-hdr .trk-hdr-icon { color: rgba(255,255,255,.55); font-size: .9rem; }

/* ── Botones de acción ── */
.trk-action-btns {
    display: flex; flex-wrap: wrap; gap: 8px; margin-top: 4px;
}
.trk-action-btns .btn {
    flex: 1 1 auto; min-width: 160px; font-size: .85rem;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
@media (max-width: 480px) {
    .trk-action-btns .btn { min-width: calc(50% - 4px); font-size: .78rem; padding: 8px 6px; }
    .trk-action-btns .btn .btn-txt { display: none; }
    .trk-action-btns .btn .btn-txt-short { display: inline; }
}
@media (min-width: 481px) {
    .trk-action-btns .btn .btn-txt { display: inline; }
    .trk-action-btns .btn .btn-txt-short { display: none; }
}

/* ── Tabla seleccionados ── */
#tablaTracking { border-collapse: separate; border-spacing: 0; }
#tablaTracking thead th {
    background: #f8faff; color: #374151;
    font-size: .72rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .5px;
    padding: 10px 14px; border-bottom: 2px solid #e5e7eb;
    white-space: nowrap;
}
#tablaTracking tbody tr {
    transition: background .15s;
}
#tablaTracking tbody tr:hover { background: #f0f9ff; }
#tablaTracking tbody td {
    padding: 10px 14px; vertical-align: middle;
    border-bottom: 1px solid #f1f5f9; font-size: .88rem;
}
/* Badges de tipo */
.trk-tipo-badge {
    display: inline-block; border-radius: 20px;
    padding: 3px 10px; font-size: .72rem; font-weight: 700;
    white-space: nowrap;
}
.trk-tipo-1 { background: #e0f9f9; color: #083344; }
.trk-tipo-2 { background: #fff3ea; color: #9a3412; }
.trk-tipo-3 { background: #f0fdf4; color: #065f46; }
.trk-tipo-4 { background: #f5f3ff; color: #4c1d95; }
/* ID del paquete */
.trk-pkg-id {
    font-weight: 700; color: #083344;
    font-size: .88rem;
}
/* Badge duplicado solo visible en mobile (dentro de col ID) */
.trk-badge-mobile { display: none; }
@media (max-width: 640px) {
    .trk-badge-mobile { display: inline-block; margin-right: 6px; }
}
/* Destino */
.trk-dest-main { font-weight: 500; color: #1f2937; }
.trk-dest-sub  { font-size: .76rem; color: #6b7280; margin-top: 2px; }
/* Monto */
.trk-monto { font-weight: 700; color: #059669; }
.trk-monto.cancelado { color: #9ca3af; font-style: italic; font-weight: 400; }
/* Botón quitar */
.trk-btn-quit {
    background: none; border: 1px solid #fca5a5;
    color: #ef4444; border-radius: 8px; padding: 4px 8px;
    font-size: .82rem; transition: all .15s; cursor: pointer;
}
.trk-btn-quit:hover { background: #fef2f2; border-color: #ef4444; }
/* Estado vacío */
.trk-empty-state {
    text-align: center; padding: 36px 20px !important;
    color: #9ca3af;
}
.trk-empty-state i { font-size: 2rem; display: block; margin-bottom: 8px; opacity: .4; }
.trk-empty-state p { margin: 4px 0 0; font-size: .82rem; }
/* ── Mobile: tabla → cards ── */
@media (max-width: 640px) {
    #tablaTracking,
    #tablaTracking tbody { display: block !important; }

    #tablaTracking thead { display: none !important; }

    #tablaTracking tbody tr {
        display: block !important;
        margin: 0 0 10px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        padding: 10px 42px 10px 12px !important;
        background: #fff;
        box-shadow: 0 1px 6px rgba(0,0,0,.06);
        position: relative;
    }
    #tablaTracking tbody tr:hover { background: #f8faff; }

    /* Celdas como filas de dato */
    #tablaTracking tbody td {
        display: flex !important;
        align-items: flex-start;
        border: none !important;
        padding: 4px 0 !important;
        font-size: .86rem;
        gap: 6px;
    }
    /* Etiqueta automática desde data-label */
    #tablaTracking tbody td[data-label]::before {
        content: attr(data-label);
        font-size: .68rem; font-weight: 800;
        color: #9ca3af; text-transform: uppercase;
        letter-spacing: .4px; min-width: 68px;
        flex-shrink: 0; padding-top: 3px;
    }
    /* Ocultar col Tipo (el badge aparece integrado en la card) */
    #tablaTracking tbody td:nth-child(1) { display: none !important; }
    /* ID: mostrar badge de tipo junto al número */
    #tablaTracking tbody td:nth-child(2)::before { content: "Paquete"; }
    /* Botón quitar: esquina top-right */
    #tablaTracking tbody td:nth-child(6) {
        display: block !important;
        position: absolute !important;
        top: 10px; right: 10px;
        padding: 0 !important;
    }
    #tablaTracking tbody td:nth-child(6)::before { display: none !important; }

    .trk-total-row { text-align: left !important; }
}

/* ── Guardar ── */
.trk-save-row { display: flex; justify-content: flex-end; }
@media (max-width: 600px) {
    .trk-save-row { justify-content: stretch; }
    .trk-save-row .btn { width: 100%; }
}

/* ── Cards de paquetes en modal de ruta ── */
.pkg-card-list { display: flex; flex-direction: column; gap: 8px; }
.pkg-card {
    display: flex; align-items: center; gap: 10px;
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 8px; padding: 10px 12px;
    cursor: pointer; transition: border-color .15s, box-shadow .15s;
}
.pkg-card:hover  { border-color: #0891b2; box-shadow: 0 1px 6px rgba(8,145,178,.15); }
.pkg-card.selected { border-color: #0891b2; background: rgba(8,145,178,.07); }
.pkg-card input[type="checkbox"] { flex-shrink: 0; width: 18px; height: 18px; cursor: pointer; }
.pkg-card-body  { flex: 1; min-width: 0; }
.pkg-card-top   { display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap; }
.pkg-card-id    { font-weight: 700; font-size: .78rem; color: #6b7280; }
.pkg-card-name  { font-weight: 600; font-size: .9rem; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.pkg-card-sub   { font-size: .78rem; color: #6b7280; margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.pkg-card-monto { flex-shrink: 0; font-weight: 700; font-size: .88rem; color: #083344; }

/* ── Modales full-screen en mobile ── */
@media (max-width: 600px) {
    .modal-dialog { margin: 0 !important; max-width: 100% !important; height: 100%; }
    .modal-content { border-radius: 0 !important; min-height: 100vh; }
    .modal-body { overflow-y: auto; max-height: calc(100vh - 130px); }
}

/* ── Tablas en modales: scroll horizontal ── */
.modal .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

/* ── Modal headers ── */
.modal-hdr-primary { background: linear-gradient(135deg,#083344,#0891b2) !important; color:#fff !important; }
.modal-hdr-secondary { background: linear-gradient(135deg,#374151,#6b7280) !important; color:#fff !important; }
.modal-hdr-success { background: linear-gradient(135deg,#064e3b,#059669) !important; color:#fff !important; }
.modal-hdr-primary h5, .modal-hdr-secondary h5, .modal-hdr-success h5 { color:#fff; }
.modal-hdr-primary .close, .modal-hdr-secondary .close, .modal-hdr-success .close { color:#fff; opacity:.85; }

/* ── Overlay escáner tracking ── */
#trk-cam-overlay {
    position: fixed; inset: 0; z-index: 1050;
    background: #000; display: none; flex-direction: column;
}
#trk-cam-overlay.active { display: flex; }
#trk-cam-topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 16px; background: rgba(0,0,0,.7);
    flex-shrink: 0; z-index: 10;
}
#trk-cam-topbar span { color: #fff; font-weight: 700; font-size: .95rem; }
#trk-cam-topbar button {
    background: rgba(255,255,255,.15); color: #fff; border: none;
    border-radius: 8px; padding: 7px 14px; font-weight: 700; cursor: pointer;
    font-size: .9rem;
}
#trk-cam-view {
    flex: 1; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
}
#trk-cam-reader { width: 100%; height: 100%; }
.trk-qr-frame {
    position: absolute; width: 240px; height: 240px;
    border: none; pointer-events: none;
}
.trk-corner {
    position: absolute; width: 28px; height: 28px; border-color: #00e676;
    border-style: solid; border-width: 0; animation: trkCornerPulse 1.5s ease-in-out infinite;
}
.trk-corner.tl { top: 0; left: 0; border-top-width: 4px; border-left-width: 4px; border-radius: 4px 0 0 0; }
.trk-corner.tr { top: 0; right: 0; border-top-width: 4px; border-right-width: 4px; border-radius: 0 4px 0 0; }
.trk-corner.bl { bottom: 0; left: 0; border-bottom-width: 4px; border-left-width: 4px; border-radius: 0 0 0 4px; }
.trk-corner.br { bottom: 0; right: 0; border-bottom-width: 4px; border-right-width: 4px; border-radius: 0 0 4px 0; }
@keyframes trkCornerPulse {
    0%, 100% { opacity: 1; } 50% { opacity: .4; }
}
#trk-cam-hint {
    padding: 10px 16px 14px; text-align: center;
    color: rgba(255,255,255,.7); font-size: .82rem; flex-shrink: 0; background: rgba(0,0,0,.7);
}
/* ── Barra de estado / resultado ── */
#trk-cam-status {
    display: none; flex-shrink: 0;
    background: rgba(8,20,30,.96);
    padding: 24px 20px 28px;
    text-align: center; color: #fff;
    animation: trkSlideUp .22s ease;
}
#trk-cam-status.active { display: block; }
@keyframes trkSlideUp {
    from { transform: translateY(60px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}
.trk-st-ico  { font-size: 2.4rem; margin-bottom: 8px; display: block; }
.trk-st-ttl  { font-size: 1.05rem; font-weight: 800; margin-bottom: 5px; }
.trk-st-msg  { font-size: .86rem; color: rgba(255,255,255,.72); margin-bottom: 18px; line-height: 1.5; }
.trk-st-btns { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
.trk-st-btns button {
    padding: 10px 26px; border: none; border-radius: 10px;
    font-weight: 700; cursor: pointer; font-size: .9rem; transition: opacity .15s;
}
.trk-st-btns button:hover { opacity: .85; }
.trk-btn-retry   { background: #0891b2; color: #fff; }
.trk-btn-dismiss { background: rgba(255,255,255,.14); color: #fff; }
.trk-btn-confirm { background: #22c55e; color: #fff; }
.trk-btn-reenvia { background: #f97316; color: #fff; }

#trk-flash {
    position: fixed; inset: 0; z-index: 9999;
    background: #fff; opacity: 0; pointer-events: none; transition: opacity .15s;
}

</style>
<script src="<?= base_url('backend/assets/js/scripts_newtracking.js') ?>?v=<?= filemtime(FCPATH . 'backend/assets/js/scripts_newtracking.js') ?>"></script>
<div class="row">
    <div class="col-md-12">

        <!-- ENCABEZADO DEL TRACKING -->
        <div class="card shadow-sm mb-4">
            <div class="trk-card-hdr">
                <h5><i class="fa fa-truck mr-2"></i>Nuevo Tracking</h5>
                <span class="trk-hdr-icon"><i class="fa fa-route"></i></span>
            </div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-sm-6 col-md-4">
                        <label class="font-weight-600 small text-uppercase text-muted">Motorista</label>
                        <select id="motorista" name="motorista" class="form-control select2" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($motoristas as $m): ?>
                                <option value="<?= $m['id'] ?>"><?= esc($m['user_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-md-4">
                        <label class="font-weight-600 small text-uppercase text-muted">Fecha de seguimiento</label>
                        <input type="text" id="fecha_tracking" name="fecha_tracking" class="form-control" readonly required>
                    </div>
                </div>

                <hr class="my-3">

                <div class="trk-action-btns">
                    <button id="btnRutas" class="btn btn-primary" type="button">
                        <i class="fa fa-route"></i>
                        <span class="btn-txt">Agregar por ruta</span>
                        <span class="btn-txt-short">Rutas</span>
                    </button>
                    <button id="btnEspeciales" class="btn btn-secondary" type="button">
                        <i class="fa fa-box"></i>
                        <span class="btn-txt">Agregar personalizados</span>
                        <span class="btn-txt-short">Personalizados</span>
                    </button>
                    <button id="btnPendientes3" class="btn btn-secondary" type="button">
                        <i class="fa fa-clock"></i>
                        <span class="btn-txt">Pendientes de recolecta</span>
                        <span class="btn-txt-short">Recolecta</span>
                    </button>
                    <button id="btnEscanear" class="btn btn-dark" type="button">
                        <i class="fa fa-qrcode"></i>
                        <span class="btn-txt">Escanear QR</span>
                        <span class="btn-txt-short">QR</span>
                    </button>
                </div>

            </div>
        </div>

        <!-- TABLA DE PAQUETES SELECCIONADOS -->
        <div class="card shadow-sm mb-4">
            <div class="trk-card-hdr">
                <h5><i class="fa fa-boxes mr-2"></i>Paquetes Seleccionados</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0" id="tablaTracking">
                        <thead class="thead-light">
                            <tr>
                                <th>Tipo</th>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Destino</th>
                                <th>Monto</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="tracking-body"></tbody>
                    </table>
                </div>
                <div class="trk-total-row text-right px-3 py-3">
                    <h5 class="mb-0">Total: <span id="totalTracking" class="text-success font-weight-bold">$0.00</span></h5>
                </div>
            </div>
        </div>

        <!-- BOTÓN FINAL -->
        <div class="trk-save-row mb-5">
            <button id="btnGuardar" class="btn btn-success btn-lg">
                <i class="fa fa-save mr-1"></i> Guardar Tracking
            </button>
        </div>
    </div>
</div>



<!-- ── MODAL 1: Por Ruta ── -->
<div class="modal fade" id="modalRutas" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-hdr-primary">
                <h5 class="modal-title"><i class="fa fa-route mr-2"></i>Seleccionar paquetes por ruta</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-sm-8 col-md-6">
                        <label for="ruta_select">Ruta</label>
                        <select id="ruta_select" class="form-control">
                            <option value="">Seleccione una ruta</option>
                            <?php foreach ($rutas as $r): ?>
                                <option value="<?= $r->id ?>"><?= $r->route_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button class="btn btn-sm btn-outline-primary mb-3" id="selectAllRuta">
                    <i class="fa fa-check-square mr-1"></i> Seleccionar / Quitar todos
                </button>
                <div id="tablaPaquetesRuta" class="pkg-card-list"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="agregarPorRuta"><i class="fa fa-plus mr-1"></i>Agregar Seleccionados</button>
                <button class="btn btn-light" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- ── MODAL 2: Personalizados ── -->
<div class="modal fade" id="modalEspeciales" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-hdr-secondary">
                <h5 class="modal-title"><i class="fa fa-box mr-2"></i>Agregar personalizados</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-sm-8 col-md-6">
                        <label for="municipioEspecial">Municipio</label>
                        <select id="municipioEspecial" class="form-control">
                            <option value="">Todos los municipios</option>
                        </select>
                    </div>
                </div>
                <!-- filtro_tipo oculto, usado solo por JS -->
                <select id="filtro_tipo" style="display:none">
                    <option value="">Todos</option>
                    <option value="2">Personalizados</option>
                    <option value="3">Recolecciones</option>
                </select>
                <button class="btn btn-sm btn-outline-secondary mb-3" id="selectAllEspeciales">
                    <i class="fa fa-check-square mr-1"></i> Seleccionar / Quitar todos
                </button>
                <div id="tablaEspeciales" class="pkg-card-list"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="agregarEspeciales"><i class="fa fa-plus mr-1"></i>Agregar Seleccionados</button>
                <button class="btn btn-light" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- ── MODAL 3: Pendientes de recolecta ── -->
<div class="modal fade" id="modalPendientes3" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-hdr-success">
                <h5 class="modal-title"><i class="fa fa-clock mr-2"></i>Paquetes pendientes de recolecta</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <button class="btn btn-sm btn-outline-success mb-3" id="selectAllPendientes3">
                    <i class="fa fa-check-square mr-1"></i> Seleccionar / Quitar todos
                </button>
                <div id="tablaPendientes3" class="pkg-card-list"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="agregarPendientes3"><i class="fa fa-plus mr-1"></i>Agregar Seleccionados</button>
                <button class="btn btn-light" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- ═══ OVERLAY CÁMARA ═══ -->
<div id="trk-flash"></div>
<div id="trk-cam-overlay">
    <div id="trk-cam-topbar">
        <span><i class="fa fa-qrcode mr-2"></i>Escanear paquete</span>
        <button onclick="trkCerrarCamara()">✕ Cerrar</button>
    </div>
    <div id="trk-cam-view">
        <div id="trk-cam-reader"></div>
        <div class="trk-qr-frame">
            <div class="trk-corner tl"></div>
            <div class="trk-corner tr"></div>
            <div class="trk-corner bl"></div>
            <div class="trk-corner br"></div>
        </div>
    </div>
    <div id="trk-cam-hint">Apunta la cámara al código QR del paquete</div>
    <!-- Panel de resultado (reemplaza Swal en el flujo del escáner) -->
    <div id="trk-cam-status">
        <span class="trk-st-ico" id="trk-st-ico"></span>
        <div class="trk-st-ttl" id="trk-st-ttl"></div>
        <div class="trk-st-msg" id="trk-st-msg"></div>
        <div class="trk-st-btns" id="trk-st-btns"></div>
    </div>
</div>

<script>
(function () {
    let trkScanner    = null;
    let trkEscaneando = false;
    let trkUltimoQr   = '';

    /* ── helpers de estado ── */
    function trkStatus(ico, ttl, msg, btns) {
        document.getElementById('trk-st-ico').textContent  = ico;
        document.getElementById('trk-st-ttl').textContent  = ttl;
        document.getElementById('trk-st-msg').innerHTML    = msg;
        const bEl = document.getElementById('trk-st-btns');
        bEl.innerHTML = '';
        btns.forEach(b => {
            const btn = document.createElement('button');
            btn.className = b.cls;
            btn.textContent = b.txt;
            btn.addEventListener('click', b.fn);
            bEl.appendChild(btn);
        });
        document.getElementById('trk-cam-status').classList.add('active');
        document.getElementById('trk-cam-hint').style.display = 'none';
    }
    function trkStatusOcultar() {
        document.getElementById('trk-cam-status').classList.remove('active');
        document.getElementById('trk-cam-hint').style.display = '';
    }
    function trkStatusLoading() {
        trkStatus('⏳', 'Consultando…', 'Buscando el paquete en el sistema.', []);
    }

    /* ── abrir / cerrar cámara ── */
    document.getElementById('btnEscanear').addEventListener('click', function () {
        if (!document.getElementById('fecha_tracking').value) {
            Swal.fire({ icon: 'warning', title: 'Fecha faltante', text: 'Seleccione la fecha del tracking antes de escanear.' });
            return;
        }
        trkAbrirCamara();
    });

    function trkAbrirCamara() {
        trkStatusOcultar();
        document.getElementById('trk-cam-overlay').classList.add('active');
        document.body.style.overflow = 'hidden';
        trkUltimoQr   = '';
        trkEscaneando = false;

        if (!trkScanner) trkScanner = new Html5Qrcode('trk-cam-reader');

        trkScanner.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 240, height: 240 }, aspectRatio: 1.0 },
            function (decodedText) {
                if (trkEscaneando || decodedText === trkUltimoQr) return;
                trkUltimoQr   = decodedText;
                trkEscaneando = true;
                trkScanner.stop().then(() => trkProcesarQr(decodedText));
            },
            null
        ).catch(err => {
            console.error('Cámara error:', err);
            trkStatus('📵', 'Sin cámara', 'No se pudo iniciar la cámara. Verifica los permisos.', [
                { cls: 'trk-btn-dismiss', txt: 'Cerrar', fn: trkCerrarCamara }
            ]);
        });
    }

    window.trkCerrarCamara = function () {
        trkStatusOcultar();
        document.getElementById('trk-cam-overlay').classList.remove('active');
        document.body.style.overflow = '';
        trkEscaneando = false;
        if (trkScanner) trkScanner.stop().catch(() => {});
    };

    function trkFlash() {
        const f = document.getElementById('trk-flash');
        f.style.opacity = '1';
        setTimeout(() => { f.style.opacity = '0'; }, 180);
    }

    async function trkProcesarQr(qr) {
        trkFlash();
        trkStatusLoading();

        try {
            const resp = await fetch('/packages/scan-buscar?qr=' + encodeURIComponent(qr));
            const data = await resp.json();

            if (!data.found) {
                trkStatus('❌', 'No encontrado', data.message || 'El QR no tiene registro en el sistema.', [
                    { cls: 'trk-btn-retry',   txt: '🔄 Reintentar', fn: trkAbrirCamara },
                    { cls: 'trk-btn-dismiss', txt: 'Cerrar',        fn: trkCerrarCamara }
                ]);
                return;
            }

            const pkg     = data.package;
            const estatus = pkg.estatus;
            const ELEGIBLES = ['pendiente', 'recolectado', 'recolecta_fallida'];

            if (window.trackingApp && window.trackingApp.isYaSeleccionado(pkg.id)) {
                trkStatus('ℹ️', 'Ya en la lista',
                    `El paquete <strong>#${pkg.id}</strong> (${pkg.cliente}) ya fue agregado.`, [
                    { cls: 'trk-btn-retry',   txt: '🔄 Escanear otro', fn: trkAbrirCamara },
                    { cls: 'trk-btn-dismiss', txt: 'Cerrar',           fn: trkCerrarCamara }
                ]);
                return;
            }

            if (estatus === 'no_retirado') {
                const rutaTracking = document.getElementById('ruta_select')?.value;
                const rutaDistinta = rutaTracking && pkg.ruta_id && String(pkg.ruta_id) !== String(rutaTracking);
                const rutaNombreTracking = rutaTracking
                    ? (document.querySelector(`#ruta_select option[value="${rutaTracking}"]`)?.textContent || 'la ruta seleccionada')
                    : null;

                trkStatus('🔄', `Paquete #${pkg.id}`,
                    `<strong>${pkg.cliente}</strong><br>
                     <small style="color:rgba(255,255,255,.6)">${pkg.seller_name || ''}</small><br><br>
                     Estatus: <strong>no retirado</strong>. ¿Realizar <strong>reenvío</strong>?`, [
                    { cls: 'trk-btn-reenvia', txt: '✓ Sí, reenvío', fn: () => {
                        if (rutaDistinta) {
                            trkStatus('🗺️', '¿Cambiar ruta?',
                                `El paquete tiene una ruta diferente a <strong>${rutaNombreTracking}</strong>.<br><br>¿Asignarlo a la nueva ruta del tracking?`, [
                                { cls: 'trk-btn-reenvia', txt: '✓ Sí, cambiar ruta', fn: () => {
                                    const pkgCambiado = Object.assign({}, pkg, { ruta_id: rutaTracking });
                                    window.trackingApp.agregarPaqueteEscaneado(pkgCambiado, true);
                                    trkStatus('✅', `#${pkg.id} agregado con reenvío`, `<strong>${pkg.cliente}</strong><br><small style="color:rgba(255,255,255,.6)">Ruta actualizada</small>`, [
                                        { cls: 'trk-btn-retry',   txt: '🔄 Escanear otro', fn: trkAbrirCamara },
                                        { cls: 'trk-btn-dismiss', txt: 'Cerrar',           fn: trkCerrarCamara }
                                    ]);
                                }},
                                { cls: 'trk-btn-dismiss', txt: 'No, mantener ruta', fn: () => {
                                    window.trackingApp.agregarPaqueteEscaneado(pkg, true);
                                    trkStatus('✅', `#${pkg.id} agregado con reenvío`, `<strong>${pkg.cliente}</strong>`, [
                                        { cls: 'trk-btn-retry',   txt: '🔄 Escanear otro', fn: trkAbrirCamara },
                                        { cls: 'trk-btn-dismiss', txt: 'Cerrar',           fn: trkCerrarCamara }
                                    ]);
                                }}
                            ]);
                        } else {
                            window.trackingApp.agregarPaqueteEscaneado(pkg, true);
                            trkStatus('✅', `#${pkg.id} agregado con reenvío`, `<strong>${pkg.cliente}</strong>`, [
                                { cls: 'trk-btn-retry',   txt: '🔄 Escanear otro', fn: trkAbrirCamara },
                                { cls: 'trk-btn-dismiss', txt: 'Cerrar',           fn: trkCerrarCamara }
                            ]);
                        }
                    }},
                    { cls: 'trk-btn-retry', txt: 'Cancelar', fn: trkAbrirCamara }
                ]);
                return;
            }

            if (ELEGIBLES.includes(estatus)) {
                // Validar ruta: si hay ruta seleccionada y el paquete tiene ruta asignada diferente
                const rutaSeleccionada = document.getElementById('ruta_select')?.value;
                if (rutaSeleccionada && pkg.ruta_id && String(pkg.ruta_id) !== String(rutaSeleccionada)) {
                    trkStatus('⚠️', 'Ruta diferente',
                        `El paquete <strong>#${pkg.id}</strong> (${pkg.cliente}) no pertenece a la ruta seleccionada. ¿Incluirlo de todas formas?`, [
                        { cls: 'trk-btn-reenvia', txt: '✓ Incluir de todas formas', fn: () => {
                            window.trackingApp.agregarPaqueteEscaneado(pkg, false);
                            trkStatus('✅', `#${pkg.id} agregado`, `<strong>${pkg.cliente}</strong>`, [
                                { cls: 'trk-btn-retry',   txt: '🔄 Escanear otro', fn: trkAbrirCamara },
                                { cls: 'trk-btn-dismiss', txt: 'Cerrar',           fn: trkCerrarCamara }
                            ]);
                        }},
                        { cls: 'trk-btn-retry', txt: '← Cancelar', fn: trkAbrirCamara }
                    ]);
                    return;
                }
                window.trackingApp.agregarPaqueteEscaneado(pkg, false);
                trkStatus('✅', `#${pkg.id} agregado`, `<strong>${pkg.cliente}</strong>`, [
                    { cls: 'trk-btn-retry',   txt: '🔄 Escanear otro', fn: trkAbrirCamara },
                    { cls: 'trk-btn-dismiss', txt: 'Cerrar',           fn: trkCerrarCamara }
                ]);
                return;
            }

            trkStatus('⚠️', 'No disponible',
                `El paquete <strong>#${pkg.id}</strong> tiene estatus <strong>${estatus}</strong> y no puede agregarse al tracking.`, [
                { cls: 'trk-btn-retry',   txt: '🔄 Reintentar', fn: trkAbrirCamara },
                { cls: 'trk-btn-dismiss', txt: 'Cerrar',        fn: trkCerrarCamara }
            ]);

        } catch (e) {
            console.error(e);
            trkStatus('🔌', 'Error de conexión', 'No se pudo consultar el paquete. Verifica la conexión.', [
                { cls: 'trk-btn-retry',   txt: '🔄 Reintentar', fn: trkAbrirCamara },
                { cls: 'trk-btn-dismiss', txt: 'Cerrar',        fn: trkCerrarCamara }
            ]);
        }
    }
})();
</script>

<!-- ── Bootstrap Datepicker ── -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
<script>
(function () {
    var _cache  = {};
    var _active = {};

    function mkKey(d) {
        return d.getFullYear() + '-' +
               String(d.getMonth() + 1).padStart(2, '0') + '-' +
               String(d.getDate()).padStart(2, '0');
    }

    var $input = $('#fecha_tracking').datepicker({
        format:         'yyyy-mm-dd',
        language:       'es',
        autoclose:      true,
        todayHighlight: true,
        beforeShowDay: function (date) {
            var key = mkKey(date);
            if (_active[key]) {
                return { classes: 'has-pkgs', tooltip: _active[key] + ' paquete(s) pendiente(s)' };
            }
            return {};
        }
    });

    function loadMonth(year, month) {
        var ck = year + '-' + month;
        if (_cache[ck] !== undefined) {
            _active = _cache[ck];
            $input.datepicker('fill');
            return;
        }
        var from = year + '-' + String(month).padStart(2, '0') + '-01';
        var last = new Date(year, month, 0).getDate();
        var to   = year + '-' + String(month).padStart(2, '0') + '-' + String(last).padStart(2, '0');

        fetch('<?= base_url('tracking/fechas-paquetes') ?>?from=' + from + '&to=' + to)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                _cache[ck] = data;
                _active    = data;
                $input.datepicker('fill');
            });
    }

    $input
        .on('show', function () {
            var vd = $input.data('datepicker').viewDate;
            loadMonth(vd.getFullYear(), vd.getMonth() + 1);
        })
        .on('changeMonth', function (e) {
            loadMonth(e.date.getFullYear(), e.date.getMonth() + 1);
        });
})();
</script>

<?= $this->endSection() ?>
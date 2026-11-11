<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<?php
$tiposServicio = [
    1 => 'Punto fijo',
    2 => 'Personalizado',
    3 => 'Recolecta',
    4 => 'Casillero'
];

$totalPaquetes  = count($detalles);
$noRetirados    = 0;
$casilleros     = 0;
$pagadoVendedor = 0;
$exitosos       = 0;

foreach ($detalles as $d) {
    if ($d->status == 'no_retirado' || $d->status == 'recolecta_fallida') $noRetirados++;
    if ($d->status == 'en_casillero_externo') $casilleros++;
    if ($d->cliente_pago_directo ?? false) $pagadoVendedor++;
    if ($d->status == 'entregado') $exitosos++;
}

$porcentaje = $totalPaquetes > 0 ? round(($exitosos / $totalPaquetes) * 100) : 0;

$totalEfectivo = $tracking->efectivo ?? null;
$totalOtras    = $tracking->otras_cuentas ?? null;

function fmtMonto($v) {
    return $v === null ? '<span class="text-muted small">—</span>' : '$' . number_format($v, 2);
}
?>

<style>
/* ── Hero ── */
.tk-hero {
    background: linear-gradient(135deg, #0e1525 0%, #1d2744 60%, #263460 100%);
    color: #fff;
    border-radius: 12px;
    padding: 20px 20px 16px;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
}
.tk-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 80% 20%, rgba(90,120,255,.15) 0%, transparent 65%);
    pointer-events: none;
}
.tk-hero-id   { font-size: 1.6rem; font-weight: 900; letter-spacing: -1px; line-height: 1; }
.tk-hero-sub  { font-size: .78rem; color: rgba(255,255,255,.65); margin-top: 2px; }
.tk-hero-moto { font-size: 1rem; font-weight: 700; margin-top: 8px; }
.tk-hero-date { font-size: .82rem; color: rgba(255,255,255,.7); }
.tk-hero-actions { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
.tk-hero-actions .btn { font-size: .82rem; font-weight: 700; border-radius: 8px; padding: 7px 14px; }

/* ── Stats grid ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 16px;
}
@media (min-width: 576px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
@media (min-width: 768px) { .stats-grid { grid-template-columns: repeat(5, 1fr); } }

.stat-card {
    background: #fff;
    border-radius: 10px;
    padding: 12px 10px 10px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.07);
    border-top: 3px solid;
}
.stat-card.c-blue   { border-color: #3a5298; }
.stat-card.c-green  { border-color: #28a745; }
.stat-card.c-orange { border-color: #fd7e14; }
.stat-card.c-teal   { border-color: #17a2b8; }
.stat-card.c-red    { border-color: #dc3545; }
.stat-num  { font-size: 1.9rem; font-weight: 900; line-height: 1; }
.stat-lbl  { font-size: .7rem; color: #888; text-transform: uppercase; letter-spacing: .5px; margin-top: 4px; }

/* ── Progress ── */
.tk-progress-wrap { background:#fff; border-radius:10px; padding:14px 16px; box-shadow:0 2px 8px rgba(0,0,0,.07); margin-bottom:16px; }
.tk-progress-wrap .progress { height: 14px; border-radius: 8px; }

/* ── Section header ── */
.tk-section-hdr {
    display: flex; align-items: center; justify-content: space-between;
    margin: 20px 0 10px;
}
.tk-section-hdr h6 { font-weight: 800; font-size: .92rem; margin: 0; color: #1d2744; }

/* ── Desktop table tweaks ── */
.table-paquetes th { font-size: .78rem; white-space: nowrap; }
.table-paquetes td { font-size: .82rem; vertical-align: middle; }

/* ── Mobile package card ── */
.pkg-track-card {
    background: #fff;
    border-radius: 10px;
    padding: 12px 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,.07);
    margin-bottom: 10px;
    border-left: 4px solid #3a5298;
}
.pkg-track-card .ptc-top {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;
}
.pkg-track-card .ptc-id  { font-weight: 900; color: #1d2744; font-size: .9rem; }
.pkg-track-card .ptc-row { display: flex; justify-content: space-between; font-size: .8rem; margin-bottom: 3px; }
.pkg-track-card .ptc-lbl { color: #999; }
.pkg-track-card .ptc-val { font-weight: 600; color: #333; text-align: right; max-width: 60%; }
.pkg-track-card .ptc-note { font-size: .75rem; color: #888; margin-top: 6px; border-top: 1px solid #f0f0f0; padding-top: 5px; }

/* ── QR modal overlay ── */
#qr-overlay {
    position: fixed; inset: 0; z-index: 1060;
    background: rgba(0,0,0,.85);
    display: none; flex-direction: column;
    align-items: center; justify-content: flex-start;
    overflow-y: auto; padding: 20px 16px 40px;
}
#qr-overlay.active { display: flex; }
#qr-overlay-topbar {
    width: 100%; max-width: 600px;
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px;
}
#qr-overlay-topbar h5 { color: #fff; margin: 0; font-weight: 800; font-size: 1rem; }
#qr-overlay-topbar button {
    background: rgba(255,255,255,.15); color: #fff; border: none;
    border-radius: 8px; padding: 7px 14px; font-weight: 700; cursor: pointer;
}
.qr-item {
    background: #fff; border-radius: 12px;
    padding: 16px 16px 10px;
    margin-bottom: 16px; width: 100%; max-width: 280px;
    text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,.3);
}
.qr-item .qi-id     { font-weight: 900; color: #1d2744; font-size: 1rem; margin-bottom: 2px; }
.qr-item .qi-name   { font-size: .78rem; color: #666; margin-bottom: 8px; }
.qr-item .qi-code   { font-size: .7rem; color: #aaa; font-family: monospace; margin-top: 6px; }
#qr-items-grid {
    display: flex; flex-wrap: wrap; gap: 16px; justify-content: center; width: 100%;
}
</style>

<!-- ═══ HERO ═══ -->
<div class="tk-hero">
    <div class="d-flex align-items-start justify-content-between flex-wrap" style="gap:8px;">
        <div>
            <div class="tk-hero-id">Tracking #<?= esc($tracking->id) ?></div>
            <div class="tk-hero-sub">Creado el <?= date('d/m/Y H:i', strtotime($tracking->created_at)) ?></div>
            <div class="tk-hero-moto"><i class="fa-solid fa-motorcycle mr-1" style="color:#a0b4ff;"></i><?= esc($tracking->motorista_name ?? 'Sin motorista') ?></div>
            <div class="tk-hero-date"><i class="fa-solid fa-calendar-day mr-1"></i>Fecha de entrega: <?= date('d/m/Y', strtotime($tracking->date)) ?></div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
            <?= trackingHeaderBadge($tracking->status ?? 'asignado') ?>
            <div class="d-flex gap-2" style="gap:8px;flex-wrap:wrap;justify-content:flex-end;">
                <div class="text-right" style="background:rgba(255,255,255,.1);border-radius:8px;padding:6px 12px;">
                    <div style="font-size:.68rem;color:rgba(255,255,255,.6);">Efectivo</div>
                    <div style="font-weight:900;font-size:.95rem;"><?= fmtMonto($totalEfectivo) ?></div>
                </div>
                <div class="text-right" style="background:rgba(255,255,255,.1);border-radius:8px;padding:6px 12px;">
                    <div style="font-size:.68rem;color:rgba(255,255,255,.6);">Otras cuentas</div>
                    <div style="font-weight:900;font-size:.95rem;"><?= fmtMonto($totalOtras) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="tk-hero-actions">
        <a href="<?= base_url('tracking-pdf/' . $tracking->id) ?>" target="_blank" class="btn btn-light">
            <i class="fa-solid fa-file-pdf"></i> PDF
        </a>
        <a href="<?= base_url('tracking-labels/' . $tracking->id) ?>" target="_blank" class="btn btn-warning">
            <i class="fa-solid fa-print"></i> Imprimir viñetas (<?= $totalPaquetes ?>)
        </a>
        <button class="btn btn-info" onclick="abrirQrOverlay()">
            <i class="fa-solid fa-qrcode"></i> Ver QR de paquetes
        </button>
        <a href="<?= base_url('tracking') ?>" class="btn" style="background:rgba(255,255,255,.15);color:#fff;">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- ═══ STATS ═══ -->
<div class="stats-grid">
    <div class="stat-card c-blue">
        <div class="stat-num" style="color:#3a5298;"><?= $totalPaquetes ?></div>
        <div class="stat-lbl">Total</div>
    </div>
    <div class="stat-card c-green">
        <div class="stat-num" style="color:#28a745;"><?= $exitosos ?></div>
        <div class="stat-lbl">Exitosos</div>
    </div>
    <div class="stat-card c-orange">
        <div class="stat-num" style="color:#fd7e14;"><?= $noRetirados ?></div>
        <div class="stat-lbl">No retirados</div>
    </div>
    <div class="stat-card c-teal">
        <div class="stat-num" style="color:#17a2b8;"><?= $casilleros ?></div>
        <div class="stat-lbl">Casillero ext.</div>
    </div>
    <div class="stat-card c-red">
        <div class="stat-num" style="color:#dc3545;"><?= $pagadoVendedor ?></div>
        <div class="stat-lbl">Pago vendedor</div>
    </div>
</div>

<!-- ═══ PROGRESS ═══ -->
<div class="tk-progress-wrap">
    <div class="d-flex justify-content-between mb-2">
        <strong style="font-size:.88rem;">Progreso de entrega</strong>
        <span class="text-muted" style="font-size:.82rem;"><?= $exitosos ?> / <?= $totalPaquetes ?> exitosos · <?= $porcentaje ?>%</span>
    </div>
    <div class="progress">
        <div class="progress-bar bg-success" role="progressbar" style="width:<?= $porcentaje ?>%"></div>
    </div>
</div>

<!-- ═══ PAQUETES — TABLA DESKTOP ═══ -->
<div class="tk-section-hdr d-none d-md-flex">
    <h6><i class="fa-solid fa-boxes-stacked mr-1" style="color:#3a5298;"></i> Paquetes (<?= $totalPaquetes ?>)</h6>
</div>

<div class="d-none d-md-block table-responsive mb-4">
    <table class="table table-bordered table-sm table-paquetes">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Vendedor</th>
                <th>Cliente</th>
                <th>Destino / Recolección</th>
                <th>Estado</th>
                <th>Monto</th>
                <th>Cuenta</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($detalles)): ?>
                <?php foreach ($detalles as $d): ?>
                    <?php
                    $tipo = $tiposServicio[$d->tipo_servicio] ?? '?';
                    if ($d->tipo_servicio == 1) $destino = $d->puntofijo_nombre ?? '—';
                    elseif ($d->tipo_servicio == 2) $destino = $d->destino_personalizado ?: '—';
                    elseif ($d->tipo_servicio == 4) $destino = $d->puntofijo_nombre ?: 'Casillero';
                    else { $destino = null; $recolecta = $d->lugar_recolecta_paquete ?: '?'; $entrega = $d->destino_personalizado ?: '?'; }
                    ?>
                    <tr>
                        <td>
                            <span class="font-weight-bold">#<?= esc($d->package_id) ?></span>
                            <a href="<?= base_url('packages/show/'.$d->package_id) ?>" class="btn btn-xs btn-outline-primary ml-1" target="_blank" title="Ver paquete">
                                <i class="fa-solid fa-box"></i>
                            </a>
                            <a href="<?= base_url('tracking-label/'.$d->package_id) ?>" class="btn btn-xs btn-outline-warning ml-1" target="_blank" title="Imprimir viñeta">
                                <i class="fa-solid fa-tag"></i>
                            </a>
                        </td>
                        <td><?= esc($tipo) ?></td>
                        <td><?= esc($d->vendedor ?? '—') ?></td>
                        <td><?= esc($d->cliente ?? '—') ?></td>
                        <td>
                            <?php if ($d->tipo_servicio == 3): ?>
                                <small><strong>Recol:</strong> <?= esc($recolecta) ?><br><strong>Entrega:</strong> <?= esc($entrega) ?></small>
                            <?php else: ?>
                                <?= esc($destino) ?>
                            <?php endif; ?>
                        </td>
                        <td><?= trackingBadge($d->status) ?></td>
                        <td>
                            <?php if (empty($d->monto) || $d->monto == 0): ?>
                                <span class="text-danger">Cancelado</span>
                            <?php else: ?>
                                $<?= number_format($d->monto, 2) ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted"><?= esc($d->cuenta_nombre ?? '—') ?></td>
                    </tr>
                    <?php if (!empty($d->note)): ?>
                        <tr>
                            <td colspan="8" class="bg-light text-muted small">
                                <i class="fa-solid fa-comment-dots"></i> <?= esc($d->note) ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center text-muted">Sin paquetes</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- ═══ PAQUETES — CARDS MOBILE ═══ -->
<div class="tk-section-hdr d-md-none">
    <h6><i class="fa-solid fa-boxes-stacked mr-1" style="color:#3a5298;"></i> Paquetes (<?= $totalPaquetes ?>)</h6>
</div>
<div class="d-md-none">
    <?php if (!empty($detalles)): ?>
        <?php foreach ($detalles as $d): ?>
            <?php
            $tipo = $tiposServicio[$d->tipo_servicio] ?? '?';
            if ($d->tipo_servicio == 1) $destText = $d->puntofijo_nombre ?? '—';
            elseif ($d->tipo_servicio == 2) $destText = $d->destino_personalizado ?: '—';
            elseif ($d->tipo_servicio == 4) $destText = $d->puntofijo_nombre ?: 'Casillero';
            else $destText = 'Recol: '.($d->lugar_recolecta_paquete ?: '?').' → '.($d->destino_personalizado ?: '?');
            ?>
            <div class="pkg-track-card">
                <div class="ptc-top">
                    <span class="ptc-id">
                        #<?= esc($d->package_id) ?>
                        <a href="<?= base_url('packages/show/'.$d->package_id) ?>" target="_blank" class="btn btn-xs btn-outline-primary ml-1">
                            <i class="fa-solid fa-box" style="font-size:.7rem;"></i>
                        </a>
                        <a href="<?= base_url('tracking-label/'.$d->package_id) ?>" target="_blank" class="btn btn-xs btn-outline-warning ml-1" title="Imprimir viñeta">
                            <i class="fa-solid fa-tag" style="font-size:.7rem;"></i>
                        </a>
                    </span>
                    <?= trackingBadge($d->status) ?>
                </div>
                <div class="ptc-row"><span class="ptc-lbl">Vendedor</span><span class="ptc-val"><?= esc($d->vendedor ?? '—') ?></span></div>
                <div class="ptc-row"><span class="ptc-lbl">Cliente</span><span class="ptc-val"><?= esc($d->cliente ?? '—') ?></span></div>
                <div class="ptc-row"><span class="ptc-lbl">Tipo</span><span class="ptc-val"><?= esc($tipo) ?></span></div>
                <div class="ptc-row"><span class="ptc-lbl">Destino</span><span class="ptc-val"><?= esc($destText) ?></span></div>
                <div class="ptc-row">
                    <span class="ptc-lbl">Monto</span>
                    <span class="ptc-val">
                        <?= (empty($d->monto) || $d->monto == 0) ? '<span class="text-danger">Cancelado</span>' : '$'.number_format($d->monto,2) ?>
                    </span>
                </div>
                <?php if (!empty($d->cuenta_nombre)): ?>
                    <div class="ptc-row"><span class="ptc-lbl">Cuenta</span><span class="ptc-val"><?= esc($d->cuenta_nombre) ?></span></div>
                <?php endif; ?>
                <?php if (!empty($d->note)): ?>
                    <div class="ptc-note"><i class="fa-solid fa-comment-dots"></i> <?= esc($d->note) ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center text-muted">Sin paquetes</p>
    <?php endif; ?>
</div>

<!-- ═══ QR OVERLAY ═══ -->
<div id="qr-overlay">
    <div id="qr-overlay-topbar">
        <h5><i class="fa-solid fa-qrcode mr-2"></i>QR — Tracking #<?= esc($tracking->id) ?></h5>
        <button onclick="cerrarQrOverlay()">✕ Cerrar</button>
    </div>
    <div id="qr-items-grid">
        <?php foreach ($detalles as $i => $d):
            $qrVal = !empty($d->qr_code)
                ? $d->qr_code
                : str_pad(\App\Libraries\Base62Converter::encode((int)$d->package_id), 6, '0', STR_PAD_LEFT);
        ?>
            <div class="qr-item">
                <div class="qi-id">#<?= esc($d->package_id) ?></div>
                <div class="qi-name"><?= esc($d->cliente ?? '—') ?></div>
                <div id="qri-<?= $i ?>"></div>
                <div class="qi-code"><?= esc($qrVal) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
<?php
// Genera el valor QR para cada paquete — fallback al Base62 del ID si no hay código guardado
$qrItems = array_values(array_map(function ($i, $d) {
    $qr = !empty($d->qr_code)
        ? $d->qr_code
        : str_pad(\App\Libraries\Base62Converter::encode((int)$d->package_id), 6, '0', STR_PAD_LEFT);
    return ['idx' => $i, 'qr' => $qr, 'cliente' => $d->cliente ?? '—', 'pid' => $d->package_id];
}, array_keys($detalles), $detalles));
?>
const qrData = <?= json_encode($qrItems) ?>;
let qrGenerated = false;

function abrirQrOverlay() {
    document.getElementById('qr-overlay').classList.add('active');
    document.body.style.overflow = 'hidden';
    if (!qrGenerated) {
        qrGenerated = true;
        qrData.forEach(item => {
            if (!item.qr) return;
            const el = document.getElementById('qri-' + item.idx);
            if (!el) return;
            new QRCode(el, {
                text: item.qr, width: 160, height: 160,
                colorDark: '#000', colorLight: '#fff',
                correctLevel: QRCode.CorrectLevel.H
            });
        });
    }
}
function cerrarQrOverlay() {
    document.getElementById('qr-overlay').classList.remove('active');
    document.body.style.overflow = '';
}
document.getElementById('qr-overlay').addEventListener('click', function(e) {
    if (e.target === this) cerrarQrOverlay();
});
</script>

<?= $this->endSection() ?>

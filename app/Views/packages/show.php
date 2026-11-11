<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<style>
    /* ── Flete editor (Swal) ── */
    .flete-editor { text-align: left; padding: 10px 5px; }
    .flete-row    { margin-bottom: 12px; }
    .flete-label  { font-weight: 600; font-size: 0.9rem; color: #555; margin-bottom: 3px; }
    .flete-input  { width: 100%; padding: 6px 8px; border-radius: 6px; border: 1px solid #ced4da; font-size: 0.95rem; }
    .flete-input:focus { border-color: #007bff; outline: none; box-shadow: 0 0 3px rgba(0,123,255,.4); }
    .flete-preview { margin-top: 10px; padding: 8px; border-radius: 6px; background: #f8f9fa; font-size: 0.95rem; }
    .flete-preview strong { color: #dc3545; }
    .tracking-btn { transition: all .2s ease; }
    .tracking-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(0,0,0,.15); }
    .select2-container .select2-selection--single { height: 38px !important; border: 1px solid #ced4da; border-radius: .375rem; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px !important; padding-left: .75rem; }

    /* ── Secciones de la ficha ── */
    .pkg-section {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        margin-bottom: 16px;
        overflow: hidden;
    }
    .pkg-section-header {
        padding: 12px 16px;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        font-weight: 700;
        font-size: .88rem;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: .4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .pkg-section-body { padding: 14px 16px; }

    /* ── Filas de dato (dl alternativo) ── */
    .d-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
        padding: 7px 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: .9rem;
    }
    .d-row:last-child { border-bottom: none; }
    .d-lbl { color: #6c757d; font-weight: 600; flex-shrink: 0; min-width: 120px; font-size: .85rem; }
    .d-val { text-align: right; color: #212529; word-break: break-word; }

    /* ── Hero header ── */
    .pkg-hero {
        background: linear-gradient(135deg, #0e1525, #1d2744);
        border-radius: 14px;
        color: #fff;
        padding: 18px 20px;
        margin-bottom: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .pkg-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 10px;
    }
    .pkg-id   { font-size: 1.3rem; font-weight: 800; }
    .pkg-cli  { font-size: 1rem; opacity: .75; }
    .pkg-hero-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .pkg-hero-actions a,
    .pkg-hero-actions button {
        background: rgba(255,255,255,.12);
        color: #fff;
        border: 1px solid rgba(255,255,255,.22);
        border-radius: 9px;
        padding: 7px 14px;
        font-size: .82rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: background .15s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .pkg-hero-actions a:hover,
    .pkg-hero-actions button:hover { background: rgba(255,255,255,.22); color: #fff; }

    /* ── Foto ── */
    .pkg-foto {
        width: 100%; border-radius: 10px; object-fit: cover;
        max-height: 240px; cursor: pointer;
        border: 1px solid #e9ecef;
        transition: opacity .15s;
    }
    .pkg-foto:hover { opacity: .88; }

    /* ── Tracking móvil ── */
    .track-card {
        background: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        padding: 10px 14px;
        margin-bottom: 8px;
        font-size: .88rem;
    }
    .track-card:last-child { margin-bottom: 0; }
    .track-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
</style>
<?php
/**
 * Función auxiliar para formatear la fecha a día/mes/año (d/m/Y).
 * @param string|null $fecha
 * @return string
 */
function formatDateDMY($fecha)
{
    if (empty($fecha))
        return 'Pendiente';
    $d = new DateTime($fecha);
    return $d->format('d/m/Y');
}

// Asegúrate de que las funciones serviceLabel() y statusBadge() 
// estén definidas en tus Helpers o estén disponibles globalmente.
?>

<?php
$fotoFile = isset($package['foto']) ? $package['foto'] : null;
$fotoURL  = (!empty($fotoFile) && $fotoFile !== 'null')
    ? base_url('upload/paquetes/' . $fotoFile)
    : base_url('upload/no-image.png');
?>

<div class="container-fluid px-2 px-md-4 py-3">

    <!-- ══ HERO ══ -->
    <div class="pkg-hero">
        <div class="pkg-hero-top">
            <div>
                <div class="pkg-id">Paquete #<?= esc($package['id']) ?></div>
                <div class="pkg-cli"><?= esc($package['cliente']) ?></div>
            </div>
            <div style="display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                <?php if (!empty($package['estatus'])): ?>
                    <?= statusBadge($package['estatus']) ?>
                <?php endif; ?>
                <?php if (!empty($package['estatus2'])): ?>
                    <?= statusBadge($package['estatus2']) ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="pkg-hero-actions">
            <?php if (tienePermiso('editar_paquetes')): ?>
                <a href="<?= base_url('packages/edit/' . $package['id']) ?>">
                    <i class="fa-solid fa-pen"></i> Editar
                </a>
            <?php endif; ?>
            <a href="<?= base_url('packages/' . $package['id'] . '/label') ?>" target="_blank">
                <i class="fa-solid fa-print"></i> Viñeta
            </a>
            <a href="<?= base_url('packages') ?>">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row g-3">

        <!-- ══ COLUMNA IZQUIERDA ══ -->
        <div class="col-12 col-md-8 order-2 order-md-1">

            <!-- Información general -->
            <div class="pkg-section">
                <div class="pkg-section-header">
                    <i class="fa-solid fa-circle-info text-primary"></i> Información General
                </div>
                <div class="pkg-section-body">

                    <div class="d-row">
                        <span class="d-lbl">Cliente</span>
                        <span class="d-val fw-semibold"><?= esc($package['cliente']) ?></span>
                    </div>

                    <div class="d-row">
                        <span class="d-lbl">Vendedor</span>
                        <span class="d-val">
                            <span id="vendedorEdit"
                                data-id="<?= $package['id'] ?>"
                                data-vendedor="<?= $package['vendedor'] ?>"
                                data-nombre="<?= esc($package['seller_name']) ?>"
                                style="cursor:pointer;text-decoration:underline dotted;color:#0d6efd;">
                                <?= esc($package['seller_name']) ?>
                                <i class="fa-solid fa-pen-to-square fa-xs ms-1 text-muted"></i>
                            </span>
                        </span>
                    </div>

                    <div class="d-row">
                        <span class="d-lbl">Tipo servicio</span>
                        <span class="d-val"><?= serviceLabel($package['tipo_servicio']) ?></span>
                    </div>

                    <div class="d-row">
                        <span class="d-lbl">Monto</span>
                        <span class="d-val fw-bold">$<?= number_format($package['monto'], 2) ?></span>
                    </div>

                    <div class="d-row">
                        <span class="d-lbl">¿Es Frágil?</span>
                        <span class="d-val">
                            <?php if (!empty($package['fragil'])): ?>
                                <span class="badge badge-danger">SÍ</span>
                            <?php else: ?>
                                <span class="badge badge-success">NO</span>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="d-row">
                        <span class="d-lbl">Cobro en cuenta</span>
                        <span class="d-val">
                            <?php if (!empty($package['cliente_pago_directo'])): ?>
                                <span class="text-muted small">Pagado directo al vendedor</span>
                            <?php elseif (!empty($package['pago_cuenta_nombre'])): ?>
                                <span class="badge badge-info"><?= esc($package['pago_cuenta_nombre']) ?></span>
                            <?php else: ?>
                                <span class="badge badge-light">Pendiente</span>
                            <?php endif; ?>
                        </span>
                    </div>

                    <?php if (!empty($package['fecha_remu'])): ?>
                    <div class="d-row">
                        <span class="d-lbl">Pago vendedor</span>
                        <span class="d-val">
                            <?= formatDateDMY($package['fecha_remu']) ?>
                            &nbsp;
                            <?php if ($package['metodo_remu'] == 'caja'): ?>
                                <span class="badge badge-success">Caja</span>
                            <?php elseif ($package['metodo_remu'] == 'cuenta'): ?>
                                <span class="badge badge-primary">Cuenta</span>
                            <?php else: ?>
                                <?= esc($package['metodo_remu']) ?>
                            <?php endif; ?>
                            <span class="text-muted small d-block"><?= esc($package['remu_user_nombre'] ?? '') ?></span>
                        </span>
                    </div>
                    <?php endif; ?>

                    <?php if ($package['estatus'] === 'finalizado' && $package['estatus2'] === 'remunerado'): ?>
                        <?php if (tienePermiso('solicitar_reversion')): ?>
                        <div class="mt-2">
                            <?php if (!empty($solicitudPendiente)): ?>
                                <span class="badge badge-warning p-2">
                                    <i class="fa-solid fa-clock"></i> Solicitud en proceso
                                </span>
                            <?php else: ?>
                                <button id="btnRevertirPago"
                                    class="btn btn-sm btn-warning tracking-btn w-100"
                                    data-id="<?= $package['id'] ?>">
                                    <i class="fa-solid fa-rotate-left me-1"></i>Solicitar reversión de Pago
                                </button>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Flete y Pago -->
            <div class="pkg-section">
                <div class="pkg-section-header">
                    <i class="fa-solid fa-dollar-sign text-success"></i> Flete y Pago
                </div>
                <div class="pkg-section-body">

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <div class="text-muted small">Flete Total</div>
                            <div class="fw-bold fs-6">
                                <span id="fleteTotalEdit"
                                    class="editable-money"
                                    style="cursor:pointer;text-decoration:underline dotted;color:#0d6efd;"
                                    data-total="<?= $package['flete_total'] ?>"
                                    data-pagado="<?= $package['flete_pagado'] ?>"
                                    data-toggle="<?= $package['toggle_pago_parcial'] ?>"
                                    data-id="<?= $package['id'] ?>">
                                    $<?= number_format($package['flete_total'], 2) ?>
                                    <i class="fa-solid fa-pen-to-square fa-xs text-muted"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Pago Parcial</div>
                            <div id="badgePagoParcial">
                                <?= !empty($package['toggle_pago_parcial'])
                                    ? '<span class="badge badge-info">SÍ</span>'
                                    : '<span class="badge badge-light">NO</span>' ?>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="text-muted small">Pagado</div>
                            <div class="text-success fw-bold">
                                <span class="editable-money"
                                    data-field="flete_pagado"
                                    data-id="<?= $package['id'] ?>">
                                    $<?= number_format($package['flete_pagado'], 2) ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Pendiente</div>
                            <div class="text-danger fw-bold">
                                <strong id="fletePendiente">$<?= number_format($package['flete_pendiente'], 2) ?></strong>
                            </div>
                        </div>
                    </div>

                    <div class="d-row mt-2">
                        <span class="d-lbl">Reenvíos</span>
                        <span class="d-val text-success fw-bold"><?= number_format($package['reenvios']) ?></span>
                    </div>

                </div>
            </div>

            <!-- Destino y Logística -->
            <div class="pkg-section">
                <div class="pkg-section-header">
                    <i class="fa-solid fa-location-dot text-danger"></i> Destino y Logística
                </div>
                <div class="pkg-section-body">

                    <div class="d-row">
                        <span class="d-lbl">Fecha ingreso</span>
                        <span class="d-val"><?= formatDateDMY($package['fecha_ingreso']) ?></span>
                    </div>

                    <?php if ($package['tipo_servicio'] == 1): ?>
                        <div class="d-row"><span class="d-lbl">Punto Fijo</span><span class="d-val"><?= esc($package['point_name'] ?? 'N/A') ?></span></div>
                        <div class="d-row"><span class="d-lbl">Entrega estimada</span><span class="d-val"><?= formatDateDMY($package['fecha_entrega_puntofijo'] ?? null) ?></span></div>
                    <?php elseif ($package['tipo_servicio'] == 2): ?>
                        <div class="d-row"><span class="d-lbl">Destino</span><span class="d-val"><?= esc($package['destino_personalizado'] ?? 'N/A') ?></span></div>
                        <div class="d-row"><span class="d-lbl">Entrega estimada</span><span class="d-val"><?= formatDateDMY($package['fecha_entrega_personalizado'] ?? null) ?></span></div>
                        <div class="d-row"><span class="d-lbl">Ubicación</span><span class="d-val text-muted"><?= esc($package['ubicacion_completa'] ?? 'No definida') ?></span></div>
                    <?php elseif ($package['tipo_servicio'] == 3): ?>
                        <div class="d-row"><span class="d-lbl">Recolección</span><span class="d-val"><?= esc($package['lugar_recolecta_paquete'] ?? 'N/A') ?></span></div>
                        <div class="d-row"><span class="d-lbl">Destino final</span><span class="d-val"><?= esc($package['destino_entrega_final'] ?? 'Pendiente') ?></span></div>
                        <div class="d-row"><span class="d-lbl">Fecha entrega</span><span class="d-val"><?= esc($package['fecha_entrega_personalizado'] ?? 'Pendiente') ?></span></div>
                    <?php elseif ($package['tipo_servicio'] == 4): ?>
                        <div class="d-row"><span class="d-lbl">Casillero</span><span class="d-val"><?= esc($package['numero_casillero'] ?? 'N/A') ?></span></div>
                        <div class="d-row"><span class="d-lbl">Destino</span><span class="d-val"><?= esc($package['destino_personalizado'] ?? 'N/A') ?></span></div>
                    <?php endif; ?>

                    <?php if (!empty($package['external_location_nombre'])): ?>
                        <div class="d-row">
                            <span class="d-lbl">Casillero externo</span>
                            <span class="d-val"><span class="badge badge-info"><?= esc($package['external_location_nombre']) ?></span></span>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Tracking -->
            <?php if (!empty($trackingHistory)): ?>
            <div class="pkg-section">
                <div class="pkg-section-header">
                    <i class="fa-solid fa-route text-warning"></i> Historial de Seguimiento
                </div>
                <div class="pkg-section-body">

                    <!-- Tabla desktop -->
                    <div class="d-none d-md-block table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr><th>Tracking</th><th>Fecha</th><th>Motorista</th><th>Estado</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($trackingHistory as $t): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('tracking/' . $t->tracking_id) ?>" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-route"></i> #<?= $t->tracking_id ?>
                                        </a>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($t->tracking_date)) ?></td>
                                    <td><?= esc($t->motorista) ?></td>
                                    <td><?= trackingBadge($t->tracking_status) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tarjetas móvil -->
                    <div class="d-md-none">
                        <?php foreach ($trackingHistory as $t): ?>
                        <div class="track-card">
                            <div class="track-card-top">
                                <a href="<?= base_url('tracking/' . $t->tracking_id) ?>" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-route"></i> #<?= $t->tracking_id ?>
                                </a>
                                <?= trackingBadge($t->tracking_status) ?>
                            </div>
                            <div class="text-muted small"><?= esc($t->motorista) ?> &middot; <?= date('d/m/Y', strtotime($t->tracking_date)) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
            <?php endif; ?>

            <!-- Comentarios -->
            <div class="pkg-section">
                <div class="pkg-section-header">
                    <i class="fa-solid fa-comment text-secondary"></i> Comentarios y Tiempos
                </div>
                <div class="pkg-section-body">

                    <?php if (!empty($package['comentarios'])): ?>
                        <div class="alert alert-light border mb-3" style="border-radius:10px;font-size:.9rem;">
                            <?= esc($package['comentarios']) ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small mb-3">Sin comentarios</p>
                    <?php endif; ?>

                    <div class="d-row">
                        <span class="d-lbl">Cancelado previo</span>
                        <span class="d-val">
                            <?= !empty($package['nocobrar_pack_cancelado'])
                                ? '<span class="badge badge-warning">SÍ</span>'
                                : '<span class="badge badge-light">NO</span>' ?>
                        </span>
                    </div>

                    <?php if (!empty($package['cliente_pago_directo'])): ?>
                    <div class="d-row">
                        <span class="d-lbl">Pago directo</span>
                        <span class="d-val">
                            <span class="badge badge-success">Cliente pagó directo</span>
                            <?php if (!empty($package['fecha_cliente_pago'])): ?>
                                <span class="text-muted small d-block"><?= formatDateDMY($package['fecha_cliente_pago']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($package['motivo_no_cobro'])): ?>
                                <span class="text-muted small d-block"><?= esc($package['motivo_no_cobro']) ?></span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php endif; ?>

                    <div class="d-row">
                        <span class="d-lbl">Creado</span>
                        <span class="d-val"><?= formatDateDMY($package['created_at']) ?></span>
                    </div>
                    <div class="d-row">
                        <span class="d-lbl">Actualizado</span>
                        <span class="d-val"><?= formatDateDMY($package['updated_at']) ?></span>
                    </div>

                </div>
            </div>

        </div><!-- /col izquierda -->

        <!-- ══ COLUMNA DERECHA: foto + QR ══ -->
        <div class="col-12 col-md-4 order-1 order-md-2">

            <div class="pkg-section">
                <div class="pkg-section-header">
                    <i class="fa-solid fa-image text-secondary"></i> Foto del paquete
                </div>
                <div class="pkg-section-body text-center">

                    <img src="<?= esc($fotoURL) ?>" alt="Foto del Paquete"
                        class="pkg-foto"
                        data-toggle="modal" data-target="#modalFotoPaquete">
                    <p class="text-muted small mt-2 mb-0">Toca para ver en grande</p>

                    <?php if (!empty($package['qr_code'])): ?>
                    <div class="mt-3">
                        <div id="qrcode" class="d-inline-block p-2 bg-white border rounded shadow-sm"></div>
                        <p class="text-muted mt-1 small mb-0">
                            Código: <strong><?= esc($package['qr_code']) ?></strong>
                        </p>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div><!-- /col derecha -->

    </div><!-- /row -->

</div><!-- /container -->
<div class="modal fade" id="modalFotoPaquete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body p-0 text-center">
                <img src="<?= esc($fotoURL) ?>" alt="Foto ampliada" style="width: 100%; border-radius: 4px;">
            </div>

        </div>
    </div>
</div>
<script>
    //variables globales
    const puedeEditarFlete = <?= tienePermiso('editar_flete') ? 'true' : 'false' ?>;
    const puedeReasignarVendedor = <?= tienePermiso('reasignar_vendedor') ? 'true' : 'false' ?>;
</script>
<script>
    const btnRevertir = document.getElementById('btnRevertirPago')
    if (btnRevertir) {
        btnRevertir.addEventListener('click', async function() {
            const packageId = this.dataset.id

            // ── 1. Mostrar loading mientras carga el detalle ──
            Swal.fire({
                title: 'Cargando detalle del pago...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            })

            let detalle
            try {
                const res = await fetch(`<?= base_url('pagos/detalle-por-paquete/') ?>${packageId}`)
                detalle = await res.json()
            } catch (e) {
                Swal.fire('Error', 'No se pudo obtener el detalle del pago.', 'error')
                return
            }

            if (!detalle.success) {
                Swal.fire('Error', detalle.message, 'error')
                return
            }

            const {
                pago,
                paquetes
            } = detalle

            // ── 2. Construir tabla de paquetes ──
            const metodoBadge = pago.metodo === 'caja' ?
                '<span class="badge badge-success">Caja</span>' :
                '<span class="badge badge-primary">Cuenta</span>'

            const filasPaquetes = paquetes.map(p => {
                const monto = parseFloat(p.monto_original).toFixed(2)
                const pagado = parseFloat(p.monto_pagado).toFixed(2)
                const flete = parseFloat(p.flete_descontado).toFixed(2)
                const esOrigen = p.package_id == detalle.package_id_orig

                // Badge de tipo
                let tipoBadge = ''
                if (p.tipo === 'solo_flete') {
                    tipoBadge = `<span class="badge badge-info">Solo cobro flete: $${flete}</span>`
                } else if (p.tipo === 'con_descuento_flete') {
                    tipoBadge = `<span class="badge badge-warning">Pagado + descuento flete: $${flete}</span>`
                } else {
                    tipoBadge = `<span class="badge badge-light">Normal</span>`
                }

                // Resaltar el paquete que originó la solicitud
                const rowStyle = esOrigen ? 'background:#fff3cd;' : ''
                const origenBadge = esOrigen ?
                    `<span class="badge badge-warning ml-1" style="font-size:0.7rem;">Solicitado</span>` :
                    ''

                return `
        <tr style="${rowStyle}">
            <td>
                #${p.package_id}
                ${origenBadge}
            </td>
            <td>${p.cliente ?? '—'}</td>
            <td>
                <small class="text-muted d-block">Original: $${monto}</small>
                <strong>Pagado: $${pagado}</strong>
            </td>
            <td>${tipoBadge}</td>
        </tr>`
            }).join('')

            // ── 3. Mostrar Sweet Alert con detalle completo ──
            const {
                isConfirmed,
                value
            } = await Swal.fire({
                title: 'Solicitar reversión de pago',
                width: '600px',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Enviar solicitud',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#e0a800',
                html: `
                <div style="text-align:left; font-size:0.9rem;">

                    <div class="alert alert-warning mb-3" style="font-size:0.85rem;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <strong>Atención:</strong> Este paquete forma parte de un pago grupal.
                        La reversión afectará <strong>todos los paquetes listados abajo</strong>.
                    </div>

                    <div class="row mb-2">
                        <div class="col-6">
                            <small class="text-muted">Vendedor</small>
                            <div><strong>${pago.vendedor}</strong></div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Método de pago</small>
                            <div>${metodoBadge}</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <small class="text-muted">Total bruto</small>
                            <div><strong>$${parseFloat(pago.total_bruto).toFixed(2)}</strong></div>
                        </div>
                        <div class="col-4">
                            <small class="text-muted">Fletes descontados</small>
                            <div class="text-danger"><strong>-$${parseFloat(pago.total_flete).toFixed(2)}</strong></div>
                        </div>
                        <div class="col-4">
                            <small class="text-muted">Neto pagado</small>
                            <div class="text-success"><strong>$${parseFloat(pago.total_neto).toFixed(2)}</strong></div>
                        </div>
                    </div>

                    <table class="table table-sm table-bordered mb-3">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${filasPaquetes}
                        </tbody>
                    </table>

                    <div style="margin-bottom:12px;">
                        <label style="font-weight:600; font-size:0.9rem; color:#555;">
                            Motivo de la solicitud
                        </label>
                        <textarea id="motivoReversion"
                            class="swal2-textarea"
                            placeholder="Describe el motivo de la reversión..."
                            style="width:90%; margin-top:4px; resize:vertical;"></textarea>
                    </div>

                    <div>
                        <label style="font-weight:600; font-size:0.9rem; color:#555;">
                            Confirma tu contraseña
                        </label>
                        <input id="passwordReversion"
                            type="password"
                            class="swal2-input"
                            placeholder="Tu contraseña"
                            style="width:90%; margin-top:4px;">
                    </div>

                </div>
            `,
                preConfirm: () => {
                    const motivo = document.getElementById('motivoReversion').value.trim()
                    const password = document.getElementById('passwordReversion').value.trim()

                    if (!motivo) {
                        Swal.showValidationMessage('El motivo es obligatorio')
                        return false
                    }
                    if (!password) {
                        Swal.showValidationMessage('Debes confirmar tu contraseña')
                        return false
                    }

                    return {
                        motivo,
                        password
                    }
                }
            })

            if (!isConfirmed) return

            // ── 4. Enviar solicitud ──
            try {
                const res = await fetch("<?= base_url('solicitudes/store') ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        package_id: packageId,
                        motivo: value.motivo,
                        password: value.password
                    })
                })
                const data = await res.json()

                if (data.status !== 'ok') {
                    Swal.fire('Error', data.message, 'error')
                    return
                }

                Swal.fire(
                    'Solicitud enviada',
                    'Se notificará a los administradores para revisar el pago completo.',
                    'success'
                ).then(() => location.reload())

            } catch (e) {
                Swal.fire('Error', 'No se pudo enviar la solicitud.', 'error')
            }
        })
    }
    document.getElementById('togglePagoParcial').addEventListener('change', function() {

        const id = this.dataset.id
        const value = this.value

        Swal.fire({
            title: 'Confirmar cambio',
            text: '¿Deseas actualizar la configuración de pago parcial?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar'
        }).then((result) => {

            if (!result.isConfirmed) {
                location.reload()
                return
            }

            fetch("<?= base_url('packages/updatePagoParcial') ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id,
                        toggle: value
                    })
                })
                .then(r => r.json())
                .then(data => {

                    if (data.status === 'ok') {

                        document.querySelector('[data-field="flete_pagado"]').innerText = '$' + data.pagado.toFixed(2)

                        document.getElementById('fletePendiente')
                            .innerText = '$' + data.pendiente.toFixed(2)

                        Swal.fire('Actualizado', '', 'success')
                    }

                })

        })

    })
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const vendedorBtn = document.getElementById('vendedorEdit')
        if (!vendedorBtn) return

        vendedorBtn.addEventListener('click', function() {

            if (!puedeReasignarVendedor) {
                Swal.fire('Sin permiso', 'No puedes reasignar el vendedor', 'error')
                return
            }

            const id = this.dataset.id
            const vendedorActual = this.dataset.vendedor
            const nombreActual = this.dataset.nombre

            Swal.fire({
                title: 'Reasignar vendedor',

                html: `
                <div style="text-align:left">

                    <div style="margin-bottom:10px;">
                        <strong>Vendedor actual:</strong><br>
                        <span style="color:#007bff">${nombreActual}</span>
                    </div>

                    <div style="margin-bottom:10px; color:#dc3545;">
                        ⚠️ Cambiar el vendedor puede afectar reportes y comisiones.
                    </div>

                    <label>Nuevo vendedor</label>
                    <select id="editVendedor" style="width:100%"></select>

                </div>
            `,

                showCancelButton: true,
                confirmButtonText: 'Guardar',

                didOpen: () => {

                    $('#editVendedor').select2({
                        dropdownParent: $('.swal2-container'),
                        ajax: {
                            url: "<?= base_url('sellers-search') ?>",
                            dataType: 'json',
                            delay: 250,
                            data: params => ({
                                q: params.term
                            }),

                            processResults: function(data) {
                                return {
                                    results: data
                                }
                            }
                        },
                        placeholder: 'Buscar vendedor...',
                        minimumInputLength: 1
                    })

                    const option = new Option(nombreActual, vendedorActual, true, true)
                    $('#editVendedor').append(option).trigger('change')
                },

                preConfirm: () => {

                    const vendedor = $('#editVendedor').val()

                    if (!vendedor) {
                        Swal.showValidationMessage('Debe seleccionar un vendedor')
                        return false
                    }

                    if (vendedor == vendedorActual) {
                        Swal.showValidationMessage('Debe seleccionar un vendedor diferente')
                        return false
                    }

                    return {
                        vendedor
                    }
                }

            }).then(result => {

                if (!result.isConfirmed) return

                // 🔥 SEGUNDA CONFIRMACIÓN
                Swal.fire({
                    title: 'Confirmación final',
                    html: `
            <div style="text-align:left">
                <p>Estás a punto de cambiar el vendedor:</p>

                <p><strong>De:</strong> ${nombreActual}</p>
                <p><strong>A:</strong> ${$('#editVendedor option:selected').text()}</p>

                <br>
                <span style="color:#dc3545">
                    ⚠️ Esta acción puede afectar reportes, comisiones y pagos.
                </span>
            </div>
        `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, cambiar vendedor',
                    cancelButtonText: 'Cancelar'
                }).then(confirm2 => {

                    if (!confirm2.isConfirmed) return

                    // 🚀 AHORA SÍ ENVÍA
                    fetch("<?= base_url('packages/updateVendedor') ?>", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: id,
                                vendedor: result.value.vendedor
                            })
                        })
                        .then(r => r.json())
                        .then(data => {

                            if (data.status !== 'ok') {
                                Swal.fire('Error', data.message, 'error')
                                return
                            }

                            Swal.fire('Actualizado', 'Vendedor reasignado correctamente', 'success')
                                .then(() => location.reload())
                        })

                })

            })
        })

    })

    document.getElementById('fleteTotalEdit').addEventListener('click', function() {
        if (!puedeEditarFlete) {

            Swal.fire({
                icon: 'error',
                title: 'Sin permiso',
                text: 'No tienes permiso para editar el flete.'
            });

            return; // 🚫 IMPORTANTE: corta ejecución
        }
        const id = this.dataset.id
        const total = parseFloat(this.dataset.total)
        const pagado = parseFloat(this.dataset.pagado)
        const toggle = parseInt(this.dataset.toggle)

        Swal.fire({

            title: 'Editar Flete',

            html: `
                <div class="flete-editor">

                <div class="flete-row">
                <div class="flete-label">Total del flete</div>
                <input id="editTotal" type="number"
                step="0.01"
                class="flete-input"
                value="${total}">
                </div>

                <div class="flete-row">
                <div class="flete-label">Pago parcial</div>
                <select id="editToggle" class="flete-input">
                <option value="0" ${toggle==0?'selected':''}>Pago completo</option>
                <option value="1" ${toggle==1?'selected':''}>Pago parcial</option>
                </select>
                </div>

                <div class="flete-row">
                <div class="flete-label">Monto pagado</div>
                <input id="editPagado" type="number"
                step="0.01"
                class="flete-input"
                value="${pagado}">
                </div>

                <div class="flete-preview">
                Pendiente por cobrar:
                <strong>$<span id="previewPendiente">0.00</span></strong>
                </div>

                </div>
                `,

            didOpen: () => {

                const totalInput = document.getElementById('editTotal')
                const pagadoInput = document.getElementById('editPagado')
                const toggleInput = document.getElementById('editToggle')
                const pendientePreview = document.getElementById('previewPendiente')

                function recalcular() {

                    let total = parseFloat(totalInput.value) || 0
                    let pagado = parseFloat(pagadoInput.value) || 0
                    let toggle = parseInt(toggleInput.value)

                    if (toggle == 0) {

                        pagadoInput.value = total
                        pagadoInput.disabled = true

                        pendientePreview.innerText = '$0.00'

                    } else {

                        pagadoInput.disabled = false

                        let pendiente = total - pagado
                        if (pendiente < 0) pendiente = 0

                        pendientePreview.innerText = '$' + pendiente.toFixed(2)

                    }

                }

                totalInput.addEventListener('input', recalcular)
                pagadoInput.addEventListener('input', recalcular)
                toggleInput.addEventListener('change', recalcular)

                recalcular()

            },

            showCancelButton: true,
            confirmButtonText: 'Guardar',

            preConfirm: () => {

                const total = parseFloat(document.getElementById('editTotal').value)
                const toggle = parseInt(document.getElementById('editToggle').value)
                const pagado = parseFloat(document.getElementById('editPagado').value)

                if (pagado > total) {

                    Swal.showValidationMessage(
                        'El pagado no puede ser mayor al total'
                    )

                    return false
                }

                return {
                    total,
                    toggle,
                    pagado
                }

            }

        }).then((result) => {

            if (!result.isConfirmed) return

            fetch("<?= base_url('packages/updateFleteCompleto') ?>", {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json'
                    },

                    body: JSON.stringify({

                        id: id,
                        total: result.value.total,
                        toggle: result.value.toggle,
                        pagado: result.value.pagado

                    })

                })
                .then(r => r.json())
                .then(data => {

                    if (data.status !== 'ok') {
                        Swal.fire('Error', data.message, 'error')
                        return
                    }

                    location.reload()
                })

        })

    })
</script>

<?php if (!empty($package['qr_code'])): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById('qrcode'), {
        text: '<?= esc($package['qr_code']) ?>',
        width: 150,
        height: 150,
        colorDark: '#1d2744',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });
</script>
<?php endif; ?>

<?= $this->endSection() ?>
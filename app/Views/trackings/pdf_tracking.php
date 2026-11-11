<?php
$tiposServicio = [
    1 => 'Punto fijo',
    2 => 'Personalizado',
    3 => 'Recolecta',
    4 => 'Casillero'
];

$totalPaquetes  = count($detalles);
$exitosos       = 0;
$noRetirados    = 0;
$recolectados   = 0;
$casilleros     = 0;
$cancelados     = 0;

foreach ($detalles as $d) {
    if ($d->status === 'entregado')                                        $exitosos++;
    if ($d->status === 'no_retirado' || $d->status === 'recolecta_fallida') $noRetirados++;
    if ($d->status === 'recolectado')                                      $recolectados++;
    if ($d->status === 'en_casillero_externo')                             $casilleros++;
    if (($d->monto ?? 0) == 0)                                            $cancelados++;
}
$porcentaje = $totalPaquetes > 0 ? round(($exitosos / $totalPaquetes) * 100) : 0;
$pctFilled  = max(1, $porcentaje);
$pctEmpty   = 100 - $pctFilled;

function trackingStatusBadge($s) {
    $map = [
        'entregado'               => ['Entregado',        '#065f24', '#d1fae5'],
        'no_retirado'             => ['No retirado',      '#7c1f1f', '#fee2e2'],
        'recolectado'             => ['Recolectado',      '#7c4f1a', '#fef3c7'],
        'recolecta_fallida'       => ['Recol. fallida',   '#7c1f1f', '#fee2e2'],
        'asignado'                => ['Asignado',         '#1e3a5f', '#dbeafe'],
        'asignado_para_entrega'   => ['Para entrega',     '#1e3a5f', '#dbeafe'],
        'asignado_para_recolecta' => ['Para recolecta',   '#374151', '#e5e7eb'],
        'en_casillero_externo'    => ['Casillero ext.',   '#1a4760', '#cffafe'],
    ];
    if (isset($map[$s])) {
        [$label, $fg, $bg] = $map[$s];
    } else {
        $label = str_replace('_', ' ', ucfirst($s));
        $fg = '#374151'; $bg = '#f3f4f6';
    }
    return "<span style='background-color:{$bg};color:{$fg};padding:2px 6px;border-radius:3px;font-weight:bold;font-size:7.5pt;'>{$label}</span>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Tracking #<?= $tracking->id ?></title>
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 9pt;
    color: #111;
    margin: 0;
    padding: 0;
}

/* ── Encabezado ── */
.hdr-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #0e1525;
    border-radius: 4px;
    margin-bottom: 7px;
}
.hdr-table td { padding: 7px 10px; color: #fff; vertical-align: middle; }
.hdr-id   { font-size: 15pt; font-weight: bold; letter-spacing: -0.5px; white-space: nowrap; }
.hdr-badge-asignado   { background-color: #3a5298; color: #fff; padding: 2px 10px; border-radius: 10px; font-size: 7.5pt; font-weight: bold; }
.hdr-badge-finalizado { background-color: #1b7c3c; color: #fff; padding: 2px 10px; border-radius: 10px; font-size: 7.5pt; font-weight: bold; }
.hdr-meta { font-size: 7.5pt; color: #aac8ff; }
.hdr-meta strong { color: #fff; }

/* ── Stats ── */
.stats-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 4px 0;
    margin-bottom: 6px;
}
.stats-table td {
    text-align: center;
    padding: 5px 4px;
    border-radius: 4px;
    border-top-width: 3px;
    border-top-style: solid;
    background-color: #fff;
    border: 1px solid #e5e7eb;
}
.stat-num { font-size: 14pt; font-weight: bold; line-height: 1.1; }
.stat-lbl { font-size: 6.5pt; color: #666; }

/* ── Barra de progreso (tabla de 2 celdas) ── */
.prog-outer {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 2px;
}
.prog-outer td { padding: 0; height: 9px; }
.prog-filled { background-color: #28a745; }
.prog-empty  { background-color: #e5e7eb; }
.prog-label  { font-size: 7pt; color: #666; text-align: right; margin-bottom: 7px; }

/* ── Título de sección ── */
.section-title {
    font-size: 9pt;
    font-weight: bold;
    color: #0e1525;
    border-bottom: 2px solid #0e1525;
    padding-bottom: 2px;
    margin-bottom: 5px;
}

/* ── Tabla de paquetes ── */
.pkg-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 8pt;
}
.pkg-table th {
    background-color: #1d2744;
    color: #fff;
    font-weight: bold;
    padding: 5px 6px;
    text-align: left;
    white-space: nowrap;
}
.pkg-table td {
    padding: 5px 6px;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: top;
}
.pkg-table tr.even td { background-color: #f9fafb; }
.pkg-table tr.note-row td {
    background-color: #f1f5f9;
    font-style: italic;
    color: #555;
    font-size: 7.5pt;
    padding: 2px 6px 3px 16px;
    border-bottom: 1px solid #e5e7eb;
}

.cancelled { color: #dc3545; font-weight: bold; }
.direct-pay { color: #dc3545; font-size: 7pt; }

/* ── Footer ── */
.footer {
    text-align: center;
    font-size: 7.5pt;
    color: #aaa;
    margin-top: 10px;
    border-top: 1px solid #e5e7eb;
    padding-top: 4px;
}
</style>
</head>
<body>

<!-- ══ ENCABEZADO ══ -->
<?php
$st = $tracking->status ?? 'asignado';
$stBadgeClass = $st === 'finalizado' ? 'hdr-badge-finalizado' : 'hdr-badge-asignado';
$stLabel      = $st === 'finalizado' ? 'Finalizado' : 'Asignado';
?>
<table class="hdr-table">
    <tr>
        <td style="width:auto;">
            <span class="hdr-id">Tracking #<?= $tracking->id ?></span>
            &nbsp;&nbsp;<span class="<?= $stBadgeClass ?>"><?= $stLabel ?></span>
        </td>
        <td style="text-align:right;" class="hdr-meta">
            <strong>Motorista:</strong> <?= esc($tracking->motorista_name ?? 'N/A') ?> &nbsp;|&nbsp;
            <strong>Entrega:</strong> <?= date('d/m/Y', strtotime($tracking->date)) ?> &nbsp;|&nbsp;
            <strong>Creado:</strong> <?= date('d/m/Y H:i', strtotime($tracking->created_at)) ?>
            <?php if (!empty($tracking->efectivo) || !empty($tracking->otras_cuentas)): ?>
                &nbsp;|&nbsp;<strong>Efectivo:</strong> $<?= number_format($tracking->efectivo ?? 0, 2) ?>
                &nbsp;|&nbsp;<strong>Otras ctss:</strong> $<?= number_format($tracking->otras_cuentas ?? 0, 2) ?>
            <?php endif; ?>
        </td>
    </tr>
</table>

<!-- ══ STATS (tabla de 6 celdas) ══ -->
<table class="stats-table">
    <tr>
        <td style="border-top:3px solid #3a5298;">
            <div class="stat-num" style="color:#3a5298;"><?= $totalPaquetes ?></div>
            <div class="stat-lbl">Total</div>
        </td>
        <td style="border-top:3px solid #28a745;">
            <div class="stat-num" style="color:#28a745;"><?= $exitosos ?></div>
            <div class="stat-lbl">Entregados</div>
        </td>
        <td style="border-top:3px solid #e57c00;">
            <div class="stat-num" style="color:#e57c00;"><?= $recolectados ?></div>
            <div class="stat-lbl">Recolectados</div>
        </td>
        <td style="border-top:3px solid #dc3545;">
            <div class="stat-num" style="color:#dc3545;"><?= $noRetirados ?></div>
            <div class="stat-lbl">No retirados</div>
        </td>
        <td style="border-top:3px solid #17a2b8;">
            <div class="stat-num" style="color:#17a2b8;"><?= $casilleros ?></div>
            <div class="stat-lbl">Casillero ext.</div>
        </td>
        <td style="border-top:3px solid #6c757d;">
            <div class="stat-num" style="color:#6c757d;"><?= $cancelados ?></div>
            <div class="stat-lbl">Cancelados</div>
        </td>
    </tr>
</table>


<!-- ══ TABLA PAQUETES ══ -->
<div class="section-title">Paquetes (<?= $totalPaquetes ?>)</div>
<table class="pkg-table">
    <thead>
        <tr>
            <th style="width:5%;">ID</th>
            <th style="width:8%;">Tipo</th>
            <th style="width:14%;">Vendedor</th>
            <th style="width:14%;">Cliente</th>
            <th style="width:21%;">Destino / Recolección</th>
            <th style="width:13%;">Estado</th>
            <th style="width:8%;">Monto</th>
            <th style="width:17%;">Flete / Cuenta</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($detalles)): ?>
            <?php $rowIdx = 0; foreach ($detalles as $d): ?>
                <?php
                $rowClass = ($rowIdx % 2 === 1) ? 'even' : '';
                $rowIdx++;

                $tipo = $tiposServicio[$d->tipo_servicio] ?? '?';

                if ($d->tipo_servicio == 1)      $destino = esc($d->puntofijo_nombre ?? '—');
                elseif ($d->tipo_servicio == 2)  $destino = esc($d->destino_personalizado ?: '—');
                elseif ($d->tipo_servicio == 4)  $destino = esc($d->puntofijo_nombre ?: 'Casillero');
                else {
                    $r = esc($d->lugar_recolecta_paquete ?: '?');
                    $e = esc($d->destino_personalizado ?: '?');
                    $destino = "Recol: {$r}<br>Entregar: {$e}";
                }

                // Monto
                if (($d->monto ?? 0) == 0) {
                    $montoHtml = '<span class="cancelled">Cancelado</span>';
                } else {
                    $montoHtml = '$' . number_format($d->monto, 2);
                }

                // Flete + cuenta
                $fleteHtml = '';
                if (!empty($d->flete_total) && $d->flete_total > 0) {
                    if ($d->toggle_pago_parcial) {
                        $fleteHtml = 'Parc. $' . number_format($d->flete_pagado, 2) . ' / $' . number_format($d->flete_total, 2);
                    } else {
                        $fleteHtml = '$' . number_format($d->flete_total, 2);
                    }
                }
                if (!empty($d->cuenta_nombre)) {
                    $fleteHtml .= ($fleteHtml ? '<br>' : '') .
                        '<span style="color:#666;font-size:7.5pt;">' . esc($d->cuenta_nombre) . '</span>';
                }
                $fleteHtml = $fleteHtml ?: '—';
                ?>
                <tr class="<?= $rowClass ?>">
                    <td><strong><?= esc($d->package_id) ?></strong></td>
                    <td><?= esc($tipo) ?></td>
                    <td><?= esc($d->vendedor ?? '—') ?></td>
                    <td>
                        <strong><?= esc($d->cliente ?? '—') ?></strong>
                        <?php if (!empty($d->cliente_pago_directo)): ?>
                            <br><span class="direct-pay">Pagó a vendedor</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $destino ?></td>
                    <td><?= trackingStatusBadge($d->status) ?></td>
                    <td><?= $montoHtml ?></td>
                    <td><?= $fleteHtml ?></td>
                </tr>
                <?php if (!empty($d->note)): $rowIdx++; ?>
                    <tr class="note-row">
                        <td colspan="8">&#128221; <?= esc($d->note) ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8" style="text-align:center;color:#999;padding:12px;">Sin paquetes registrados</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    FC Encomiendas &nbsp;·&nbsp; Generado el <?= date('d/m/Y H:i:s') ?>
</div>

</body>
</html>

<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>

<style>
/* ── Hero ── */
.tk-hero {
    background: linear-gradient(135deg, #0e1525 0%, #1d2744 100%);
    border-radius: 10px;
    padding: 20px 24px;
    margin-bottom: 20px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 16px;
}
.tk-hero-icon {
    width: 48px; height: 48px;
    background: rgba(255,255,255,.12);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}
.tk-hero h4 { margin: 0; font-size: 1.15rem; font-weight: 700; }
.tk-hero p  { margin: 0; font-size: .8rem; color: #aac8ff; }

/* ── Filtros ── */
.filter-panel {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 16px 20px;
    margin-bottom: 18px;
}
.filter-panel label {
    font-weight: 600; font-size: 11px;
    color: #6c757d; text-transform: uppercase;
    letter-spacing: .4px; margin-bottom: 4px; display: block;
}

/* ── Tabla desktop ── */
.trk-table { font-size: 13.5px; }
.trk-table thead th {
    background: #1d2744; color: #fff;
    font-size: 11px; text-transform: uppercase;
    letter-spacing: .4px; padding: 10px 12px;
    border: none; white-space: nowrap;
}
.trk-table tbody td { padding: 10px 12px; vertical-align: middle; border-color: #f0f0f0; }
.trk-table tbody tr:hover td { background: #f8faff; }

.trk-id    { font-weight: 700; color: #1d2744; font-size: 14px; }
.trk-date-sep td {
    background: #f1f5f9 !important;
    color: #3a5298; font-weight: 700;
    font-size: 11px; letter-spacing: .3px;
    padding: 6px 12px !important;
    border-top: 2px solid #dbe4f0 !important;
}

/* ── Badges de estado ── */
.tk-badge {
    display: inline-block; padding: 3px 10px;
    border-radius: 20px; font-size: 11px; font-weight: 700;
}
.tk-badge-asignado   { background: #dbeafe; color: #1e3a5f; }
.tk-badge-finalizado { background: #d1fae5; color: #065f24; }

/* ── Botones de acción directo ── */
.trk-actions .btn { padding: 3px 8px; font-size: 12px; }

/* ── Cards mobile ── */
.trk-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 14px 16px;
    margin-bottom: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.trk-card-top {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 8px;
}
.trk-card-id { font-weight: 700; font-size: 15px; color: #1d2744; }
.trk-card-row {
    display: flex; justify-content: space-between;
    font-size: 12.5px; padding: 3px 0;
    border-bottom: 1px solid #f3f4f6;
}
.trk-card-row:last-child { border-bottom: none; }
.trk-card-lbl { color: #9ca3af; font-size: 11px; min-width: 70px; }
.trk-card-val { color: #1d2744; font-weight: 500; text-align: right; }
.trk-card-actions { margin-top: 10px; display: flex; gap: 6px; }
.trk-card-actions .btn { flex: 1; font-size: 12px; padding: 5px; }

/* ── Paginación ── */
.pagination .page-item.active .page-link { background: #1d2744; border-color: #1d2744; }
.pagination .page-link { color: #1d2744; }
</style>

<?php
function tkBadge($status) {
    if ($status === 'finalizado') return '<span class="tk-badge tk-badge-finalizado">Finalizado</span>';
    return '<span class="tk-badge tk-badge-asignado">Asignado</span>';
}
?>

<!-- ── Hero ── -->
<div class="tk-hero">
    <div class="tk-hero-icon"><i class="fa-solid fa-route"></i></div>
    <div class="flex-grow-1">
        <h4>Trackings</h4>
        <p>Seguimiento de entregas por motorista</p>
    </div>
    <?php if (tienePermiso('crear_tracking')): ?>
        <a href="<?= base_url('tracking/new') ?>" class="btn btn-warning btn-sm font-weight-bold">
            <i class="fa-solid fa-plus mr-1"></i> Nuevo
        </a>
    <?php endif; ?>
</div>

<!-- ── Filtros ── -->
<div class="filter-panel">
    <form method="GET" action="<?= base_url('tracking') ?>">
        <div class="row">
            <div class="col-6 col-md-3 mb-3">
                <label><i class="fa-solid fa-user-tie mr-1"></i> Motorista</label>
                <select name="motorista_id" id="filter_motorista" class="form-control form-control-sm">
                    <option value="">Todos</option>
                    <?php foreach ($motoristas as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= ($filter_motorista_id == $m['id']) ? 'selected' : '' ?>>
                            <?= esc($m['user_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <label><i class="fa-solid fa-route mr-1"></i> Ruta</label>
                <select name="ruta_id" id="filter_ruta" class="form-control form-control-sm">
                    <option value="">Todas</option>
                    <?php foreach ($rutas as $r): ?>
                        <option value="<?= $r->id ?>" <?= ($filter_ruta_id == $r->id) ? 'selected' : '' ?>>
                            <?= esc($r->route_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-6 col-md-2 mb-3">
                <label><i class="fa-solid fa-layer-group mr-1"></i> Estado</label>
                <select class="form-control form-control-sm js-status-select" name="status[]" multiple>
                    <?php foreach ($statusList as $st): ?>
                        <option value="<?= $st ?>" <?= (!empty($filter_status) && in_array($st, $filter_status)) ? 'selected' : '' ?>>
                            <?= ucfirst($st) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-6 col-md-2 mb-3">
                <label><i class="fa-solid fa-hashtag mr-1"></i> ID</label>
                <input type="text" name="search_id" class="form-control form-control-sm" placeholder="Ej: 123" value="<?= esc($filter_search_id) ?>">
            </div>

            <div class="col-6 col-md-1 mb-3">
                <label><i class="fa-solid fa-calendar-day mr-1"></i> Desde</label>
                <input type="date" name="date_from" class="form-control form-control-sm" value="<?= esc($filter_date_from) ?>">
            </div>

            <div class="col-6 col-md-1 mb-3">
                <label><i class="fa-solid fa-calendar-day mr-1"></i> Hasta</label>
                <input type="date" name="date_to" class="form-control form-control-sm" value="<?= esc($filter_date_to) ?>">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2" style="gap:8px;">
            <a href="<?= base_url('tracking') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-eraser mr-1"></i> Limpiar
            </a>
            <button type="submit" class="btn btn-sm btn-primary px-4">
                <i class="fa-solid fa-magnifying-glass mr-1"></i> Filtrar
            </button>
        </div>
    </form>
</div>

<!-- ── Tabla (desktop) ── -->
<div class="d-none d-md-block table-responsive">
    <table class="table table-bordered trk-table">
        <thead>
            <tr>
                <th style="width:70px;">ID</th>
                <th>Motorista</th>
                <th>Ruta</th>
                <th style="width:110px;">Fecha</th>
                <th style="width:110px;">Estado</th>
                <th style="width:160px;" class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($trackings)): ?>
                <?php
                $currentDate = null;
                foreach ($trackings as $t):
                    $fmtDate = date('d/m/Y', strtotime($t->date));
                    if ($currentDate !== $fmtDate):
                        $currentDate = $fmtDate;
                ?>
                    <tr class="trk-date-sep">
                        <td colspan="6">
                            <i class="fa-solid fa-calendar-check mr-2"></i><?= $currentDate ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td><span class="trk-id">#<?= $t->id ?></span></td>
                    <td><?= esc($t->motorista_name) ?></td>
                    <td><?= esc($t->route_name ?? '—') ?></td>
                    <td><?= $fmtDate ?></td>
                    <td><?= tkBadge($t->status ?? 'asignado') ?></td>
                    <td class="text-center">
                        <div class="trk-actions d-flex justify-content-center" style="gap:4px;">
                            <a href="<?= base_url('tracking/'.$t->id) ?>" class="btn btn-sm btn-outline-info" title="Ver detalle">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="<?= base_url('tracking-pdf/'.$t->id) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="PDF">
                                <i class="fa-solid fa-file-pdf"></i>
                            </a>
                            <a href="<?= base_url('tracking-labels/'.$t->id) ?>" target="_blank" class="btn btn-sm btn-outline-warning" title="Viñetas">
                                <i class="fa-solid fa-tags"></i>
                            </a>
                            <?php if ($t->status !== 'finalizado'): ?>
                                <a href="<?= base_url('tracking-rendicion/'.$t->id) ?>" class="btn btn-sm btn-outline-success" title="Rendición">
                                    <i class="fa-solid fa-truck"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
                        No se encontraron resultados
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- ── Cards (mobile) ── -->
<div class="d-md-none">
    <?php if (!empty($trackings)): ?>
        <?php foreach ($trackings as $t): ?>
            <?php $fmtDate = date('d/m/Y', strtotime($t->date)); ?>
            <div class="trk-card">
                <div class="trk-card-top">
                    <span class="trk-card-id">#<?= $t->id ?></span>
                    <?= tkBadge($t->status ?? 'asignado') ?>
                </div>
                <div class="trk-card-row">
                    <span class="trk-card-lbl">Motorista</span>
                    <span class="trk-card-val"><?= esc($t->motorista_name) ?></span>
                </div>
                <div class="trk-card-row">
                    <span class="trk-card-lbl">Ruta</span>
                    <span class="trk-card-val"><?= esc($t->route_name ?? '—') ?></span>
                </div>
                <div class="trk-card-row">
                    <span class="trk-card-lbl">Fecha</span>
                    <span class="trk-card-val"><?= $fmtDate ?></span>
                </div>
                <div class="trk-card-actions">
                    <a href="<?= base_url('tracking/'.$t->id) ?>" class="btn btn-sm btn-outline-info">
                        <i class="fa-solid fa-eye mr-1"></i> Ver
                    </a>
                    <a href="<?= base_url('tracking-pdf/'.$t->id) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="fa-solid fa-file-pdf"></i>
                    </a>
                    <a href="<?= base_url('tracking-labels/'.$t->id) ?>" target="_blank" class="btn btn-sm btn-outline-warning">
                        <i class="fa-solid fa-tags"></i>
                    </a>
                    <?php if ($t->status !== 'finalizado'): ?>
                        <a href="<?= base_url('tracking-rendicion/'.$t->id) ?>" class="btn btn-sm btn-outline-success">
                            <i class="fa-solid fa-truck mr-1"></i> Rendir
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center text-muted py-5">
            <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
            No se encontraron resultados
        </div>
    <?php endif; ?>
</div>

<!-- ── Paginación ── -->
<div class="d-flex justify-content-center mt-3">
    <?= $pager->links('default', 'bitacora_pagination') ?>
</div>

<script>
$(document).ready(function () {
    $('#filter_motorista, #filter_ruta').select2({
        theme: 'bootstrap4', width: '100%',
        allowClear: true, placeholder: 'Seleccionar...'
    });
    $('.js-status-select').select2({
        theme: 'bootstrap4', width: '100%',
        allowClear: true, placeholder: 'Estado...'
    });
});
</script>

<?= $this->endSection() ?>

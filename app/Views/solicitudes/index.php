<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<style>
/* Status badges */
.sol-badge {
    display: inline-block; font-size: .68rem; font-weight: 700;
    padding: 2px 8px; border-radius: 20px; white-space: nowrap;
    text-transform: capitalize; letter-spacing: .3px;
}
.sol-pendiente { background: #fef9c3; color: #854d0e; }
.sol-aprobada  { background: #dcfce7; color: #166534; }
.sol-denegada  { background: #fee2e2; color: #991b1b; }

/* Mobile cards */
@media (max-width: 767px) {
    .sol-table-wrap { display: none; }
    .sol-cards      { display: flex; flex-direction: column; gap: 8px; }

    .sol-card {
        background: #fff; border: 1px solid #e5e7eb;
        border-radius: 10px; padding: 12px 14px;
    }
    .sol-card-top {
        display: flex; align-items: flex-start;
        justify-content: space-between; gap: 8px; margin-bottom: 6px;
    }
    .sol-card-pkg   { font-size: .95rem; font-weight: 700; color: #111827; }
    .sol-card-id    { font-size: .72rem; color: #9ca3af; margin-top: 1px; }
    .sol-card-meta  { font-size: .78rem; color: #6b7280; display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
    .sol-card-comment {
        font-size: .78rem; color: #374151; margin-top: 6px;
        background: #f9fafb; border-radius: 6px; padding: 6px 8px;
        border-left: 3px solid #d1d5db;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .sol-card-foot {
        display: flex; justify-content: flex-end; margin-top: 10px;
    }
}
@media (min-width: 768px) {
    .sol-cards { display: none; }
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">Solicitudes de Reversión</h5>
            </div>
            <div class="card-body">

                <!-- Selector por página -->
                <div class="d-flex mb-3">
                    <form method="get" class="d-flex align-items-center">
                        <label class="mb-0 mr-1 small">Mostrar:</label>
                        <select name="per_page" class="form-control form-control-sm d-inline-block w-auto"
                                onchange="this.form.submit()">
                            <?php foreach ([10, 15, 25, 50] as $n): ?>
                                <option value="<?= $n ?>" <?= $perPage == $n ? 'selected' : '' ?>><?= $n ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="small ml-1 text-muted">por página</span>
                    </form>
                </div>

                <?php
                function solBadge(string $estatus): string {
                    $cls = match($estatus) {
                        'aprobada' => 'sol-aprobada',
                        'denegada' => 'sol-denegada',
                        default    => 'sol-pendiente',
                    };
                    return '<span class="sol-badge ' . $cls . '">' . ucfirst(esc($estatus)) . '</span>';
                }
                ?>

                <!-- Tabla (desktop) -->
                <div class="sol-table-wrap table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-1">#Sol</th>
                                <th class="text-center">Paquete</th>
                                <th>Solicitante</th>
                                <th class="text-center">Estado</th>
                                <th>Fecha</th>
                                <th>Comentario</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($solicitudes)): ?>
                                <?php foreach ($solicitudes as $s): ?>
                                <tr>
                                    <td class="text-center text-muted"><?= esc($s['id']) ?></td>
                                    <td class="text-center font-weight-bold">#<?= esc($s['package_id']) ?></td>
                                    <td><?= esc($s['solicitante_nombre'] ?? '—') ?></td>
                                    <td class="text-center"><?= solBadge($s['estatus']) ?></td>
                                    <td class="text-nowrap small"><?= date('d/m/Y H:i', strtotime($s['created_at'])) ?></td>
                                    <td class="small text-muted" style="max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        <?= esc($s['comentario'] ?? '') ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('solicitudes/' . $s['id']) ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center text-muted">No hay solicitudes registradas.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Cards (mobile) -->
                <div class="sol-cards">
                    <?php if (!empty($solicitudes)): ?>
                        <?php foreach ($solicitudes as $s): ?>
                        <div class="sol-card">
                            <div class="sol-card-top">
                                <div>
                                    <div class="sol-card-pkg">Paquete #<?= esc($s['package_id']) ?></div>
                                    <div class="sol-card-id">Solicitud #<?= esc($s['id']) ?></div>
                                </div>
                                <?= solBadge($s['estatus']) ?>
                            </div>
                            <div class="sol-card-meta">
                                <span><i class="fa-solid fa-user" style="font-size:.7rem;margin-right:3px;"></i><?= esc($s['solicitante_nombre'] ?? '—') ?></span>
                                <span><i class="fa-solid fa-clock" style="font-size:.7rem;margin-right:3px;"></i><?= date('d/m/Y H:i', strtotime($s['created_at'])) ?></span>
                            </div>
                            <?php if (!empty($s['comentario'])): ?>
                                <div class="sol-card-comment"><?= esc($s['comentario']) ?></div>
                            <?php endif; ?>
                            <div class="sol-card-foot">
                                <a href="<?= base_url('solicitudes/' . $s['id']) ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-eye mr-1"></i>Ver detalle
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted py-3">No hay solicitudes de reversión registradas.</p>
                    <?php endif; ?>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-3">
                    <?= $pager->links('default', 'bitacora_pagination') ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

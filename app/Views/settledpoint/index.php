<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<style>
/* ── Day pills ── */
.day-pill {
    display: inline-block; font-size: .65rem; font-weight: 700;
    padding: 2px 5px; border-radius: 4px; white-space: nowrap;
    background: #0891b2; color: #fff; letter-spacing: .3px;
}

/* ── Mobile cards ── */
@media (max-width: 767px) {
    .sp-table-wrap { display: none; }
    .sp-cards      { display: flex; flex-direction: column; gap: 8px; }

    .sp-card {
        background: #fff; border: 1px solid #e5e7eb;
        border-radius: 10px; padding: 12px 14px;
    }
    .sp-card-top {
        display: flex; align-items: flex-start; justify-content: space-between; gap: 8px;
    }
    .sp-card-name  { font-size: .92rem; font-weight: 700; color: #111827; }
    .sp-card-route { font-size: .78rem; color: #6b7280; margin-top: 2px; }
    .sp-card-bottom {
        display: flex; align-items: center; justify-content: space-between;
        margin-top: 8px; gap: 8px; flex-wrap: wrap;
    }
    .sp-card-days  { display: flex; flex-wrap: wrap; gap: 4px; }
    .sp-card-hora  { font-size: .78rem; color: #374151; white-space: nowrap; flex-shrink: 0; }
    .sp-card-actions { display: flex; gap: 6px; flex-shrink: 0; }
}
@media (min-width: 768px) {
    .sp-cards { display: none; }
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">Puntos fijos</h5>
                <?php if (tienePermiso('crear_puntofijo')): ?>
                    <a class="btn btn-primary btn-sm ml-auto" href="<?= base_url('settledpoint/new') ?>">
                        <i class="fa-solid fa-plus"></i> Nuevo
                    </a>
                <?php endif; ?>
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
                $diasMap = [
                    'mon' => 'L', 'tus' => 'Ma', 'wen' => 'Mi',
                    'thu' => 'J', 'fri' => 'V', 'sat' => 'S', 'sun' => 'D'
                ];
                $diasFull = [
                    'mon' => 'Lunes', 'tus' => 'Martes', 'wen' => 'Miércoles',
                    'thu' => 'Jueves', 'fri' => 'Viernes', 'sat' => 'Sábado', 'sun' => 'Domingo'
                ];
                function diasPills(object $sp, array $map): string {
                    $pills = '';
                    foreach ($map as $col => $abbr) {
                        if (!empty($sp->$col) && $sp->$col == 1) {
                            $pills .= '<span class="day-pill">' . $abbr . '</span> ';
                        }
                    }
                    return $pills ?: '<span class="text-muted" style="font-size:.8rem">—</span>';
                }
                function diasTexto(object $sp, array $full): string {
                    $dias = [];
                    foreach ($full as $col => $nombre) {
                        if (!empty($sp->$col) && $sp->$col == 1) $dias[] = $nombre;
                    }
                    return $dias ? implode(', ', $dias) : 'Sin días asignados';
                }
                ?>

                <!-- Tabla (desktop) -->
                <div class="sp-table-wrap table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-1">ID</th>
                                <th>Punto</th>
                                <th>Ruta</th>
                                <th>Días de visita</th>
                                <th>Horario</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($settledPoints)): ?>
                                <?php foreach ($settledPoints as $sp): ?>
                                <tr>
                                    <td class="text-center"><?= esc($sp->id) ?></td>
                                    <td><?= esc($sp->point_name) ?></td>
                                    <td><?= esc($sp->route_name) ?></td>
                                    <td><?= diasPills($sp, $diasMap) ?></td>
                                    <td class="text-nowrap"><?= esc($sp->hora_inicio . ' – ' . $sp->hora_fin) ?></td>
                                    <td class="text-center text-nowrap">
                                        <?php if (tienePermiso('editar_puntofijo')): ?>
                                            <a href="<?= base_url('settledpoint/edit/' . $sp->id) ?>"
                                               class="btn btn-sm btn-info"><i class="fa-solid fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if (tienePermiso('eliminar_puntofijo')): ?>
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $sp->id ?>">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center text-muted">No hay puntos fijos registrados.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Cards (mobile) -->
                <div class="sp-cards">
                    <?php if (!empty($settledPoints)): ?>
                        <?php foreach ($settledPoints as $sp): ?>
                        <div class="sp-card">
                            <div class="sp-card-top">
                                <div>
                                    <div class="sp-card-name"><?= esc($sp->point_name) ?></div>
                                    <div class="sp-card-route"><i class="fa-solid fa-route" style="font-size:.7rem;margin-right:3px;"></i><?= esc($sp->route_name) ?></div>
                                </div>
                                <div class="sp-card-actions">
                                    <?php if (tienePermiso('editar_puntofijo')): ?>
                                        <a href="<?= base_url('settledpoint/edit/' . $sp->id) ?>"
                                           class="btn btn-sm btn-info"><i class="fa-solid fa-edit"></i></a>
                                    <?php endif; ?>
                                    <?php if (tienePermiso('eliminar_puntofijo')): ?>
                                        <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $sp->id ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="sp-card-bottom">
                                <div class="sp-card-days"><?= diasPills($sp, $diasMap) ?></div>
                                <div class="sp-card-hora"><i class="fa-regular fa-clock" style="margin-right:3px;"></i><?= esc($sp->hora_inicio . ' – ' . $sp->hora_fin) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted py-3">No hay puntos fijos registrados.</p>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var id = this.dataset.id;
            var btn = this;
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (!result.isConfirmed) return;
                var csrfToken  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var csrfHeader = document.querySelector('meta[name="csrf-header"]').getAttribute('content');
                fetch('<?= base_url('settledpoint/delete') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        [csrfHeader]: csrfToken
                    },
                    body: new URLSearchParams({ id: id })
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    Swal.fire({
                        title: data.status === 'success' ? 'Éxito' : 'Error',
                        text: data.message,
                        icon: data.status,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    if (data.status === 'success') {
                        var row  = btn.closest('tr');
                        var card = btn.closest('.sp-card');
                        if (row)  row.remove();
                        if (card) card.remove();
                        setTimeout(function () { window.location.reload(); }, 1500);
                    }
                })
                .catch(function () {
                    Swal.fire('Error', 'Ocurrió un problema en la petición.', 'error');
                });
            });
        });
    });
});
</script>
<?= $this->endSection() ?>

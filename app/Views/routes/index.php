<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<style>
@media (max-width: 767px) {
    .rt-table-wrap { display: none; }
    .rt-cards      { display: flex; flex-direction: column; gap: 8px; }

    .rt-card {
        background: #fff; border: 1px solid #e5e7eb;
        border-radius: 10px; padding: 12px 14px;
        display: flex; align-items: center; gap: 10px;
    }
    .rt-card-body  { flex: 1; min-width: 0; }
    .rt-card-name  { font-size: .92rem; font-weight: 700; color: #111827;
                     white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .rt-card-desc  { font-size: .78rem; color: #6b7280; margin-top: 2px;
                     white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .rt-card-actions { display: flex; gap: 6px; flex-shrink: 0; }
}
@media (min-width: 768px) {
    .rt-cards { display: none; }
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">Rutas</h5>
                <?php if (tienePermiso('crear_ruta')): ?>
                    <a class="btn btn-primary btn-sm ml-auto" href="<?= base_url('routes/new') ?>">
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

                <!-- Tabla (desktop) -->
                <div class="rt-table-wrap table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="col-1">ID</th>
                                <th>Ruta</th>
                                <th>Descripción</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($routes)): ?>
                                <?php foreach ($routes as $route): ?>
                                <tr>
                                    <td class="text-center"><?= esc($route->id) ?></td>
                                    <td><?= esc($route->route_name) ?></td>
                                    <td><?= esc($route->description) ?></td>
                                    <td class="text-center text-nowrap">
                                        <?php if (tienePermiso('editar_ruta')): ?>
                                            <a href="<?= base_url('routes/edit/' . $route->id) ?>"
                                               class="btn btn-sm btn-info"><i class="fa-solid fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if (tienePermiso('eliminar_ruta')): ?>
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $route->id ?>">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted">No hay rutas registradas.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Cards (mobile) -->
                <div class="rt-cards">
                    <?php if (!empty($routes)): ?>
                        <?php foreach ($routes as $route): ?>
                        <div class="rt-card">
                            <div class="rt-card-body">
                                <div class="rt-card-name"><?= esc($route->route_name) ?></div>
                                <?php if (!empty($route->description)): ?>
                                    <div class="rt-card-desc"><?= esc($route->description) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="rt-card-actions">
                                <?php if (tienePermiso('editar_ruta')): ?>
                                    <a href="<?= base_url('routes/edit/' . $route->id) ?>"
                                       class="btn btn-sm btn-info"><i class="fa-solid fa-edit"></i></a>
                                <?php endif; ?>
                                <?php if (tienePermiso('eliminar_ruta')): ?>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $route->id ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted py-3">No hay rutas registradas.</p>
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
            var id  = this.dataset.id;
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
                fetch('<?= base_url('routes/delete') ?>', {
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
                        var card = btn.closest('.rt-card');
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

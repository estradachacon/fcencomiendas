<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<style>
@media (max-width: 767px) {
    .el-table-wrap { display: none; }
    .el-cards      { display: flex; flex-direction: column; gap: 8px; }

    .el-card {
        background: #fff; border: 1px solid #e5e7eb;
        border-radius: 10px; padding: 12px 14px;
        display: flex; align-items: center; gap: 10px;
    }
    .el-card-body  { flex: 1; min-width: 0; }
    .el-card-name  { font-size: .92rem; font-weight: 700; color: #111827;
                     white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .el-card-desc  { font-size: .78rem; color: #6b7280; margin-top: 2px;
                     white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .el-card-foot  { display: flex; align-items: center; gap: 6px; margin-top: 6px; }
    .el-card-actions { display: flex; gap: 6px; flex-shrink: 0; }
}
@media (min-width: 768px) {
    .el-cards { display: none; }
}
</style>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Casilleros Externos</h5>
        <?php if (tienePermiso('crear_casilleros_externos')): ?>
            <button class="btn btn-primary btn-sm" id="btnNew">
                <i class="fa-solid fa-plus"></i> Nuevo
            </button>
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
        <div class="el-table-wrap table-responsive">
            <table class="table table-bordered table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th class="col-1">ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-center">Activo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($locations)): ?>
                        <?php foreach ($locations as $loc): ?>
                        <tr>
                            <td class="text-center"><?= esc($loc->id) ?></td>
                            <td><?= esc($loc->nombre) ?></td>
                            <td><?= esc($loc->descripcion) ?></td>
                            <td class="text-center">
                                <?php if ($loc->activo): ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center text-nowrap">
                                <?php if (tienePermiso('editar_casilleros_externos')): ?>
                                    <button class="btn btn-sm btn-info btnEdit" data-id="<?= $loc->id ?>">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                <?php endif; ?>
                                <?php if (tienePermiso('eliminar_casilleros_externos')): ?>
                                    <button class="btn btn-sm btn-danger btnDelete" data-id="<?= $loc->id ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted">No hay casilleros registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Cards (mobile) -->
        <div class="el-cards">
            <?php if (!empty($locations)): ?>
                <?php foreach ($locations as $loc): ?>
                <div class="el-card">
                    <div class="el-card-body">
                        <div class="el-card-name"><?= esc($loc->nombre) ?></div>
                        <?php if (!empty($loc->descripcion)): ?>
                            <div class="el-card-desc"><?= esc($loc->descripcion) ?></div>
                        <?php endif; ?>
                        <div class="el-card-foot">
                            <?php if ($loc->activo): ?>
                                <span class="badge badge-success" style="font-size:.68rem">Activo</span>
                            <?php else: ?>
                                <span class="badge badge-secondary" style="font-size:.68rem">Inactivo</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="el-card-actions">
                        <?php if (tienePermiso('editar_casilleros_externos')): ?>
                            <button class="btn btn-sm btn-info btnEdit" data-id="<?= $loc->id ?>">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                        <?php endif; ?>
                        <?php if (tienePermiso('eliminar_casilleros_externos')): ?>
                            <button class="btn btn-sm btn-danger btnDelete" data-id="<?= $loc->id ?>">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-muted py-3">No hay casilleros registrados.</p>
            <?php endif; ?>
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-3">
            <?= $pager->links('default', 'bitacora_pagination') ?>
        </div>

    </div>
</div>

<!-- Modal crear/editar -->
<div class="modal fade" id="locationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="locationForm">
                <div class="modal-header">
                    <h5 class="modal-title">Casillero externo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="location_id" name="id">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="activo" name="activo" value="1" class="form-check-input" checked>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Nuevo ── */
    var btnNew = document.getElementById('btnNew');
    if (btnNew) {
        btnNew.addEventListener('click', function () {
            document.getElementById('locationForm').reset();
            document.getElementById('location_id').value = '';
            $('#locationModal').modal('show');
        });
    }

    /* ── Editar ── */
    document.querySelectorAll('.btnEdit').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = this.dataset.id;
            fetch('<?= base_url('external-locations/get') ?>/' + id)
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    document.getElementById('location_id').value  = data.id;
                    document.getElementById('nombre').value       = data.nombre;
                    document.getElementById('descripcion').value  = data.descripcion;
                    document.getElementById('activo').checked     = data.activo == 1;
                    $('#locationModal').modal('show');
                });
        });
    });

    /* ── Guardar ── */
    document.getElementById('locationForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var id  = document.getElementById('location_id').value;
        var url = id
            ? '<?= base_url('external-locations/update') ?>/' + id
            : '<?= base_url('external-locations/store') ?>';
        fetch(url, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(this)
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.success) {
                $('#locationModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: id ? 'Actualizado' : 'Creado',
                    text: 'Registro guardado correctamente',
                    timer: 1500, showConfirmButton: false
                }).then(function () { location.reload(); });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message ?? 'Ocurrió un problema' });
            }
        });
    });

    /* ── Eliminar ── */
    document.querySelectorAll('.btnDelete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = this.dataset.id;
            Swal.fire({
                title: '¿Eliminar registro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (!result.isConfirmed) return;
                fetch('<?= base_url('external-locations/delete') ?>/' + id, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                }).then(function () {
                    Swal.fire({
                        icon: 'success', title: 'Eliminado',
                        text: 'Registro eliminado correctamente',
                        timer: 1500, showConfirmButton: false
                    }).then(function () { location.reload(); });
                });
            });
        });
    });

});
</script>
<?= $this->endSection() ?>

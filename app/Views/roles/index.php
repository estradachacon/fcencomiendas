<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>

<style>
    /* ── Tarjetas móvil ── */
    .role-card {
        border-radius: 12px;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 6px rgba(0,0,0,.06);
        margin-bottom: 10px;
        background: #fff;
    }
    .role-card-body {
        padding: 14px 16px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }
    .role-card-id {
        display: inline-block;
        background: #f0f2f7;
        color: #6c757d;
        font-size: .72rem;
        font-weight: 700;
        border-radius: 20px;
        padding: 2px 8px;
        margin-bottom: 4px;
        line-height: 1.6;
    }
    .role-card-name {
        font-size: 1rem;
        font-weight: 700;
        color: #1d2744;
        line-height: 1.3;
        margin-bottom: 3px;
    }
    .role-card-desc {
        font-size: .82rem;
        color: #6c757d;
        line-height: 1.4;
    }
    .role-card-actions {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
    }
    .role-card-actions .btn {
        min-width: 36px;
        padding: 5px 10px;
    }
</style>

<div class="container-fluid px-3 py-3">

    <!-- ── Encabezado ── -->
    <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0">
                <i class="fa-solid fa-shield-halved me-2 text-primary"></i>Roles
            </h4>
            <small class="text-muted">Administra los roles del sistema</small>
        </div>
        <?php if (tienePermiso('crear_roles')): ?>
            <a class="btn btn-primary btn-sm mb-3" href="<?= base_url('roles/new') ?>">
                <i class="fa-solid fa-plus me-1"></i>Nuevo Rol
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($roles)): ?>

        <!-- ══ TARJETAS (móvil) ══ -->
        <div class="d-md-none">
            <?php foreach ($roles as $role): ?>
                <div class="role-card">
                    <div class="role-card-body">
                        <div class="flex-grow-1 min-width-0">
                            <span class="role-card-id">#<?= esc($role['id']) ?></span>
                            <div class="role-card-name"><?= esc($role['nombre']) ?></div>
                            <?php if (!empty($role['descripcion'])): ?>
                                <div class="role-card-desc"><?= esc($role['descripcion']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="role-card-actions">
                            <?php if (tienePermiso('asignar_permisos')): ?>
                                <a href="<?= site_url('access/' . $role['id']) ?>"
                                   class="btn btn-sm btn-warning" title="Permisos">
                                    <i class="fa-solid fa-key"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (tienePermiso('editar_roles')): ?>
                                <a href="<?= base_url('roles/edit/' . $role['id']) ?>"
                                   class="btn btn-sm btn-info" title="Editar">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                            <?php endif; ?>
                            <?php if (tienePermiso('eliminar_roles')): ?>
                                <button class="btn btn-sm btn-danger delete-btn"
                                        data-id="<?= $role['id'] ?>" title="Eliminar">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- ══ TABLA (desktop) ══ -->
        <div class="card d-none d-md-block shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width:60px">ID</th>
                                <th>Nombre del Rol</th>
                                <th>Descripción</th>
                                <th class="text-center pe-3" style="width:130px">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roles as $role): ?>
                                <tr>
                                    <td class="ps-3 text-muted fw-semibold"><?= esc($role['id']) ?></td>
                                    <td><strong><?= esc($role['nombre']) ?></strong></td>
                                    <td class="text-muted"><?= esc($role['descripcion']) ?></td>
                                    <td class="text-center pe-3">
                                        <div class="d-flex justify-content-center gap-1">
                                            <?php if (tienePermiso('asignar_permisos')): ?>
                                                <a href="<?= site_url('access/' . $role['id']) ?>"
                                                   class="btn btn-sm btn-warning" title="Asignar permisos">
                                                    <i class="fa-solid fa-key"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (tienePermiso('editar_roles')): ?>
                                                <a href="<?= base_url('roles/edit/' . $role['id']) ?>"
                                                   class="btn btn-sm btn-info" title="Editar">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (tienePermiso('eliminar_roles')): ?>
                                                <button class="btn btn-sm btn-danger delete-btn"
                                                        data-id="<?= $role['id'] ?>" title="Eliminar">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="text-center py-5 text-muted">
            <i class="fa-solid fa-shield-halved" style="font-size:3rem;opacity:.3"></i>
            <p class="mt-3 mb-0">No hay roles registrados.</p>
            <?php if (tienePermiso('crear_roles')): ?>
                <a href="<?= base_url('roles/new') ?>" class="btn btn-primary btn-sm mt-3">
                    <i class="fa-solid fa-plus me-1"></i>Crear primer rol
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            Swal.fire({
                title: '¿Eliminar este rol?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (!result.isConfirmed) return;

                const csrfToken  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfHeader = document.querySelector('meta[name="csrf-header"]').getAttribute('content');

                fetch("<?= base_url('roles/delete') ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        [csrfHeader]: csrfToken
                    },
                    body: new URLSearchParams({ id })
                })
                .then(r => r.json())
                .then(data => {
                    Swal.fire({
                        title: data.status === 'success' ? 'Éxito' : 'Error',
                        text: data.message,
                        icon: data.status,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    if (data.status === 'success') {
                        // Eliminar la fila de tabla Y la tarjeta móvil
                        document.querySelectorAll(`.delete-btn[data-id="${id}"]`).forEach(btn => {
                            const row  = btn.closest('tr');
                            const card = btn.closest('.role-card');
                            if (row)  row.remove();
                            if (card) card.remove();
                        });
                    }
                })
                .catch(() => Swal.fire('Error', 'Ocurrió un problema en la petición.', 'error'));
            });
        });
    });
});
</script>

<?= $this->endSection() ?>

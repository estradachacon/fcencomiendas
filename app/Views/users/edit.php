<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>

<div class="row">
    <!-- ── Datos generales del usuario ─────────────────────────────── -->
    <div class="col-md-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between">
                <h4 class="header-title mb-0">Editar usuario</h4>
                <?php if (tienePermiso('gestionar_horarios')): ?>
                    <a href="<?= base_url('horario/sesiones?user_id=' . $user['id']) ?>"
                       class="btn btn-sm btn-outline-info">
                        <i class="fa-solid fa-clock-rotate-left"></i> Ver historial de sesiones
                    </a>
                <?php endif; ?>
            </div>

            <div class="card-body">
                <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="user_name" class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" required
                                value="<?= esc($user['user_name']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                value="<?= esc($user['email']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="user_password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="user_password" name="user_password"
                                placeholder="Dejar en blanco si no desea cambiarla">
                            <small class="text-muted">Deje este campo vacío para mantener la contraseña actual.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">Rol asignado</label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">Seleccione un rol</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= esc($role['id']) ?>" <?= $role['id'] == $user['role_id'] ? 'selected' : '' ?>>
                                        <?= esc($role['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="branch_id" class="form-label">Asignar sucursal</label>
                            <select class="form-select" id="branch_id" name="branch_id" required>
                                <option value="">Seleccione una sucursal</option>
                                <?php foreach ($branches as $branch): ?>
                                    <option value="<?= esc($branch->id) ?>" <?= $branch->id == $user['branch_id'] ? 'selected' : '' ?>>
                                        <?= esc($branch->branch_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- ── Horario laboral ──────────────────────────────── -->
                    <?php if (tienePermiso('gestionar_horarios')): ?>
                    <hr>
                    <h5 class="mb-3"><i class="fa-solid fa-business-time me-2 text-primary"></i>Horario laboral</h5>
                    <div class="row align-items-end">
                        <div class="col-md-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       id="horario_activo" name="horario_activo" value="1"
                                       <?= !empty($user['horario_activo']) ? 'checked' : '' ?>
                                       onchange="toggleHorario(this.checked)">
                                <label class="form-check-label" for="horario_activo">
                                    Restricción de horario activa
                                </label>
                            </div>
                            <small class="text-muted">
                                Si está desactivado, el usuario puede iniciar sesión en cualquier momento.
                            </small>
                        </div>
                        <div class="col-md-3 mb-3" id="wrap_inicio">
                            <label for="horario_inicio" class="form-label">Hora de entrada</label>
                            <input type="time" class="form-control" id="horario_inicio"
                                   name="horario_inicio"
                                   value="<?= esc($user['horario_inicio'] ?? '') ?>">
                        </div>
                        <div class="col-md-3 mb-3" id="wrap_fin">
                            <label for="horario_fin" class="form-label">Hora de salida</label>
                            <input type="time" class="form-control" id="horario_fin"
                                   name="horario_fin"
                                   value="<?= esc($user['horario_fin'] ?? '') ?>">
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Actualizar usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ── Cierre forzado de sesión ────────────────────────────────── -->
    <?php if (tienePermiso('gestionar_horarios')): ?>
    <div class="col-md-12">
        <div class="card shadow-sm border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fa-solid fa-power-off me-2"></i>Control de sesión activa</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Si el usuario tiene una sesión activa en este momento, puedes solicitar su cierre inmediato.
                    Recibirá una notificación y será desconectado en los próximos segundos.
                </p>
                <button type="button" class="btn btn-danger" id="btnForzarCierre"
                        data-user-id="<?= esc($user['id']) ?>"
                        data-user-name="<?= esc($user['user_name']) ?>">
                    <i class="fa-solid fa-triangle-exclamation me-1"></i>
                    Forzar cierre de sesión
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    function toggleHorario(activo) {
        document.getElementById('wrap_inicio').style.display = activo ? '' : 'none';
        document.getElementById('wrap_fin').style.display    = activo ? '' : 'none';
    }
    // Estado inicial
    toggleHorario(document.getElementById('horario_activo').checked);

    <?php if (tienePermiso('gestionar_horarios')): ?>
    document.getElementById('btnForzarCierre').addEventListener('click', function () {
        const userId   = this.dataset.userId;
        const userName = this.dataset.userName;

        Swal.fire({
            title: '¿Cerrar sesión de ' + userName + '?',
            text:  'El usuario recibirá una notificación y será desconectado.',
            icon:  'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor:  '#6c757d',
            confirmButtonText:  'Sí, cerrar sesión',
            cancelButtonText:   'Cancelar',
        }).then(result => {
            if (!result.isConfirmed) return;

            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            fetch('<?= base_url('horario/forzar-cierre/') ?>' + userId, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({}),
            })
            .then(r => r.json())
            .then(data => {
                Swal.fire({
                    toast: true, position: 'top-end', icon: data.success ? 'success' : 'error',
                    title: data.message, showConfirmButton: false, timer: 3000, timerProgressBar: true,
                });
            });
        });
    });
    <?php endif; ?>
</script>

<?= $this->endSection() ?>

<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between">
                <h4 class="header-title mb-0">
                    <i class="fa-solid fa-clock-rotate-left me-2"></i> Registro de Sesiones
                </h4>
                <a href="<?= base_url('users') ?>" class="btn btn-sm btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Volver a Usuarios
                </a>
            </div>

            <div class="card-body">
                <!-- Filtro por usuario -->
                <form method="GET" action="<?= base_url('horario/sesiones') ?>" class="row g-2 align-items-end mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Filtrar por usuario</label>
                        <select name="user_id" class="form-select">
                            <option value="">— Todos los usuarios —</option>
                            <?php foreach ($usuarios as $u): ?>
                                <option value="<?= esc($u['id']) ?>"
                                    <?= (int)$filtro_user_id === (int)$u['id'] ? 'selected' : '' ?>>
                                    <?= esc($u['user_name']) ?> (<?= esc($u['email']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-filter"></i> Filtrar
                        </button>
                    </div>
                    <?php if ($filtro_user_id): ?>
                        <div class="col-md-2">
                            <a href="<?= base_url('horario/sesiones') ?>" class="btn btn-outline-secondary w-100">
                                <i class="fa-solid fa-xmark"></i> Limpiar
                            </a>
                        </div>
                    <?php endif; ?>
                </form>

                <!-- Tabla de sesiones -->
                <div class="table-responsive">
                    <table id="tablaSesiones" class="table table-hover table-bordered" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Tipo</th>
                                <th>IP</th>
                                <th>Notas</th>
                                <th>Fecha y hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sesiones as $i => $s): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($s['user_name'] ?? '—') ?></td>
                                    <td><?= esc($s['email'] ?? '—') ?></td>
                                    <td>
                                        <?php if ($s['tipo'] === 'login'): ?>
                                            <span class="badge bg-success text-white">
                                                <i class="fa-solid fa-right-to-bracket"></i> Inicio
                                            </span>
                                        <?php elseif ($s['tipo'] === 'logout'): ?>
                                            <span class="badge bg-secondary text-white">
                                                <i class="fa-solid fa-right-from-bracket"></i> Cierre
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger text-white">
                                                <i class="fa-solid fa-triangle-exclamation"></i> Forzado
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><code><?= esc($s['ip_address'] ?? '—') ?></code></td>
                                    <td><?= esc($s['notas'] ?? '—') ?></td>
                                    <td><?= esc($s['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#tablaSesiones', {
            order: [[6, 'desc']],
            pageLength: 25,
            language: {
                url: null,
                search: $lang_search,
                lengthMenu: $lang_show + ' _MENU_ ' + $lang_entries,
                info: $lang_showing + ' _START_ ' + $lang_to + ' _END_ ' + $lang_of + ' _TOTAL_ ' + $lang_entries,
                zeroRecords: $lang_no_matching_records_found,
                paginate: {
                    first: $lang_first,
                    last: $lang_last,
                    next: $lang_next,
                    previous: $lang_previous,
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>

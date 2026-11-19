<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Sesiones abiertas de cajas eliminadas</h5>
            </div>
            <div class="card-body">
                <?php if (empty($sesiones)): ?>
                    <p class="text-center text-muted py-3 mb-0">
                        <i class="fa fa-check-circle text-success mr-1"></i>No hay sesiones pendientes de cerrar.
                    </p>
                <?php else: ?>
                    <p class="small text-muted">
                        El saldo se calcula con los movimientos registrados en la sesión. Al cerrar, se reintegra a la cuenta de efectivo.
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sesión</th>
                                    <th>Caja eliminada</th>
                                    <th>Usuario</th>
                                    <th>Abierta</th>
                                    <th class="text-right">Monto inicial</th>
                                    <th class="text-right">Saldo a reintegrar</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sesiones as $s): ?>
                                <tr>
                                    <td><?= esc($s['id']) ?></td>
                                    <td><?= esc($s['cashier_id']) ?></td>
                                    <td><?= esc($s['user_name'] ?? $s['user_id']) ?></td>
                                    <td class="text-nowrap"><?= esc($s['open_time']) ?></td>
                                    <td class="text-right">$<?= number_format($s['initial_amount'], 2) ?></td>
                                    <td class="text-right font-weight-bold">$<?= number_format($s['saldo'], 2) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger btn-cerrar"
                                                data-id="<?= esc($s['id']) ?>"
                                                data-usuario="<?= esc($s['user_name'] ?? $s['user_id']) ?>"
                                                data-saldo="<?= number_format($s['saldo'], 2) ?>">
                                            <i class="fa fa-lock mr-1"></i>Cerrar
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-cerrar').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var d = this.dataset;
        Swal.fire({
            title: '¿Cerrar sesión ' + d.id + '?',
            html: 'Usuario: <b>' + d.usuario + '</b><br>Se reintegrarán <b>$' + d.saldo + '</b> a la cuenta de efectivo.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, cerrar',
            cancelButtonText: 'Cancelar'
        }).then(function (r) {
            if (!r.isConfirmed) return;
            var csrfToken  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var csrfHeader = document.querySelector('meta[name="csrf-header"]').getAttribute('content');
            fetch('<?= base_url('cashier/huerfanas/cerrar') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest',
                    [csrfHeader]: csrfToken
                },
                body: new URLSearchParams({ session_id: d.id })
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                Swal.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.success ? 'Listo' : 'Error',
                    text: data.message
                }).then(function () { if (data.success) location.reload(); });
            })
            .catch(function () { Swal.fire('Error', 'Ocurrió un problema en la petición.', 'error'); });
        });
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<style>
.bit-badge {
    display: inline-block; font-size: .68rem; font-weight: 700;
    padding: 2px 7px; border-radius: 20px; white-space: nowrap;
    text-transform: uppercase; letter-spacing: .4px;
}
.bit-crear    { background: #dcfce7; color: #166534; }
.bit-editar   { background: #dbeafe; color: #1e40af; }
.bit-eliminar { background: #fee2e2; color: #991b1b; }
.bit-login    { background: #fef9c3; color: #854d0e; }
.bit-logout   { background: #f3f4f6; color: #374151; }
.bit-default  { background: #e0f2fe; color: #0c4a6e; }

@media (max-width: 767px) {
    .bit-table-wrap { display: none; }
    .bit-cards      { display: flex; flex-direction: column; gap: 6px; }

    .bit-card {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border: 1px solid #e5e7eb;
        border-radius: 8px; padding: 10px 12px;
        cursor: pointer; user-select: none;
        transition: background .12s;
        -webkit-tap-highlight-color: transparent;
    }
    .bit-card:active { background: #f0f9ff; }

    .bit-card-left  { flex: 1; min-width: 0; display: flex; align-items: center; gap: 8px; }
    .bit-card-num   { font-size: .7rem; color: #9ca3af; min-width: 18px; text-align: right; flex-shrink: 0; }
    .bit-card-info  { min-width: 0; }
    .bit-card-modulo{ font-size: .86rem; font-weight: 600; color: #111827;
                      white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .bit-card-fecha { font-size: .7rem; color: #9ca3af; white-space: nowrap; flex-shrink: 0; }

    .bit-tap-hint   { text-align: center; font-size: .72rem; color: #9ca3af; margin-bottom: 6px; }
}
@media (min-width: 768px) {
    .bit-cards    { display: none; }
    .bit-tap-hint { display: none; }
}

/* Modal de detalle */
#bitDetailModal .modal-header { background: linear-gradient(135deg,#083344,#0891b2); color:#fff; }
#bitDetailModal .modal-title  { color:#fff; font-size:1rem; }
#bitDetailModal .close        { color:#fff; opacity:.85; }
#bitDetailModal .detail-row   { display:flex; gap:6px; padding: 7px 0; border-bottom:1px solid #f3f4f6; font-size:.88rem; }
#bitDetailModal .detail-row:last-child { border-bottom: none; }
#bitDetailModal .detail-label { font-weight:600; color:#374151; min-width:90px; flex-shrink:0; }
#bitDetailModal .detail-val   { color:#111827; word-break: break-word; }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><?= esc($title) ?></h5></div>
            <div class="card-body">

                <div class="d-flex mb-3">
                    <form method="get" id="perPageForm" class="d-flex align-items-center gap-2">
                        <label for="per_page" class="mb-0 mr-1 small">Mostrar:</label>
                        <select name="per_page" id="per_page" class="form-control form-control-sm d-inline-block w-auto"
                            onchange="this.form.submit()">
                            <?php foreach ([5, 10, 25, 50, 100] as $n): ?>
                                <option value="<?= $n ?>" <?= $perPage == $n ? 'selected' : '' ?>><?= $n ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="small ml-1 text-muted">por página</span>
                    </form>
                </div>

                <?php
                function bitBadge(string $accion): string {
                    $a = strtolower(trim($accion));
                    $cls = match(true) {
                        str_contains($a,'crear')||str_contains($a,'creat')||str_contains($a,'store')||str_contains($a,'registro') => 'bit-crear',
                        str_contains($a,'editar')||str_contains($a,'edit')||str_contains($a,'update')||str_contains($a,'actualiz')  => 'bit-editar',
                        str_contains($a,'elimin')||str_contains($a,'delet')||str_contains($a,'borra')                               => 'bit-eliminar',
                        str_contains($a,'login')||str_contains($a,'inicio')                                                         => 'bit-login',
                        str_contains($a,'logout')||str_contains($a,'cerrar')||str_contains($a,'salida')                             => 'bit-logout',
                        default => 'bit-default',
                    };
                    return '<span class="bit-badge '.$cls.'">'.esc($accion).'</span>';
                }
                ?>

                <!-- Tabla (desktop) -->
                <div class="bit-table-wrap table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr><th>#</th><th>Usuario</th><th>Acción</th><th>Módulo</th><th>Descripción</th><th>IP</th><th>Fecha</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bitacoras)): ?>
                                <?php foreach ($bitacoras as $i => $b): ?>
                                <tr>
                                    <td><?= $i+1 ?></td>
                                    <td><?= esc($b['usuario'] ?? 'Sistema') ?></td>
                                    <td><?= bitBadge($b['accion']) ?></td>
                                    <td><?= esc($b['modulo']) ?></td>
                                    <td><?= esc($b['descripcion']) ?></td>
                                    <td><code><?= esc($b['ip_address']) ?></code></td>
                                    <td class="text-nowrap"><?= esc($b['created_at']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center text-muted">Sin registros.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Cards (mobile) -->
                <?php if (!empty($bitacoras)): ?>
                <p class="bit-tap-hint">Toca un registro para ver el detalle</p>
                <?php endif; ?>
                <div class="bit-cards">
                    <?php if (!empty($bitacoras)): ?>
                        <?php foreach ($bitacoras as $i => $b): ?>
                        <div class="bit-card"
                             data-usuario="<?= esc($b['usuario'] ?? 'Sistema') ?>"
                             data-accion="<?= esc($b['accion']) ?>"
                             data-modulo="<?= esc($b['modulo']) ?>"
                             data-desc="<?= esc($b['descripcion']) ?>"
                             data-ip="<?= esc($b['ip_address']) ?>"
                             data-fecha="<?= esc($b['created_at']) ?>">
                            <span class="bit-card-num"><?= $i+1 ?></span>
                            <div class="bit-card-left">
                                <?= bitBadge($b['accion']) ?>
                                <div class="bit-card-info">
                                    <div class="bit-card-modulo"><?= esc($b['modulo']) ?></div>
                                </div>
                            </div>
                            <span class="bit-card-fecha"><?= esc(date('d/m H:i', strtotime($b['created_at']))) ?></span>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted py-3">No hay registros en la bitácora.</p>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content: center mt-3">
                    <?= $pager->links('default', 'bitacora_pagination') ?>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal de detalle -->
<div class="modal fade" id="bitDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info-circle mr-2"></i>Detalle del registro</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-3" id="bitDetailBody"></div>
        </div>
    </div>
</div>

<script>
(function () {
    var badges = <?= json_encode(array_map(fn($b) => [
        'accion'  => $b['accion'],
        'clase'   => (function($a){
            $a = strtolower($a);
            if (str_contains($a,'crear')||str_contains($a,'creat')||str_contains($a,'store')) return 'bit-crear';
            if (str_contains($a,'editar')||str_contains($a,'edit')||str_contains($a,'update')) return 'bit-editar';
            if (str_contains($a,'elimin')||str_contains($a,'delet')) return 'bit-eliminar';
            if (str_contains($a,'login')) return 'bit-login';
            if (str_contains($a,'logout')) return 'bit-logout';
            return 'bit-default';
        })($b['accion'])
    ], $bitacoras ?? [])) ?>;

    document.querySelectorAll('.bit-card').forEach(function (card) {
        card.addEventListener('click', function () {
            var d = this.dataset;
            var idx = [...this.parentElement.children].indexOf(this);
            var badgeCls = (badges[idx] || {}).clase || 'bit-default';

            document.getElementById('bitDetailBody').innerHTML =
                row('Acción',      '<span class="bit-badge ' + badgeCls + '">' + esc(d.accion) + '</span>') +
                row('Módulo',      esc(d.modulo)) +
                row('Descripción', esc(d.desc)) +
                row('Usuario',     '<i class="fa fa-user mr-1 text-muted"></i>' + esc(d.usuario)) +
                row('IP',          '<code>' + esc(d.ip) + '</code>') +
                row('Fecha',       '<i class="fa fa-clock mr-1 text-muted"></i>' + esc(d.fecha));

            $('#bitDetailModal').modal('show');
        });
    });

    function row(label, val) {
        return '<div class="detail-row"><span class="detail-label">' + label + '</span><span class="detail-val">' + val + '</span></div>';
    }
    function esc(s) {
        return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
})();
</script>
<?= $this->endSection() ?>

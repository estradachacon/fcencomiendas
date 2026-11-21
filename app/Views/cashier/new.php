<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex">
                <h4 class="header-title mb-0">Crear caja</h4>
            </div>

            <div class="card-body">
                <?php $errors = session('errors') ?? []; ?>
                <?php if ($errors): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="<?= base_url('cashiers/create') ?>" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nombre de caja</label>
                            <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                id="name" name="name" value="<?= esc(old('name')) ?>" required>
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="initial_balance" class="form-label">Monto inicial</label>
                            <input type="number" name="initial_balance" id="initial_balance"
                                class="form-control text-right input-unit-cost" value="<?= esc(old('initial_balance')) ?>" step="0.01" required>
                        </div>
                    </div>
                    <!-- Sucursal y Usuario en la misma fila -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="branch_id" class="form-label">Sucursal</label>
                            <select class="form-select" id="branch_id" name="branch_id" required>
                                <option value="">Seleccione una sucursal</option>
                                <?php foreach ($branches as $branch): ?>
                                    <option value="<?= esc($branch->id) ?>" <?= old('branch_id') == $branch->id ? 'selected' : '' ?>><?= esc($branch->branch_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">Asignar usuario</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="">Seleccione un usuario</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= esc($user['id']) ?>" <?= old('user_id') == $user['id'] ? 'selected' : '' ?>><?= esc($user['user_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Crear caja</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
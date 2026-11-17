<?= $this->extend('Layouts/mainbody') ?>
<?= $this->section('content') ?>
<style>
/* ── Layout desktop: 2 columnas ── */
.prf-outer {
    max-width: 900px; margin: 0 auto;
}
.prf-grid {
    display: flex; gap: 24px; align-items: flex-start;
}
.prf-col-form  { flex: 1; min-width: 0; }
.prf-col-photo { width: 300px; flex-shrink: 0; }

@media (max-width: 767px) {
    .prf-grid      { flex-direction: column; }
    .prf-col-photo { width: 100%; order: -1; }   /* foto arriba en mobile */
}

/* Avatar */
.prf-avatar-wrap {
    position: relative; width: 100%;
}
.prf-avatar-wrap img {
    width: 100%; height: auto; border-radius: 14px; object-fit: contain;
    border: 3px solid #0891b2; box-shadow: 0 2px 10px rgba(8,145,178,.2);
    display: block;
}
.prf-avatar-btn {
    position: absolute; bottom: 10px; right: 10px;
    width: 36px; height: 36px; border-radius: 10px;
    background: #0891b2; color: #fff; border: 2px solid #fff;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: .9rem; box-shadow: 0 2px 6px rgba(0,0,0,.25);
}
#foto { display: none; }
#fotoNombre { font-size: .75rem; margin-top: 6px; text-align: center; }

/* Secciones */
.prf-section {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 10px; padding: 16px; margin-bottom: 14px;
}
.prf-section-title {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .6px; color: #6b7280; margin-bottom: 12px;
}
.prf-field { margin-bottom: 12px; }
.prf-field:last-child { margin-bottom: 0; }
.prf-field label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: 3px; display: block; }
.prf-field .form-control { font-size: .9rem; }
.prf-field .form-control:disabled { background: #f9fafb; color: #6b7280; }

/* Password toggle */
.prf-pwd-toggle {
    display: flex; align-items: center; gap: 8px; cursor: pointer;
    font-size: .82rem; font-weight: 600; color: #0891b2; margin-bottom: 0;
    user-select: none;
}
.prf-pwd-toggle i.fa-chevron-right { transition: transform .2s; }
.prf-pwd-toggle.open i.fa-chevron-right { transform: rotate(90deg); }
.prf-pwd-fields { display: none; padding-top: 12px; }
.prf-pwd-fields.open { display: block; }

/* Alerta éxito */
.prf-success {
    background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;
    border-radius: 8px; padding: 10px 14px; font-size: .88rem;
    display: flex; align-items: center; gap: 8px; margin-bottom: 14px;
}

/* Botón guardar */
.prf-save-btn {
    width: 100%; padding: 11px; font-size: .95rem; font-weight: 600;
    border-radius: 8px;
}

#passwordError { font-size: .8rem; margin-top: 4px; }
</style>

<div class="row">
    <div class="col-12">
        <div class="prf-outer">

            <?php if (session()->getFlashdata('success')): ?>
            <div class="prf-success">
                <i class="fa fa-check-circle"></i>
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
            <?php endif; ?>

            <form action="<?= base_url('perfil/update') ?>" method="post" enctype="multipart/form-data">
                <div class="prf-grid">

                    <!-- Columna izquierda: formulario -->
                    <div class="prf-col-form">

                        <div class="prf-section">
                            <div class="prf-section-title"><i class="fa fa-user mr-1"></i>Datos personales</div>
                            <div class="prf-field">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control"
                                       value="<?= esc($user['user_name']) ?>" required>
                            </div>
                            <div class="prf-field">
                                <label>Correo electrónico</label>
                                <input type="email" class="form-control"
                                       value="<?= esc($user['email']) ?>" disabled>
                            </div>
                        </div>

                        <div class="prf-section">
                            <div class="prf-pwd-toggle" id="pwdToggle">
                                <i class="fa fa-chevron-right"></i>
                                <i class="fa fa-lock text-muted" style="font-size:.85rem"></i>
                                Cambiar contraseña
                            </div>
                            <div class="prf-pwd-fields" id="pwdFields">
                                <div class="prf-field">
                                    <label>Nueva contraseña</label>
                                    <input type="password" id="password" name="password"
                                           class="form-control" placeholder="Mínimo 6 caracteres">
                                </div>
                                <div class="prf-field">
                                    <label>Confirmar contraseña</label>
                                    <input type="password" id="password_confirm"
                                           class="form-control" placeholder="Repita la contraseña">
                                </div>
                                <div class="text-danger d-none" id="passwordError">Las contraseñas no coinciden</div>
                            </div>
                        </div>

                        <button type="submit" id="btnGuardar" class="btn btn-primary prf-save-btn">
                            <i class="fa fa-save mr-2"></i>Guardar cambios
                        </button>

                    </div>

                    <!-- Columna derecha: foto -->
                    <div class="prf-col-photo">
                        <div class="prf-avatar-wrap">
                            <img id="previewImg"
                                 src="<?= $user['foto'] ? base_url('upload/perfiles/'.$user['foto']) : base_url('upload/no-user.png') ?>"
                                 alt="Foto de perfil">
                            <label class="prf-avatar-btn" for="foto" title="Cambiar foto">
                                <i class="fa fa-camera"></i>
                            </label>
                        </div>
                        <input type="file" name="foto" id="foto" accept="image/*">
                        <div id="fotoNombre" class="text-muted" style="display:none"></div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<script>
(function () {
    var password   = document.getElementById('password');
    var confirm    = document.getElementById('password_confirm');
    var btnGuardar = document.getElementById('btnGuardar');
    var error      = document.getElementById('passwordError');
    var toggle     = document.getElementById('pwdToggle');
    var fields     = document.getElementById('pwdFields');
    var foto       = document.getElementById('foto');

    toggle.addEventListener('click', function () {
        var open = fields.classList.toggle('open');
        toggle.classList.toggle('open', open);
        if (!open) { password.value = ''; confirm.value = ''; validar(); }
    });

    function validar() {
        var p = password.value.trim(), c = confirm.value.trim();
        if (p === '' && c === '') { btnGuardar.disabled = false; error.classList.add('d-none'); return; }
        if (p === '' || c === '') { btnGuardar.disabled = true; error.textContent = 'Completa ambos campos'; error.classList.remove('d-none'); return; }
        if (p !== c)              { btnGuardar.disabled = true; error.textContent = 'Las contraseñas no coinciden'; error.classList.remove('d-none'); return; }
        btnGuardar.disabled = false; error.classList.add('d-none');
    }
    password.addEventListener('input', validar);
    confirm.addEventListener('input', validar);
    validar();

    foto.addEventListener('change', function () {
        var file = this.files[0];
        if (!file) return;
        document.getElementById('fotoNombre').textContent = file.name;
        document.getElementById('fotoNombre').style.display = '';
        var reader = new FileReader();
        reader.onload = function (e) { document.getElementById('previewImg').src = e.target.result; };
        reader.readAsDataURL(file);
    });
})();
</script>
<?= $this->endSection() ?>

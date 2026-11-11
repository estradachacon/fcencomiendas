<!-- Modal de Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content lm-card">

            <!-- Header con gradiente -->
            <div class="lm-header">
                <button type="button" class="lm-close" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
                <div class="lm-logo-wrap">
                    <?php if (setting('logo')): ?>
                        <img src="<?= base_url('upload/settings/' . setting('logo')) ?>" alt="logo" class="lm-logo-img">
                    <?php else: ?>
                        <div class="lm-logo-fallback"><i class="fas fa-box"></i></div>
                    <?php endif; ?>
                </div>
                <h5 class="lm-title" id="loginModalLabel">Bienvenido de vuelta</h5>
                <p class="lm-subtitle">Ingresa tus credenciales para continuar</p>
            </div>

            <!-- Body -->
            <div class="lm-body">
                <form id="loginForm" action="<?= base_url('/login') ?>" method="POST">

                    <div class="lm-field">
                        <label for="username" class="lm-label">Usuario o correo</label>
                        <div class="lm-input-wrap">
                            <i class="fas fa-user lm-input-icon"></i>
                            <input type="text" class="lm-input" id="username" name="username"
                                placeholder="tu@correo.com" required autocomplete="username">
                        </div>
                    </div>

                    <div class="lm-field">
                        <label for="password" class="lm-label">Contraseña</label>
                        <div class="lm-input-wrap">
                            <i class="fas fa-lock lm-input-icon"></i>
                            <input type="password" class="lm-input" id="password" name="password"
                                placeholder="••••••••" required autocomplete="current-password">
                            <button class="lm-eye" type="button" id="togglePassword" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="lm-row-between">
                        <label class="lm-check-label">
                            <input type="checkbox" class="lm-check" id="remember" name="remember">
                            <span>Recordarme</span>
                        </label>
                        <a href="#" class="lm-forgot" data-bs-toggle="modal" data-bs-target="#resetModal" data-bs-dismiss="modal">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <div class="lm-error d-none" id="loginError" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <span id="loginErrorMsg"></span>
                    </div>

                    <button type="submit" class="lm-btn" id="loginSubmit">
                        <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<style>
/* ── Modal card ── */
.lm-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(8,51,68,.22), 0 4px 16px rgba(0,0,0,.08);
}

/* ── Header ── */
.lm-header {
    background: linear-gradient(135deg, #083344 0%, #0c5f78 50%, #0891b2 100%);
    padding: 36px 32px 28px;
    text-align: center;
    position: relative;
}
.lm-close {
    position: absolute; top: 14px; right: 16px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    color: #fff; border-radius: 8px;
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: .85rem;
    transition: background .2s;
}
.lm-close:hover { background: rgba(255,255,255,.22); }

.lm-logo-wrap {
    width: 64px; height: 64px; border-radius: 16px;
    background: rgba(255,255,255,.15);
    border: 2px solid rgba(255,255,255,.25);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    overflow: hidden;
}
.lm-logo-img    { width: 100%; height: 100%; object-fit: contain; padding: 6px; }
.lm-logo-fallback { font-size: 1.6rem; color: #fb923c; }

.lm-title    { margin: 0; font-size: 1.15rem; font-weight: 800; color: #fff; }
.lm-subtitle { margin: 5px 0 0; font-size: .82rem; color: #a7f3f8; }

/* ── Body ── */
.lm-body { padding: 28px 32px 32px; background: #fff; }

.lm-field { margin-bottom: 18px; }
.lm-label {
    display: block; font-size: .78rem; font-weight: 700;
    color: #083344; text-transform: uppercase; letter-spacing: .4px;
    margin-bottom: 7px;
}

.lm-input-wrap {
    position: relative; display: flex; align-items: center;
}
.lm-input-icon {
    position: absolute; left: 13px;
    color: #0891b2; font-size: .85rem; pointer-events: none;
}
.lm-input {
    width: 100%;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    padding: 11px 42px 11px 36px;
    font-size: .92rem; color: #0f172a;
    background: #f8faff;
    outline: none;
    transition: border-color .2s, box-shadow .2s, background .2s;
}
.lm-input::placeholder { color: #b0b8c4; }
.lm-input:focus {
    border-color: #0891b2;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(8,145,178,.12);
}

.lm-eye {
    position: absolute; right: 10px;
    background: none; border: none; cursor: pointer;
    color: #9ca3af; font-size: .85rem; padding: 4px;
    transition: color .2s;
}
.lm-eye:hover { color: #0891b2; }

/* ── Row between ── */
.lm-row-between {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px;
}
.lm-check-label {
    display: flex; align-items: center; gap: 7px;
    font-size: .84rem; color: #374151; cursor: pointer;
}
.lm-check {
    width: 15px; height: 15px; accent-color: #0891b2; cursor: pointer;
}
.lm-forgot {
    font-size: .82rem; color: #0891b2; text-decoration: none; font-weight: 600;
    transition: color .2s;
}
.lm-forgot:hover { color: #f97316; text-decoration: underline; }

/* ── Error ── */
.lm-error {
    background: #fff3f3; border: 1px solid #fca5a5;
    border-radius: 8px; padding: 10px 14px;
    font-size: .84rem; color: #b91c1c;
    margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
}
.lm-error.d-none { display: none !important; }

/* ── Submit button ── */
.lm-btn {
    width: 100%;
    background: linear-gradient(135deg, #f97316, #fb923c);
    border: none; border-radius: 10px;
    color: #fff; font-size: .95rem; font-weight: 700;
    padding: 13px; cursor: pointer;
    box-shadow: 0 4px 14px rgba(249,115,22,.35);
    transition: all .2s ease;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.lm-btn:hover  { background: linear-gradient(135deg, #ea6c0a, #f97316); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(249,115,22,.45); }
.lm-btn:active { transform: translateY(0); }
.lm-btn:disabled { opacity: .65; cursor: not-allowed; transform: none; }

/* ── Backdrop blur ── */
.modal-backdrop { backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); background: rgba(8,51,68,.5); }
.modal-backdrop.show { opacity: 1; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Toggle contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const pwd  = document.getElementById('password');
        const icon = this.querySelector('i');
        const show = pwd.type === 'password';
        pwd.type = show ? 'text' : 'password';
        icon.classList.toggle('fa-eye',       !show);
        icon.classList.toggle('fa-eye-slash',  show);
    });

    // Submit AJAX
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const btn      = document.getElementById('loginSubmit');
        const errorDiv = document.getElementById('loginError');
        const errorMsg = document.getElementById('loginErrorMsg');

        btn.disabled   = true;
        btn.innerHTML  = '<i class="fas fa-spinner fa-spin"></i> Ingresando…';
        errorDiv.classList.add('d-none');

        fetch(this.action, {
            method:  'POST',
            body:    new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.csrf) {
                let inp = this.querySelector('input[name="' + data.csrf.tokenName + '"]');
                if (!inp) {
                    inp = document.createElement('input');
                    inp.type = 'hidden';
                    inp.name = data.csrf.tokenName;
                    this.appendChild(inp);
                }
                inp.value = data.csrf.hash;
            }

            if (data.success) {
                btn.innerHTML = '<i class="fas fa-check"></i> ¡Listo!';
                window.location.href = data.redirect || '<?= base_url() ?>';
            } else {
                errorMsg.textContent = data.message || 'Credenciales incorrectas.';
                errorDiv.classList.remove('d-none');
                btn.disabled  = false;
                btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Iniciar sesión';
            }
        })
        .catch(() => {
            errorMsg.textContent = 'Error de conexión. Intenta nuevamente.';
            errorDiv.classList.remove('d-none');
            btn.disabled  = false;
            btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Iniciar sesión';
        });
    });
});
</script>

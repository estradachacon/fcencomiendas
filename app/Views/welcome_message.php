<?= $this->extend('Layouts/mainbody_welcome') ?>
<?= $this->section('content') ?>

<!-- ══ HERO ══ -->
<div class="heroe bienvenida-encomiendas">
    <div class="heroe-inner">

        <div class="heroe-text">
            <div class="heroe-eyebrow">
                <i class="fas fa-box"></i> FC Encomiendas
            </div>
            <h1>Tu aliado logístico de confianza</h1>
            <p>Conectamos tus envíos con sus destinos de manera rápida, segura y rastreable. Cubrimos las principales rutas con puntualidad garantizada.</p>
            <div class="heroe-ctas">
                <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="btn-heroe-primary">
                    <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                </a>
                <a href="<?= base_url('/rutas') ?>" class="btn-heroe-secondary">
                    <i class="fas fa-route"></i> Nuestras rutas
                </a>
            </div>
        </div>

        <div class="heroe-cards">
            <div class="hf-card">
                <i class="fas fa-bolt"></i>
                <div>
                    <strong>Entregas rápidas</strong>
                    <span>Puntualidad garantizada en cada ruta</span>
                </div>
            </div>
            <div class="hf-card">
                <i class="fas fa-shield-alt"></i>
                <div>
                    <strong>100% Seguro</strong>
                    <span>Tus paquetes protegidos en todo momento</span>
                </div>
            </div>
        </div>

    </div>
</div>
</header>

<!-- ══ FEATURES ══ -->
<section class="feat-section">
    <div class="feat-section-inner">
        <div class="feat-title">¿Por qué elegir FC Encomiendas?</div>
        <div class="feat-sub">Brindamos el mejor servicio de encomiendas con tecnología y compromiso</div>
        <div class="feat-grid">

            <div class="feat-card">
                <div class="feat-icon" style="background:#fff3ea;">
                    <i class="fas fa-clock" style="color:#f97316;"></i>
                </div>
                <h3>Entregas puntuales</h3>
                <p>Contamos con rutas optimizadas y motoristas comprometidos para que tu paquete llegue a tiempo.</p>
            </div>

            <div class="feat-card">
                <div class="feat-icon" style="background:#e0f7fa;">
                    <i class="fas fa-lock" style="color:#0891b2;"></i>
                </div>
                <h3>Seguridad total</h3>
                <p>Cada paquete es registrado y monitoreado desde su recolección hasta su entrega final.</p>
            </div>

            <div class="feat-card">
                <div class="feat-icon" style="background:#fff3ea;">
                    <i class="fas fa-headset" style="color:#f97316;"></i>
                </div>
                <h3>Atención personalizada</h3>
                <p>Nuestro equipo está disponible para resolver cualquier consulta sobre tus envíos.</p>
            </div>

        </div>
    </div>
</section>

<!-- ══ CAROUSEL ══ -->
<?php if ($images): ?>
<section class="carousel-section">
    <div class="carousel-section-inner">
        <div class="carousel-section-title">Galería</div>
        <div id="welcomeCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($images as $index => $img): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= base_url('upload/content/' . $img->image) ?>"
                            class="d-block w-100"
                            style="object-fit: contain; max-height: 420px;"
                            alt="<?= esc($img->caption) ?>">
                        <?php if ($img->caption): ?>
                            <div class="carousel-caption d-none d-md-block">
                                <h5><?= esc($img->caption) ?></h5>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ══ REDES SOCIALES ══ -->
<div class="further">
    <section class="social-cards">
        <h1>Síguenos en redes sociales</h1>
        <div class="social-grid">
            <a href="https://www.facebook.com/fc.encomiendas.2025" target="_blank" class="social-card facebook">
                <i class="fab fa-facebook-f"></i>
                <span>Facebook</span>
            </a>
            <a href="https://www.instagram.com/fc_encomiendas/" target="_blank" class="social-card instagram">
                <i class="fab fa-instagram"></i>
                <span>Instagram</span>
            </a>
            <a href="https://www.tiktok.com/@fcencomiendas" target="_blank" class="social-card tiktok">
                <i class="fab fa-tiktok"></i>
                <span>TikTok</span>
            </a>
        </div>
    </section>
</div>

<!-- ══ FOOTER ══ -->
<footer class="main-footer">
    <div class="copyrights">
        <p>&reg; <?= date('Y') ?> FC Encomiendas. Todos los derechos reservados.</p>
    </div>
</footer>

<?= $this->endSection() ?>

<?= $this->extend('Layouts/mainbody_welcome') ?>
<?= $this->section('content') ?>

<div class="page-banner">
    <div class="page-banner-eyebrow"><i class="fas fa-users mr-1"></i> Nuestra empresa</div>
    <h1>Quiénes Somos</h1>
    <p>En FC Encomiendas nos dedicamos a conectar personas y negocios en todo El Salvador con un servicio rápido, seguro y confiable.</p>
</div>

<!-- Valores -->
<section class="pub-section">
    <div class="pub-section-inner">
        <div class="pub-section-title">Nuestros Valores</div>
        <div class="pub-section-sub">Los principios que guían cada envío que realizamos</div>

        <div style="display:grid; grid-template-columns: repeat(3,1fr); gap:20px;">

            <div class="value-card">
                <div class="value-icon" style="background:#fff3ea;">
                    <i class="fas fa-bolt" style="color:#f97316;"></i>
                </div>
                <h4>Entrega Rápida</h4>
                <p>Rutas optimizadas y motoristas comprometidos para que tu paquete llegue puntualmente a su destino.</p>
            </div>

            <div class="value-card">
                <div class="value-icon" style="background:#e0f9f9;">
                    <i class="fas fa-shield-alt" style="color:#0891b2;"></i>
                </div>
                <h4>Seguridad Total</h4>
                <p>Cada paquete es registrado y monitoreado desde su recolección hasta la entrega final. Cero riesgos.</p>
            </div>

            <div class="value-card">
                <div class="value-icon" style="background:#fff3ea;">
                    <i class="fas fa-handshake" style="color:#f97316;"></i>
                </div>
                <h4>Compromiso</h4>
                <p>Tu satisfacción es nuestra prioridad. Atención personalizada y seguimiento en cada envío que realizas.</p>
            </div>

            <div class="value-card">
                <div class="value-icon" style="background:#e0f9f9;">
                    <i class="fas fa-map-marked-alt" style="color:#0891b2;"></i>
                </div>
                <h4>Amplia Cobertura</h4>
                <p>Llegamos a las principales ciudades y municipios de El Salvador con rutas frecuentes y confiables.</p>
            </div>

            <div class="value-card">
                <div class="value-icon" style="background:#fff3ea;">
                    <i class="fas fa-search-location" style="color:#f97316;"></i>
                </div>
                <h4>Rastreabilidad</h4>
                <p>Seguimiento en tiempo real para que siempre sepas en qué etapa se encuentra tu encomienda.</p>
            </div>

            <div class="value-card">
                <div class="value-icon" style="background:#e0f9f9;">
                    <i class="fas fa-headset" style="color:#0891b2;"></i>
                </div>
                <h4>Atención al Cliente</h4>
                <p>Equipo disponible para resolver tus consultas y garantizar la mejor experiencia en cada interacción.</p>
            </div>

        </div>
    </div>
</section>

<!-- Misión y Visión -->
<section class="pub-section alt">
    <div class="pub-section-inner">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; align-items:start;">

            <div>
                <div class="pub-section-title" style="text-align:left; margin-bottom:24px;">Misión &amp; Visión</div>
                <div class="mv-block">
                    <h3><i class="fas fa-bullseye"></i> Nuestra Misión</h3>
                    <p>Ofrecer un servicio de encomiendas que combine rapidez, seguridad y confianza, conectando personas y negocios de manera eficiente y profesional en todo El Salvador.</p>
                </div>
                <div class="mv-block" style="border-left-color:#f97316;">
                    <h3><i class="fas fa-eye" style="color:#f97316;"></i> Nuestra Visión</h3>
                    <p>Ser líderes en logística de encomiendas en El Salvador, reconocidos por nuestra confiabilidad, cobertura y excelencia en el servicio al cliente.</p>
                </div>
                <div class="mv-block">
                    <h3><i class="fas fa-star"></i> Nuestro Compromiso</h3>
                    <p>Superar constantemente las expectativas de nuestros clientes con innovación, tecnología y el mejor equipo humano del sector logístico.</p>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:16px;">
                <div style="background: linear-gradient(135deg,#083344,#0891b2); border-radius:16px; padding:32px 28px; color:#fff; text-align:center;">
                    <i class="fas fa-box-open" style="font-size:2.5rem; color:#fb923c; margin-bottom:14px; display:block;"></i>
                    <div style="font-size:2.2rem; font-weight:800; line-height:1;">Miles</div>
                    <div style="color:#a7f3f8; font-size:.9rem; margin-top:4px;">de paquetes entregados</div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:20px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,.05);">
                        <i class="fas fa-route" style="font-size:1.5rem; color:#0891b2; display:block; margin-bottom:8px;"></i>
                        <div style="font-weight:800; color:#083344; font-size:1.1rem;">Múltiples</div>
                        <div style="font-size:.78rem; color:#6b7280;">Rutas activas</div>
                    </div>
                    <div style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:20px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,.05);">
                        <i class="fas fa-smile" style="font-size:1.5rem; color:#f97316; display:block; margin-bottom:8px;"></i>
                        <div style="font-weight:800; color:#083344; font-size:1.1rem;">100%</div>
                        <div style="font-size:.78rem; color:#6b7280;">Clientes satisfechos</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
@media (max-width: 768px) {
    .pub-section-inner > div[style*="grid-template-columns: repeat(3"] {
        grid-template-columns: 1fr !important;
    }
    .pub-section.alt .pub-section-inner > div {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?= $this->endSection() ?>

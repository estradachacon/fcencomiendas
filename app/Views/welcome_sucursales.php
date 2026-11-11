<?= $this->extend('Layouts/mainbody_welcome') ?>
<?= $this->section('content') ?>

<div class="page-banner">
    <div class="page-banner-eyebrow"><i class="fas fa-map-marker-alt mr-1"></i> Dónde estamos</div>
    <h1>Nuestras Ubicaciones</h1>
    <p>Visítanos en nuestras sucursales o contáctanos para coordinar la recolección de tu paquete.</p>
</div>

<section class="pub-section">
    <div class="pub-section-inner">
        <?php if ($branches): ?>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap:24px;">
                <?php foreach ($branches as $branch): ?>
                    <div class="branch-card">
                        <div class="branch-card-hdr">
                            <i class="fas fa-store"></i>
                            <div>
                                <h5><?= esc($branch->branch_name) ?></h5>
                                <p><?= esc($branch->branch_direction) ?></p>
                            </div>
                        </div>
                        <div id="map-<?= $branch->id ?>" class="branch-card-map"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center text-muted py-5">
                <i class="fas fa-store fa-2x mb-3 d-block" style="color:#0891b2;opacity:.4;"></i>
                No hay sucursales disponibles.
            </div>
        <?php endif; ?>
    </div>
</section>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    <?php foreach ($branches as $branch): ?>
    (function() {
        const lat   = <?= $branch->latitude  ?: '13.6929' ?>;
        const lng   = <?= $branch->longitude ?: '-89.2182' ?>;
        const map   = L.map('map-<?= $branch->id ?>').setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
        }).addTo(map);
        L.marker([lat, lng]).addTo(map)
            .bindPopup('<strong><?= esc($branch->branch_name) ?></strong><br><?= esc($branch->branch_direction) ?>')
            .openPopup();
    })();
    <?php endforeach; ?>
</script>

<?= $this->endSection() ?>

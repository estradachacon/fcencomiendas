<?= $this->extend('Layouts/mainbody_welcome') ?>
<?= $this->section('content') ?>

<div class="page-banner">
    <div class="page-banner-eyebrow"><i class="fas fa-route mr-1"></i> Cobertura</div>
    <h1>Nuestras Rutas</h1>
    <p>Cobertura en las principales zonas del país. Encuentra la ruta más cercana a ti.</p>
</div>

<section class="pub-section">
    <div class="pub-section-inner">
        <?php if ($groups): ?>
            <?php foreach ($groups as $group): ?>
                <div class="pub-group-title">
                    <i class="fas fa-map-signs mr-2" style="color:#0891b2;"></i><?= esc($group->title) ?>
                </div>
                <div class="pub-img-grid">
                    <?php if ($group->images): ?>
                        <?php foreach ($group->images as $img): ?>
                            <div class="pub-img-card"
                                data-bs-toggle="modal"
                                data-bs-target="#imageModal"
                                data-img="<?= base_url('upload/content/' . $img->image) ?>"
                                data-caption="<?= esc($img->caption) ?>">
                                <img src="<?= base_url('upload/content/' . $img->image) ?>"
                                    alt="<?= esc($img->caption) ?>">
                                <?php if ($img->caption): ?>
                                    <div class="pub-img-caption"><?= esc($img->caption) ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted" style="grid-column:1/-1;">Sin imágenes en este grupo.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center text-muted py-5">
                <i class="fas fa-map fa-2x mb-3 d-block" style="color:#0891b2;opacity:.4;"></i>
                No hay rutas disponibles por el momento.
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Modal imagen ampliada -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 overflow-hidden" style="border-radius:14px;">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal" style="z-index:10; background-color:rgba(255,255,255,.8);"></button>
                <img src="" id="modalImage" class="w-100" style="max-height:80vh; object-fit:contain; display:block;">
                <p class="text-center py-2 mb-0 text-muted small" id="modalCaption"></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('imageModal').addEventListener('show.bs.modal', function(e) {
        document.getElementById('modalImage').src   = e.relatedTarget.dataset.img;
        document.getElementById('modalCaption').textContent = e.relatedTarget.dataset.caption || '';
    });
</script>

<?= $this->endSection() ?>

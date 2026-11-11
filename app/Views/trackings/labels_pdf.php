<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Viñetas #<?= esc($tracking->id) ?></title>
<style>
@page {
    size: 50.8mm 25.4mm;
    margin: 1.5mm 2mm;
}
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; }

.label        { width: 100%; }
.label-break  { page-break-after: always; }

.lbl-table {
    width: 100%;
    border-collapse: collapse;
    border: 0.3pt solid #ccc;
    table-layout: fixed;
}

.lbl-left {
    vertical-align: middle;
    padding: 1mm 1.5mm 1mm 2mm;
    border-right: 0.3pt solid #ddd;
}

.lbl-right {
    vertical-align: middle;
    text-align: center;
    padding: 0.5mm;
    width: 21mm;
}

.brand     { font-size: 3pt; color: #3a5298; letter-spacing: 0.4pt; font-weight: bold; }
.sep       { border: none; border-top: 0.3pt solid #e8e8e8; margin: 0.8mm 0; }
.v-lbl     { font-size: 2.2pt; color: #bbb; text-transform: uppercase; letter-spacing: 0.3pt; }
.v-name    { font-size: 4.5pt; font-weight: bold; color: #666; word-break: break-all; }
.c-lbl     { font-size: 2.2pt; color: #bbb; text-transform: uppercase; letter-spacing: 0.3pt; margin-top: 0.8mm; display: block; }
.c-name    { font-size: 7.5pt; font-weight: bold; color: #0e1525; line-height: 1.15; word-break: break-all; }

.qr-img    { width: 18.5mm; height: 18.5mm; }
.qr-txt    { font-size: 2.5pt; color: #aaa; font-family: Courier, monospace; margin-top: 0.4mm; letter-spacing: 0.2pt; }
</style>
</head>
<body>

<?php $lastIdx = array_key_last($paquetes); foreach ($paquetes as $idx => $p): ?>
<div class="label<?= $idx !== $lastIdx ? ' label-break' : '' ?>">
    <table class="lbl-table">
        <tr>
            <td class="lbl-left" width="25mm">
                <div class="brand">FC ENCOMIENDAS</div>
                <div class="sep"></div>
                <div class="v-lbl">Vendedor</div>
                <div class="v-name"><?= esc(mb_strimwidth($p['vendedor'], 0, 30, '…')) ?></div>
                <span class="c-lbl">Cliente</span>
                <div class="c-name"><?= esc(mb_strimwidth($p['cliente'], 0, 20, '…')) ?></div>
            </td>
            <td class="lbl-right" width="21mm">
                <?php if (!empty($p['qr_svg'])): ?>
                    <img src="<?= $p['qr_svg'] ?>" class="qr-img" alt="QR">
                <?php endif; ?>
                <div class="qr-txt"><?= esc($p['qr_code']) ?></div>
            </td>
        </tr>
    </table>
</div>
<?php endforeach; ?>

</body>
</html>

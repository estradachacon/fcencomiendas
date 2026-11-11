<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Viñeta #<?= esc($package['id']) ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #e8e8e8;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px 16px;
            min-height: 100vh;
        }

        /* ── Botones (solo pantalla) ── */
        .actions {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
        }
        .actions button, .actions a {
            padding: 9px 20px; border: none; border-radius: 6px;
            cursor: pointer; font-size: 14px; font-weight: 700;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-print { background: #1d2744; color: #fff; }
        .btn-close  { background: #6c757d; color: #fff; }

        /* ── Caja de previsualización (pantalla, 3× real) ── */
        .preview-shell {
            background: #fff;
            box-shadow: 0 6px 24px rgba(0,0,0,.2);
            border-radius: 6px;
            width:  6in;
            height: 3in;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* ── La viñeta real: 2in × 1in, escalada 3× en pantalla ── */
        .label {
            width:  2in;
            height: 1in;
            transform: scale(3);
            transform-origin: center center;

            display: flex;
            flex-direction: row;
            align-items: stretch;
            border: 0.3pt solid #ccc;
            background: #fff;
        }

        /* ── Columna izquierda: texto ── */
        .label-text {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2mm 1.5mm 2mm 2.5mm;
            border-right: 0.3pt solid #ddd;
            overflow: hidden;
        }

        /* Bloque empresa */
        .brand-block { display: flex; flex-direction: column; }
        .brand-fc {
            font-size: 7pt;
            font-weight: 900;
            color: #1d2744;
            line-height: 1.0;
        }
        .brand-enc {
            font-size: 3pt;
            font-weight: 700;
            letter-spacing: 1.5pt;
            color: #3a5298;
            margin-top: 0.3mm;
        }

        /* Línea separadora */
        .label-divider {
            height: 0.3pt;
            background: #ccc;
            margin: 0;
        }

        /* Bloque vendedor + cliente */
        .meta-row {
            display: flex;
            flex-direction: column;
            gap: 1.2mm;
        }
        .meta-group {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .meta-label {
            font-size: 2.2pt;
            color: #bbb;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }
        .meta-value {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            font-weight: 800;
        }
        .meta-value.vendor { font-size: 5pt;   color: #444; }
        .meta-value.client { font-size: 7.5pt; color: #1d2744; }

        /* ── Columna derecha: QR ── */
        .label-qr-wrap {
            width: 21mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1mm 1.5mm;
            gap: 0.8mm;
        }

        /* qrcodejs genera canvas + img: ocultamos el img duplicado */
        #label-qr img { display: none !important; }
        #label-qr canvas {
            display: block !important;
            width:  16mm !important;
            height: 16mm !important;
        }

        /* Código de texto bajo el QR */
        .qr-code-label {
            font-size: 3pt;
            color: #555;
            letter-spacing: 0.5pt;
            text-align: center;
            font-family: monospace;
            line-height: 1;
        }

        /* ── Impresión ── */
        @media print {
            @page { size: 2in 1in landscape; margin: 0; }

            body { background: none; padding: 0; display: block; }
            .actions { display: none; }

            .preview-shell {
                box-shadow: none; border-radius: 0;
                width: 2in; height: 1in;
            }
            .label {
                transform: none;
                width:  2in;
                height: 1in;
            }
        }
    </style>
</head>
<body>

    <div class="actions">
        <button class="btn-print" onclick="window.print()">🖨️ Imprimir viñeta</button>
        <a class="btn-close" href="javascript:window.close()">✕ Cerrar</a>
    </div>

    <div class="preview-shell">
        <div class="label">

            <!-- Izquierda: empresa + vendedor + cliente -->
            <div class="label-text">
                <div class="brand-block">
                    <div class="brand-fc">FC</div>
                    <div class="brand-enc">ENCOMIENDAS</div>
                </div>

                <div class="label-divider"></div>

                <div class="meta-row">
                    <div class="meta-group">
                        <span class="meta-label">Vendedor</span>
                        <span class="meta-value vendor"><?= esc($package['seller_name'] ?? '—') ?></span>
                    </div>
                    <div class="meta-group">
                        <span class="meta-label">Cliente</span>
                        <span class="meta-value client"><?= esc($package['cliente']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Derecha: QR + código -->
            <div class="label-qr-wrap">
                <div id="label-qr"></div>
                <div class="qr-code-label"><?= esc($package['qr_code']) ?></div>
            </div>

        </div>
    </div>

    <script>
        new QRCode(document.getElementById('label-qr'), {
            text: '<?= esc($package['qr_code']) ?>',
            width:  64,
            height: 64,
            colorDark:  '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>

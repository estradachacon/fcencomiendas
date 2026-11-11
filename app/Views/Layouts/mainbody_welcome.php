<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bienvenido a FC Encomiendas</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- STYLES -->
    <style {csp-style-nonce}>
        * {
            transition: background-color 300ms ease, color 300ms ease;
        }

        *:focus {
            background-color: rgba(65, 129, 214, 0.2);
            outline: none;
        }

        html,
        body {
            color: rgba(33, 37, 41, 1);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            font-size: 16px;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        header {
            background-color: rgba(247, 248, 249, 1);
            padding: .4rem 0 0;
        }

        .bienvenida-encomiendas {
            background: linear-gradient(135deg, #083344 0%, #0c5f78 50%, #0891b2 100%);
        }

        .menu {
            padding: .4rem 2rem;
        }

        header ul {
            border-bottom: 1px solid rgba(72, 118, 177, 0.68);
            list-style-type: none;
            margin: 0;
            overflow: hidden;
            padding: 0;
            text-align: right;
        }

        header li {
            display: inline-block;
        }

        header li a {
            border-radius: 5px;
            color: rgba(0, 0, 0, .5);
            display: block;
            height: 44px;
            text-decoration: none;
        }

        header li.menu-item a {
            border-radius: 5px;
            margin: 5px 0;
            height: 38px;
            line-height: 36px;
            width: 160px;
            /* padding: .4rem .65rem; */
            text-align: center;
        }

        header li.menu-item a:hover,
        header li.menu-item a:focus {
            background-color: rgba(20, 114, 221, 0.2);
            color: rgba(24, 22, 22, 1);
            border-radius: 12px;
        }

        header .logo {
            float: left;
            height: 44px;
            padding: .4rem .5rem;
        }

        header .menu-toggle {
            display: none;
            float: right;
            font-size: 2rem;
            font-weight: bold;
        }

        header .menu-toggle button {
            background-color: rgba(42, 136, 212, 0.9);
            border: none;
            border-radius: 8px;
            color: rgba(255, 255, 255, 1);
            cursor: pointer;
            font: inherit;
            font-size: 1.5rem;
            height: 40px;
            padding: 0;
            margin: 11px 0;
            overflow: visible;
            width: 40px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        header .menu-toggle button:hover,
        header .menu-toggle button:focus {
            background-color: rgba(45, 101, 138, 1);
            color: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        header .heroe {
            padding: 0;
            max-width: 100%;
            margin: 0;
        }

        /* ── Hero interior ── */
        .heroe-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 64px 1.75rem 72px;
            display: flex;
            align-items: center;
            gap: 56px;
        }

        .heroe-text   { flex: 1 1 55%; }
        .heroe-cards  { flex: 1 1 40%; display: flex; flex-direction: column; gap: 14px; }

        .heroe-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.22);
            color: #a7f3f8; font-size: .78rem; font-weight: 600;
            letter-spacing: .4px; text-transform: uppercase;
            padding: 5px 14px; border-radius: 20px; margin-bottom: 20px;
        }

        .heroe-text h1 {
            font-size: 2.6rem; font-weight: 800;
            color: #fff; line-height: 1.2;
            margin-bottom: 16px;
        }

        .heroe-text p {
            font-size: 1.05rem; color: #b2eef5;
            line-height: 1.7; margin-bottom: 32px; max-width: 480px;
        }

        .heroe-ctas { display: flex; gap: 12px; flex-wrap: wrap; }

        .btn-heroe-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: #f97316; color: #fff;
            font-weight: 700; font-size: .95rem;
            padding: 12px 28px; border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(249,115,22,.4);
            transition: all .2s ease;
        }
        .btn-heroe-primary:hover { background: #ea6c0a; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(249,115,22,.5); text-decoration: none; }

        .btn-heroe-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.3);
            color: #fff; font-weight: 600; font-size: .95rem;
            padding: 12px 24px; border-radius: 8px;
            text-decoration: none;
            transition: all .2s ease;
        }
        .btn-heroe-secondary:hover { background: rgba(255,255,255,.18); color: #fff; text-decoration: none; }

        /* Feature cards en el hero */
        .hf-card {
            display: flex; align-items: center; gap: 14px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 12px; padding: 16px 20px;
            transition: background .2s;
        }
        .hf-card:hover { background: rgba(255,255,255,.13); }
        .hf-card i { font-size: 1.5rem; color: #fb923c; flex-shrink: 0; }
        .hf-card strong { display: block; color: #fff; font-size: .95rem; }
        .hf-card span   { display: block; color: #a5e9f0; font-size: .82rem; margin-top: 2px; }

        /* ── Sección features ── */
        .feat-section {
            background: #fff; padding: 60px 1.75rem;
        }
        .feat-section-inner {
            max-width: 1100px; margin: 0 auto;
        }
        .feat-title {
            text-align: center; font-size: 1.6rem; font-weight: 800;
            color: #083344; margin-bottom: 8px;
        }
        .feat-sub {
            text-align: center; color: #6b7280; font-size: .95rem;
            margin-bottom: 44px;
        }
        .feat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .feat-card {
            border: 1px solid #e5e7eb; border-radius: 14px;
            padding: 32px 24px; text-align: center;
            transition: all .25s ease;
        }
        .feat-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.1); transform: translateY(-4px); border-color: #c8d8f0; }
        .feat-icon {
            width: 56px; height: 56px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin: 0 auto 16px;
        }
        .feat-card h3 { font-size: 1.05rem; font-weight: 700; color: #0e1525; margin-bottom: 8px; }
        .feat-card p  { font-size: .88rem; color: #6b7280; line-height: 1.6; margin: 0; }

        /* Carousel mejorado */
        .carousel-section {
            background: #f8faff; padding: 48px 1.75rem;
        }
        .carousel-section-inner { max-width: 900px; margin: 0 auto; }
        .carousel-section-title {
            text-align: center; font-size: 1.3rem; font-weight: 700;
            color: #0e1525; margin-bottom: 24px;
        }
        #welcomeCarousel .carousel-item img {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,.12);
        }

        @media (max-width: 768px) {
            .heroe-inner {
                flex-direction: column; gap: 32px;
                padding: 40px 1.25rem 48px;
            }
            .heroe-text h1 { font-size: 1.75rem; }
            .heroe-cards   { width: 100%; }
            .feat-grid     { grid-template-columns: 1fr; gap: 16px; }
            .feat-section  { padding: 40px 1.25rem; }
        }

        /* ══ Páginas internas (rutas, ubicación, quiénes somos) ══ */

        .page-banner {
            background: linear-gradient(135deg, #083344 0%, #0c5f78 50%, #0891b2 100%);
            color: #fff; padding: 52px 1.75rem; text-align: center;
        }
        .page-banner-eyebrow {
            display: inline-block;
            background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.22);
            color: #a7f3f8; font-size: .72rem; font-weight: 600;
            letter-spacing: .5px; text-transform: uppercase;
            padding: 4px 14px; border-radius: 20px; margin-bottom: 14px;
        }
        .page-banner h1 { font-size: 2rem; font-weight: 800; margin-bottom: 10px; }
        .page-banner p  { color: #b2eef5; font-size: .98rem; margin: 0 auto; max-width: 540px; line-height: 1.6; }

        .pub-section { padding: 56px 1.75rem; background: #fff; }
        .pub-section.alt { background: #f0f9ff; }
        .pub-section-inner { max-width: 1100px; margin: 0 auto; }
        .pub-section-title { font-size: 1.45rem; font-weight: 800; color: #083344; margin-bottom: 6px; text-align: center; }
        .pub-section-sub   { color: #6b7280; font-size: .9rem; text-align: center; margin-bottom: 36px; }

        .pub-group-title {
            font-size: 1.15rem; font-weight: 700; color: #083344;
            border-left: 4px solid #0891b2; padding-left: 12px;
            margin-bottom: 20px;
        }

        .pub-img-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px; margin-bottom: 48px;
        }
        .pub-img-card {
            border: 1px solid #e5e7eb; border-radius: 12px;
            overflow: hidden; background: #fff; cursor: pointer;
            transition: all .25s ease;
        }
        .pub-img-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.12); transform: translateY(-4px); border-color: #7dd3e8; }
        .pub-img-card img { width: 100%; height: 190px; object-fit: cover; display: block; }
        .pub-img-caption { padding: 10px 14px; font-size: .82rem; color: #374151; text-align: center; border-top: 1px solid #f3f4f6; }

        .branch-card {
            border: 1px solid #e5e7eb; border-radius: 14px;
            overflow: hidden; background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }
        .branch-card-hdr {
            background: linear-gradient(135deg, #083344, #0891b2);
            color: #fff; padding: 18px 22px;
            display: flex; align-items: center; gap: 12px;
        }
        .branch-card-hdr i { font-size: 1.3rem; color: #fb923c; flex-shrink: 0; }
        .branch-card-hdr h5 { margin: 0; font-size: 1rem; font-weight: 700; }
        .branch-card-hdr p  { margin: 3px 0 0; font-size: .82rem; color: #a7f3f8; }
        .branch-card-map { height: 230px; }

        .value-card {
            border: 1px solid #e5e7eb; border-radius: 14px;
            padding: 30px 22px; text-align: center; background: #fff;
            transition: all .25s ease;
        }
        .value-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.09); transform: translateY(-4px); border-color: #7dd3e8; }
        .value-icon {
            width: 58px; height: 58px; border-radius: 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.45rem; margin: 0 auto 16px;
        }
        .value-card h4 { font-size: 1rem; font-weight: 700; color: #083344; margin-bottom: 8px; }
        .value-card p  { font-size: .86rem; color: #6b7280; line-height: 1.65; margin: 0; }

        .mv-block {
            background: #fff; border-radius: 14px; padding: 28px 30px;
            border-left: 4px solid #0891b2; margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,.05);
        }
        .mv-block h3 { font-size: 1.05rem; font-weight: 800; color: #083344; margin-bottom: 8px;
            display: flex; align-items: center; gap: 8px;
        }
        .mv-block h3 i { color: #0891b2; }
        .mv-block p { color: #374151; font-size: .9rem; line-height: 1.75; margin: 0; }

        @media (max-width: 768px) {
            .page-banner { padding: 36px 1.25rem; }
            .page-banner h1 { font-size: 1.5rem; }
            .pub-section  { padding: 36px 1.25rem; }
            .pub-img-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        }
        @media (max-width: 480px) {
            .pub-img-grid { grid-template-columns: 1fr; }
        }

        section {
            margin: 0 auto;
            max-width: 1100px;
            padding: 2.5rem 1.75rem 3.5rem 1.75rem;
        }

        section h1 {
            margin-bottom: 2.5rem;
        }

        section h2 {
            font-size: 120%;
            line-height: 2.5rem;
            padding-top: 1.5rem;
        }

        section pre {
            background-color: rgba(247, 248, 249, 1);
            border: 1px solid rgba(242, 242, 242, 1);
            display: block;
            font-size: .9rem;
            margin: 2rem 0;
            padding: 1rem 1.5rem;
            white-space: pre-wrap;
            word-break: break-all;
        }

        section code {
            display: block;
        }

        section a {
            color: rgba(221, 72, 20, 1);
        }

        section svg {
            margin-bottom: -5px;
            margin-right: 5px;
            width: 25px;
        }

        .further {
            background-color: rgba(247, 248, 249, 1);
            border-bottom: 1px solid rgba(242, 242, 242, 1);
            border-top: 1px solid rgba(242, 242, 242, 1);
        }

        .further h2:first-of-type {
            padding-top: 0;
        }

        .svg-stroke {
            fill: none;
            stroke: #000;
            stroke-width: 32px;
        }

        footer {
            background-color: rgba(18, 104, 185, 0.2);
            text-align: center;
        }

        footer .environment {
            color: rgba(83, 81, 81, 1);
            padding: 2rem 1.75rem;
        }

        footer .copyrights {
            background-color: rgba(62, 62, 62, 1);
            color: rgba(200, 200, 200, 1);
            padding: .25rem 1.75rem;
        }

        @media (max-width: 629px) {
            header .menu {
                padding: 0;
                height: 60px;
                position: relative;
                background-color: rgba(247, 248, 249, 1);
            }

            .logo-badge {
                padding: 4px 10px;
                border-radius: 12px;
            }

            .logo-badge img.logo {
                height: 40px;
            }

            header .menu-header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                padding: 0.5rem 1rem;
                background-color: rgba(247, 248, 249, 1);
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            header .logo {
                height: 44px;
                padding: 0;
            }

            header .menu-toggle {
                display: block;
                margin: 0;
                padding: 0;
            }

            header .menu-toggle button {
                margin: 0;
                padding: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            header .menu-list {
                position: fixed;
                top: 60px;
                left: 0;
                right: 0;
                background-color: rgba(247, 248, 249, 0.98);
                padding: 20px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease-in-out;
                z-index: 1100;
            }

            header .menu-list.hidden {
                opacity: 0;
                visibility: hidden;
                transform: translateY(-100%);
            }

            header .menu-list li.menu-item {
                display: block;
                margin: 10px 0;
                width: 100%;
            }

            header li.menu-item a {
                text-align: center;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 44px;
                color: rgba(0, 0, 0, 0.8);
                font-weight: 500;
                background-color: rgba(42, 136, 212, 0.1);
                border-radius: 8px;
                transition: all 0.2s ease;
            }

            header li.menu-item a:hover,
            header li.menu-item a:focus {
                background-color: rgba(45, 101, 138, 0.9);
                color: white;
                transform: translateY(-2px);
            }

            /* Ocultar elementos del menú toggle y logo que se duplican */
            header .menu-list .logo,
            header .menu-list .menu-toggle {
                display: none;
            }
        }

        .social-cards {
            text-align: center;
            padding: 30px 15px;
        }

        .social-cards h1 {
            margin-bottom: 25px;
            font-weight: 600;
        }

        .social-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .social-card {
            width: 160px;
            height: 120px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }

        .social-card i {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .social-card span {
            font-weight: 500;
            font-size: 15px;
        }

        /* 🎯 Hover */
        .social-card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.25);
            color: #fff;
        }

        /* 🎨 Colores por red */
        .social-card.facebook:hover {
            background: #4267B2;
        }

        .social-card.instagram:hover {
            background: linear-gradient(45deg, #f58529, #dd2a7b, #8134af);
        }

        .social-card.tiktok:hover {
            background: linear-gradient(45deg, #000, #25F4EE);
        }

        /* ✨ Mejora visual SIN cambiar layout */
        /* 🎯 Texto visible y centrado SIEMPRE */
        header li.menu-item a {
            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 500;
            letter-spacing: 0.3px;
            color: rgba(29, 39, 68, 0.85);
            /* visible sin hover */

            background-color: rgba(42, 136, 212, 0.08);
            border: 1px solid rgba(42, 136, 212, 0.18);

            transition: all 0.25s ease;
        }

        /* ✨ Hover elegante */
        header li.menu-item a:hover,
        header li.menu-item a:focus {
            color: #ffffff;
            background: linear-gradient(135deg,
                    rgba(42, 136, 212, 0.85),
                    rgba(29, 39, 68, 0.9));

            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(29, 39, 68, 0.35);
        }

        /* Línea animada inferior */
        header li.menu-item a::after {
            content: "";
            position: absolute;
            bottom: 6px;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #ffffff, #cfe2ff);
            border-radius: 4px;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        header li.menu-item a:hover::after {
            width: 55%;
        }

        .fancy-menu .menu-item a {
            display: block;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        /* ✨ Hover bonito */
        .fancy-menu .menu-item a:hover {
            background: linear-gradient(135deg, #4267B2, #1d2744);
            transform: translateX(6px) scale(1.03);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
            color: #fff;
        }

        /* 🟡 Item especial (login) */
        .fancy-menu .menu-item:last-child a {
            background: rgba(255, 193, 7, 0.15);
            border: 1px solid rgba(255, 193, 7, 0.35);
        }

        .fancy-menu .menu-item:last-child a:hover {
            background: #ffc107;
            color: #1d2744;
        }

        /* 🏷️ Logo tipo badge */
        .logo-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            background: #ffffff;
            padding: 6px 12px;
            border-radius: 14px;

            border: 1px solid rgba(42, 136, 212, 0.25);
            box-shadow:
                0 6px 16px rgba(0, 0, 0, 0.12),
                0 0 0 0 rgba(42, 136, 212, 0.0);

            transition: all 0.35s ease;
        }

        /* Imagen del logo */
        .logo-badge img.logo {
            height: 44px;
            width: auto;
            display: block;
            transition: transform 0.35s ease;
        }

        .logo-badge:hover {
            transform: translateY(-2px);
            box-shadow:
                0 10px 28px rgba(0, 0, 0, 0.18),
                0 0 0 6px rgba(42, 136, 212, 0.15);
        }

        .logo-badge:hover img.logo {
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <header>
        <div class="menu">
            <div class="menu-header">
                <div class="logo logo-badge">

                    <a href="<?= base_url() ?>">
                        <!-- LOGO EMPRESA -->
                        <?php if (setting('logo')): ?>
                            <img class="logo shadow-sm"
                                src="<?= base_url('upload/settings/' . setting('logo')) ?>"
                                alt="logo-company"
                                height="44">
                    </a>
                <?php else: ?>
                    <a href="<?= base_url() ?>" class="text-decoration-none">
                        <h2 class="m-0 p-0">FC Encomiendas</h2>
                    </a>
                <?php endif; ?>
                </div>
                <div class="menu-toggle">
                    <button id="menuToggle" aria-expanded="false" aria-label="Menú principal">&#9776;</button>
                </div>
            </div>
            <ul class="menu-list hidden fancy-menu" id="mainMenu">
                <li class="menu-item"><a href="<?= base_url('/rutas') ?>">Nuestras rutas</a></li>
                <li class="menu-item"><a href="<?= base_url('/sucursales') ?>">Ubicación</a></li>
                <li class="menu-item"><a href="<?= base_url('/quienes-somos') ?>">Quienes somos</a></li>
                <li class="menu-item">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Iniciar sesión
                    </a>
                </li>
            </ul>

        </div>
        <!-- CONTENT -->
        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
        <!-- Include del Modal de Login -->
        <?= $this->include('modals/login') ?>
        <?= $this->include('modals/reset1') ?>
        <!-- SCRIPTS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script {csp-script-nonce}>
            // Script para el menú
            document.getElementById("menuToggle").addEventListener('click', toggleMenu);

            function toggleMenu() {
                var menuList = document.querySelector('.menu-list');
                menuList.classList.toggle("hidden");
                // Accesibilidad: Actualizar el estado del botón
                var menuButton = document.getElementById("menuToggle");
                var isExpanded = menuList.classList.contains("hidden") ? "false" : "true";
                menuButton.setAttribute("aria-expanded", isExpanded);
            }
            // Cerrar el menú al hacer clic fuera
            document.addEventListener('click', function(event) {
                var menu = document.querySelector('.menu');
                var menuButton = document.getElementById("menuToggle");
                if (!menu.contains(event.target)) {
                    var menuList = document.querySelector('.menu-list');
                    menuList.classList.add("hidden");
                    menuButton.setAttribute("aria-expanded", "false");
                }
            });
        </script>
        <script>
            // Mostrar alertas de flashdata
            <?php if (session()->getFlashdata('alert')): ?>
                <?php $alert = session()->getFlashdata('alert'); ?>
                Swal.fire({
                    icon: '<?= $alert['type'] ?>',
                    title: '<?= $alert['title'] ?>',
                    text: '<?= $alert['message'] ?>',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            <?php endif; ?>
        </script>
        <script>
    const menuToggle = document.getElementById('menuToggle');
    const menu = document.getElementById('mainMenu');

    // Función para cerrar el menú
    function closeMenu() {
        menu.classList.add('hidden');
        menuToggle.setAttribute('aria-expanded', 'false');
    }

    // Cerrar menú al hacer clic en cualquier item
    menu.querySelectorAll('.menu-item a').forEach(link => {
        link.addEventListener('click', () => {
            closeMenu();
        });
    });
</script>

</body>

</html>
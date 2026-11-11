<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Core Js  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="utf-8" />
    <title>FC Encomiendas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-header" content="<?= csrf_header() ?>">
    <!-- App favicon -->
    <?php
    $favicon = setting('favicon');
    if ($favicon && file_exists(FCPATH . 'upload/settings/' . $favicon)) {
        $faviconUrl = base_url('upload/settings/' . $favicon);
    } else {
        $faviconUrl = base_url('favicon.ico');
    }
    ?>

    <link rel="shortcut icon" href="<?= esc($faviconUrl) ?>">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Dropify -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.1/dist/sweetalert2.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

    <!-- App Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/themify-icons@1.0.6/themify-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr@1.9.1/dist/themes/classic.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="<?= base_url('backend/assets/css/styles.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/assets/css/helper.css') ?>" rel="stylesheet">
    <link href="<?= base_url('backend/assets/css/timeline.css?v=1.0') ?>" rel="stylesheet">
    <!-- Modernizr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <script type="text/javascript">
        var _date_format = "d/m/Y";
        var _report_table = "";
        var _backend_direction = "ltr";
        var _currency = "$";

        var $lang_alert_title = "¿Estas seguro?";
        var $lang_alert_message = "¡Una vez eliminada, no podrá recuperar esta información!";
        var $lang_confirm_button_text = "¡Sí, eliminalo!";
        var $lang_cancel_button_text = "Cancelar";
        var $lang_no_data_found = "Datos no encontrados";
        var $lang_showing = "Mostrar";
        var $lang_to = "a";
        var $lang_of = "de";
        var $lang_entries = "Entradas";
        var $lang_showing_0_to_0_of_0_entries = "Mostrar 0 a 0 de 0 Entradas";
        var $lang_show = "Mostrar";
        var $lang_loading = "Cargando...";
        var $lang_processing = "Procesando...";
        var $lang_search = "Buscar";
        var $lang_no_matching_records_found = "No se encontraron registros coincidentes";
        var $lang_first = "Primero";
        var $lang_last = "Último";
        var $lang_next = "Siguiente";
        var $lang_previous = "Previo";
        var $lang_copy = "Copiar";
        var $lang_excel = "Excel";
        var $lang_pdf = "PDF";
        var $lang_print = "Imprimir";
        var $lang_income = "Ingreso";
        var $lang_expense = "Gastos";
        var $lang_income_vs_expense = "Ingresos vs Gastos";
        var $lang_source = "Fuente";
        var $lang_created = "Creado";
        var $lang_tax_method = "Método de impuestos";
        var $lang_inclusive = "INCLUSIVO";
        var $lang_exclusive = "EXCLUSIVO";
        var $lang_unit_price = "Precio unitario";
        var $lang_quantity = "Cantidad";
        var $lang_discount = "Descuento";
        var $lang_tax = "impuesto";
        var $lang_save = "Guardar";
        var $lang_no_tax = "Sin impuestos";
        var $lang_update_product = "Actualizar producto";
        var $lang_none = "NINGUNO";
        var $lang_copied_invoice_link = "Enlace de factura copiada";
        var $lang_copied_quotation_link = "Enlace de cotización copiado";
        var $lang_no_user_assigned = "Ningún usuario asignado";
        var $lang_select_milestone = "Seleccionar hito";
        var $lang_no_data_available = "Datos no disponibles";
        var $lang_select_tax = "Seleccione IMPUESTO";
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            margin-top: 20px;
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 16px;
        }

        .badge-text-lg {
            font-size: 1rem;
        }

        /* Animación campanita */

        .bell-alert {
            color: #ffc107 !important;
            animation: bellShake 1.0s ease-in-out 3;
        }

        @keyframes bellShake {

            0% {
                transform: rotate(0);
            }

            15% {
                transform: rotate(-15deg);
            }

            30% {
                transform: rotate(10deg);
            }

            45% {
                transform: rotate(-10deg);
            }

            60% {
                transform: rotate(6deg);
            }

            75% {
                transform: rotate(-4deg);
            }

            100% {
                transform: rotate(0);
            }

        }

        /* efecto de brillo */

        .bell-glow {
            text-shadow:
                0 0 5px rgba(255, 193, 7, 0.7),
                0 0 10px rgba(255, 193, 7, 0.6),
                0 0 20px rgba(255, 193, 7, 0.5);
        }

        /* ===========================
   NOTIFICACIONES
=========================== */

        .notif-card {
            display: flex;
            gap: 12px;
            padding: 12px 14px;
            border-bottom: 1px solid #f1f1f1;
            transition: all .2s ease;

            width: calc(100% - 10px);
            /* deja margen */
            margin: 0 auto;
        }

        .notif-card:hover {
            background: #f8f9fa;
            transform: translateX(4px);
        }

        .notif-icon {
            font-size: 18px;
            color: #ffc107;
            margin-top: 3px;
        }

        .notif-content {
            flex: 1;
            min-width: 0;
        }

        .notif-title {
            font-weight: 600;
            font-size: 14px;
            color: #1d2744;
        }

        .notif-msg {
            font-size: 12px;
            color: #6c757d;
            white-space: normal;
            word-break: break-word;
        }

        .dropdown-menu {
            border-radius: 10px;
        }

        .dropdown-header {
            font-size: 14px;
            color: #1d2744;
        }

        .notif-dropdown {
            width: 420px;
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            /* evita barra lateral */
            padding: 0;
        }

        /* ── Evitar scroll horizontal global ── */
        html, body { overflow-x: hidden; max-width: 100vw; }
        #layoutSidenav { max-width: 100%; }

        /* ══ NAVBAR ══ */
        .navbar {
            border-bottom: 1px solid rgba(255,255,255,.1);
            box-shadow: 0 2px 14px rgba(8,51,68,.28);
            padding: 0 16px;
            height: 58px;
        }

        .navbar .navbar-brand {
            font-weight: 800; font-size: 1.05rem;
            letter-spacing: .2px; color: #fff !important;
            padding: 0; margin-right: 10px;
        }

        /* Hamburger */
        #sidebarToggle {
            padding: 7px 9px; border-radius: 9px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.15) !important;
            transition: background .2s;
            line-height: 1;
        }
        #sidebarToggle:hover { background: rgba(255,255,255,.22); }
        .lines { display: flex; flex-direction: column; gap: 4px; padding: 1px 0; }
        .lines span {
            display: block; width: 20px; height: 2px;
            background: #fff; border-radius: 2px;
            transition: all .25s;
        }

        /* Grupo derecho del navbar */
        .nav-right-group { gap: 2px; align-items: center; }

        /* Username chip (ahora es el dropdown toggle) */
        .nav-user-chip {
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 24px; padding: 4px 12px 4px 4px;
            color: #fff; font-size: .82rem; font-weight: 600;
            white-space: nowrap; max-width: 220px;
            cursor: pointer; transition: background .2s, border-color .2s;
            text-decoration: none !important;
        }
        .nav-user-chip:hover, .nav-user-chip:focus,
        .nav-user-chip[aria-expanded="true"] {
            background: rgba(255,255,255,.2);
            border-color: rgba(255,255,255,.35);
            color: #fff; outline: none;
        }
        .nav-user-chip::after { display: none; } /* quitar caret Bootstrap */
        .nav-chip-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid rgba(255,255,255,.3);
            flex-shrink: 0;
            transition: border-color .2s;
        }
        .nav-user-chip:hover .nav-chip-avatar { border-color: #fb923c; }
        .nav-chip-name { overflow: hidden; text-overflow: ellipsis; }
        .nav-chip-caret {
            font-size: .65rem; color: rgba(255,255,255,.6);
            flex-shrink: 0; margin-left: 2px;
            transition: transform .2s;
        }
        .nav-user-chip[aria-expanded="true"] .nav-chip-caret { transform: rotate(180deg); }

        /* Icono campana */
        .nav-icon-btn { display: flex; align-items: center; }
        .nav-icon-link {
            display: flex; align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 10px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.85); font-size: 1rem;
            transition: background .2s;
            text-decoration: none !important;
        }
        .nav-icon-link:hover { background: rgba(255,255,255,.18); color: #fff; }
        .nav-badge {
            position: absolute; top: -4px; right: -4px;
            background: #f97316; color: #fff;
            border-radius: 10px; font-size: 10px;
            padding: 1px 5px; font-weight: 700;
            border: 2px solid #0891b2;
            line-height: 1.4;
        }
        .bell-alert { color: #fb923c !important; }
        .bell-glow { text-shadow: 0 0 6px rgba(251,146,60,.8), 0 0 12px rgba(251,146,60,.5); }
        .navbar .badge-danger {
            background: #f97316 !important; border-radius: 10px !important;
            font-size: 10px !important; padding: 2px 5px !important;
        }

        /* Separador vertical entre campana y chip */
        .nav-sep {
            width: 1px; height: 24px;
            background: rgba(255,255,255,.18);
            margin: 0 8px;
        }

        /* Notification dropdown — fixed al viewport para no desbordar */
        .notif-dropdown {
            border: none !important;
            box-shadow: 0 10px 36px rgba(8,51,68,.18) !important;
            border-radius: 12px !important; overflow: hidden;
            position: fixed !important;
            top: 58px !important;
            right: 12px !important;
            left: auto !important;
            width: min(420px, calc(100vw - 24px)) !important;
            max-width: calc(100vw - 24px) !important;
            max-height: 70vh; overflow-y: auto; overflow-x: hidden;
        }
        .notif-dropdown .dropdown-header {
            background: linear-gradient(135deg, #083344, #0891b2);
            color: #fff !important; border-radius: 0 !important;
            padding: 12px 16px !important; font-size: 13px !important;
        }
        .notif-dropdown .dropdown-header .badge-danger { background: #f97316 !important; }
        .notif-dropdown .dropdown-item.text-primary { color: #0891b2 !important; font-weight: 600; }
        .notif-card:hover { background: #f0f9ff; }

        /* ══ SIDEBAR ══ */
        .sb-sidenav { border-right: 1px solid #e9ecef; }

        /* Header del sidebar (zona logo/sucursal) */
        .sidebar-user { background: linear-gradient(135deg, #083344 0%, #0c5f78 60%, #0891b2 100%); }
        .sidebar-user > div[style*="background-color"] { display: none !important; }
        .sidebar-user .nav-link.text-dark {
            color: rgba(255,255,255,.75) !important;
            font-size: .8rem; letter-spacing: .3px;
        }
        .sidebar-user .logo { border-radius: 10px; }

        /* Encabezados de sección */
        .sb-sidenav-menu-heading {
            font-size: .68rem; font-weight: 800; letter-spacing: 1px;
            color: #9ca3af; padding: 18px 20px 6px; text-transform: uppercase;
        }

        /* Links principales */
        .sb-sidenav-light .nav-link {
            color: #374151; font-size: .88rem; padding: 9px 20px;
            border-radius: 8px; margin: 1px 8px; transition: all .18s;
            display: flex; align-items: center; gap: 8px;
        }
        .sb-sidenav-light .nav-link:hover {
            background: #e0f9f9; color: #083344;
        }
        .sb-sidenav-light .nav-link.active {
            background: linear-gradient(90deg, #e0f9f9, #f0fdfe) !important;
            color: #0891b2 !important; font-weight: 700;
            border-left: 3px solid #0891b2;
            padding-left: 17px !important;
        }
        .sb-sidenav-light .nav-link .sb-nav-link-icon {
            color: #0891b2; width: 18px; text-align: center;
            font-size: .9rem; flex-shrink: 0;
        }
        .sb-sidenav-light .nav-link.active .sb-nav-link-icon { color: #0891b2; }
        .sb-sidenav-light .nav-link .sb-sidenav-collapse-arrow { margin-left: auto; color: #9ca3af; font-size: .75rem; }

        /* Sub-links (menú anidado) */
        .sb-sidenav-menu-nested .nav-link {
            padding-left: 36px !important; font-size: .84rem; color: #6b7280;
        }
        .sb-sidenav-menu-nested .nav-link:hover { color: #083344; }
        .sb-sidenav-menu-nested .nav-link.active { color: #0891b2 !important; border-left: 3px solid #0891b2; padding-left: 33px !important; }

        /* Scrollbar sidebar */
        .sb-sidenav-menu { overflow-y: auto; }
        .sb-sidenav-menu::-webkit-scrollbar { width: 4px; }
        .sb-sidenav-menu::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

        /* ══ MOBILE ══ */
        @media (max-width: 600px) {
            .navbar { height: 52px; padding: 0 10px; }
            .notif-dropdown, .navbar .dropdown-menu {
                top: 52px !important; right: 8px !important;
            }
            .nav-chip-name { max-width: 90px; }
        }

        /* User dropdown */
        .navbar .dropdown-menu {
            border: none !important;
            box-shadow: 0 10px 36px rgba(8,51,68,.18) !important;
            border-radius: 12px !important; min-width: 180px;
            position: fixed !important;
            top: 58px !important;
            right: 12px !important;
            left: auto !important;
        }
        .navbar .dropdown-item {
            font-size: .88rem; padding: 9px 16px;
            transition: background .15s, color .15s;
        }
        .navbar .dropdown-item:hover { background: #e0f9f9; color: #083344; }
        .navbar .dropdown-item i { width: 18px; color: #0891b2; }
        .navbar .dropdown-item:last-child i { color: #f97316; }
        .navbar .dropdown-divider { border-color: #f0f4f8; margin: 4px 0; }
    </style>
</head>

<body class="sb-nav-fixed">
    <!--Header Nav-->
    <nav class="navbar navbar-expand navbar-dark"
        style="background: linear-gradient(135deg, #083344 0%, #0c5f78 60%, #0891b2 100%)!important;">
        <div class="container-fluid d-flex justify-content-between">
            <button class="btn btn-link btn-sm text-white" id="sidebarToggle">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            <div class="d-flex align-items-center nav-right-group">

                <?php if (tienePermiso('ver_notificaciones')): ?>
                <div class="dropdown nav-icon-btn" id="notifWrap">
                    <a class="nav-icon-link position-relative"
                        href="#"
                        id="notifDropdown"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i id="notifBell" class="fa-solid fa-bell <?= !empty($notif_contador) && $notif_contador > 0 ? 'bell-alert bell-glow' : '' ?>"></i>
                        <span id="notifCount"
                            class="nav-badge <?= !empty($notif_contador) && $notif_contador > 0 ? '' : 'd-none' ?>">
                            <?= $notif_contador ?? 0 ?>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right notif-dropdown" aria-labelledby="notifDropdown">
                        <div class="dropdown-header d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-bell" style="color:#a7f3f8;"></i> Notificaciones</span>
                            <?php if (!empty($notif_contador) && $notif_contador > 0): ?>
                                <span class="badge badge-danger"><?= $notif_contador ?></span>
                            <?php endif; ?>
                        </div>

                        <div id="notifList">
                            <?php if (!empty($notif_lista)): ?>
                                <?php foreach ($notif_lista as $n): ?>
                                    <a href="<?= esc($n->link ?? '#') ?>"
                                        class="notif-card text-decoration-none"
                                        data-id="<?= $n->id ?>"
                                        style="display:flex;">
                                        <div class="notif-icon">
                                            <?php if ($n->tipo === 'reversion'): ?>
                                                <i class="fa-solid fa-rotate-left text-warning"></i>
                                            <?php elseif ($n->tipo === 'success'): ?>
                                                <i class="fa-solid fa-circle-check text-success"></i>
                                            <?php elseif ($n->tipo === 'warning'): ?>
                                                <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                                            <?php else: ?>
                                                <i class="fa-solid fa-circle-info text-primary"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="notif-content">
                                            <div class="notif-title"><?= esc($n->titulo) ?></div>
                                            <div class="notif-msg"><?= esc($n->mensaje) ?></div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="dropdown-item text-muted text-center py-3">Sin notificaciones</div>
                            <?php endif; ?>
                        </div>

                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('notifications') ?>" class="dropdown-item text-center text-primary">Ver todas</a>
                    </div>
                </div>

                <div class="nav-sep"></div>
                <?php endif; ?>

                <?php
                $foto = session('foto');
                $fotoPath = ($foto && file_exists(FCPATH . 'upload/perfiles/' . $foto))
                    ? base_url('upload/perfiles/' . $foto)
                    : base_url('upload/profile/user.jpg');
                ?>
                <div class="dropdown">
                    <a class="nav-user-chip dropdown-toggle"
                        href="#"
                        id="userDropdown"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <img src="<?= esc($fotoPath) ?>" alt="avatar" class="nav-chip-avatar">
                        <span class="nav-chip-name"><?= esc($session->get('user_name') ?? 'N/A') ?></span>
                        <i class="fas fa-chevron-down nav-chip-caret"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= base_url('perfil') ?>">
                            <i class="fa-regular fa-user"></i> Mi perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">
                            <i class="fa-solid fa-power-off"></i> Cerrar sesión
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </nav>
    <!--End Header Nav-->

    <!--Start layoutSidenav_nav-->
    <div id="layoutSidenav" class="container-fluid d-flex align-items-stretch">
        <?php include('sidebar.php'); ?>
        <!--End layoutSidenav_nav-->

        <div id="layoutSidenav_content">
            <main>
                <div class="alert alert-success alert-dismissible" id="main_alert" role="alert">
                    <button type="button" id="close_alert" class="close">
                        <span aria-hidden="true"><i class="ti-close"></i></span>
                    </button>
                    <span class="msg"></span>
                </div>
                <div class="content-wrapper">
                    <?= $this->renderSection('content') ?>
                </div>
                <?php if (session()->getFlashdata('permiso_error')): ?>
                    <div aria-live="polite" aria-atomic="true" style="position: relative; z-index: 2000;">
                        <div class="toast" style="position: absolute; top: 20px; right: 20px;" data-delay="4500">
                            <div class="toast-header bg-danger text-white">
                                <strong class="mr-auto">Permiso requerido</strong>
                                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                            </div>
                            <div class="toast-body">
                                <?= session()->getFlashdata('permiso_error') ?>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('.toast').toast('show');
                        });
                    </script>
                <?php endif; ?>
            </main>
        </div>
        <!--End layoutSidenav_content-->
    </div>
    <!--End layoutSidenav-->
    <!-- Bootstrap 4  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Datatable js -->
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <!-- Dropify -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.1/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr@1.9.1/dist/pickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <!-- App js -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@1.2.4/pace.min.js"></script>
    <script src="<?= base_url('backend/assets/js/scripts.js') ?>"></script>
    <script type="text/javascript">
        (function($) {
            "use strict";

            const color = "#1d2744";
            const text_color = "#ffffff";
            document.documentElement.style.setProperty('--tab-active-bg', color);
            document.documentElement.style.setProperty('--tab-active-color', text_color);
        })(jQuery);
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const contador = <?= (int)($notif_contador ?? 0) ?>

        const bell      = document.getElementById('notifBell')
        const countBadge = document.getElementById('notifCount')

        if (contador > 0) {

            countBadge.textContent = contador > 99 ? '99+' : contador
            countBadge.style.display = 'inline-block'

            bell.classList.add('bell-alert', 'bell-glow')

            // quitar animación después de 3 ciclos (~3s)
            setTimeout(() => {
                bell.classList.remove('bell-alert', 'bell-glow')
            }, 3500)
        }

        // Marcar como leída al hacer click
        document.querySelectorAll('.notif-card[data-id]').forEach(card => {
            card.addEventListener('click', function () {
                const id = this.dataset.id
                fetch('<?= base_url('notifications/marcar-leida') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                })
            })
        })

    })
</script>
    <?= $this->include('Layouts/toast') ?>

    <?php if ($session->get('logged_in')): ?>
    <script>
    (function () {
        const POLL_URL    = '<?= base_url('horario/verificar-sesion') ?>';
        const LOGOUT_URL  = '<?= base_url('logout') ?>';
        const INTERVAL_MS = 30000; // cada 30 segundos
        let advertenciaActiva = false;

        function verificarSesion() {
            fetch(POLL_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(data => {
                    if (data.forzar) {
                        // Cierre inmediato: forzado o fuera de horario
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sesión terminada',
                            text: data.mensaje || 'Tu sesión ha finalizado.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#d33',
                        }).then(() => {
                            window.location.href = LOGOUT_URL;
                        });
                        return;
                    }

                    // Advertencia: quedan 5 minutos o menos
                    if (data.advertencia && !advertenciaActiva) {
                        advertenciaActiva = true;
                        const min = data.minutos_restantes;
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'warning',
                            title: '⏰ Jornada por terminar',
                            html: 'Tu jornada laboral termina en <strong>' + min + ' minuto' + (min !== 1 ? 's' : '') + '</strong>.',
                            showConfirmButton: false,
                            timer: 20000,
                            timerProgressBar: true,
                        }).then(() => { advertenciaActiva = false; });
                    }
                })
                .catch(() => {}); // silenciar errores de red
        }

        // Primera verificación al cargar la página (después de 5 s para no solapar con el render)
        setTimeout(verificarSesion, 5000);
        setInterval(verificarSesion, INTERVAL_MS);
    })();
    </script>
    <?php endif; ?>
</body>

</html>
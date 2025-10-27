<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #6d7277ff 0%, #e2eafc 100%);
            min-height: 100vh;
        }

        .navbar {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            background: #fff !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050;
            height: 56px;
        }

        /* Reemplaza las clases .sidebar y .content-wrapper */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            height: calc(100vh - 56px);
            width: 220px;
            background: linear-gradient(135deg, #e2eafc 0%, #fff 100%);
            border-right: 1px solid #d0e2ff;
            box-shadow: 2px 0 16px rgba(13, 110, 253, 0.06);
            z-index: 1040;
            padding-top: 20px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        .sidebar.minimized {
            width: 60px;
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #0d6efd;
            text-align: center;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
            transition: opacity 0.2s;
        }

        .sidebar.minimized .sidebar-title {
            opacity: 0;
            height: 0;
            margin: 0;
            overflow: hidden;
        }

        .minimize-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #e7f1ff;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #0d6efd;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.08);
            transition: background 0.2s;
        }

        .minimize-btn:hover {
            background: #d0e2ff;
        }

        .list-group {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .list-group-item {
            border: none;
            background: transparent;
            color: #495057;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: background 0.2s, color 0.2s, padding 0.2s;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            font-size: 1.05rem;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.03);
        }

        .list-group-item.active,
        .list-group-item:hover {
            background: #e7f1ff;
            color: #0d6efd;
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(13, 110, 253, 0.07);
        }

        .sidebar.minimized .list-group-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
            gap: 0;
            font-size: 1.3rem;
        }

        .sidebar-text {
            transition: opacity 0.2s, width 0.2s;
            white-space: nowrap;
        }

        .sidebar.minimized .sidebar-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .content-wrapper {
            position: relative;
            margin-left: 240px;
            /* 220px del sidebar + 20px de margen */
            margin-right: 20px;
            /* Margen derecho igual */
            width: calc(100% - 260px);
            /* 100% - (margen izquierdo + margen derecho) */
            margin-top: 76px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 32px 40px;
            transition: all 0.3s ease;
        }

        /* Cuando el sidebar está minimizado */
        .sidebar.minimized~.content-wrapper {
            margin-left: 80px;
            /* 60px del sidebar minimizado + 20px de margen */
            margin-right: 20px;
            /* Mantiene el mismo margen derecho */
            width: calc(100% - 100px);
            /* 100% - (margen izquierdo + margen derecho) */
        }

        /* Ajuste responsivo */
        @media (max-width: 991.98px) {
            .content-wrapper {
                margin-left: 20px;
                /* Sin sidebar, margen igual en ambos lados */
                margin-right: 20px;
                width: calc(100% - 40px);
                margin-top: 76px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .navbar-nav .nav-item {
                margin-bottom: 8px;
            }

            .navbar-nav {
                text-align: center;
            }

            .content-wrapper {
                padding: 16px 8px;
                margin-top: 70px;
            }
        }
    </style>
    <title><?= $title ?></title>
</head>

<body>
    <!-- Sidebar Bonito Minimizable -->
    <div class="sidebar d-none d-lg-block" id="sidebar">
        <button class="minimize-btn" id="minimizeSidebar" title="Minimizar/Maximizar">
            <i class="fa-solid fa-chevron-left" id="minimizeIcon"></i>
        </button>
        <hr style="visibility: hidden;">
        <div class="list-group px-3">
            <div class="sidebar-title"></i> Menú lateral
            </div>

            <a href="#" class="list-group-item list-group-item-action active">
                <i class="fa-solid fa-house"></i>
                <span class="sidebar-text">Inicio</span>
            </a>
            <a href="/clientes" class="list-group-item list-group-item-action">
                <i class="fa-solid fa-users"></i>
                <span class="sidebar-text">Clientes</span>
            </a>
            <a href="/encomendistas" class="list-group-item list-group-item-action">
                <i class="fa-solid fa-users"></i>
                <span class="sidebar-text">Proveedores</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa-solid fa-gear"></i>
                <span class="sidebar-text">Configuración</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa-solid fa-chart-line"></i>
                <span class="sidebar-text">Reportes</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa-solid fa-user"></i>
                <span class="sidebar-text">Perfil</span>
            </a>
            <!-- Agrega más opciones aquí -->
        </div>
    </div>
    <!-- Fin Sidebar -->

    <?= view('partials/_session') ?> <!-- Contenido Toast -->

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-store"></i> Carytel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="btn <?= ($_SERVER['REQUEST_URI'] == '/') ? 'active' : '' ?>" href="/">
                            <i class="fa-solid fa-cash-register"></i> Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], 'inventario') !== false) ? 'active' : '' ?>"
                            href="/inventario">
                            <i class="fa-solid fa-boxes-stacked"></i> Inventario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], 'compras') !== false) ? 'active' : '' ?>"
                            href="/compras">
                            <i class="fa-solid fa-cart-shopping"></i> Compras
                        </a>
                    </li>
                </ul>
                <!-- Puedes agregar aquí el botón de logout si lo necesitas -->
                <!-- <a class="btn btn-outline-danger" href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a> -->
            </div>
        </div>
    </nav>
    <div class="content-wrapper">
        <?= $this->renderSection('content') ?>
    </div>
    <!-- Bootstrap JS con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('js/clientes.js') ?>"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const minimizeBtn = document.getElementById('minimizeSidebar');
        const minimizeIcon = document.getElementById('minimizeIcon');

        // Asegúrate de que el ícono existe en el HTML
        minimizeBtn.innerHTML = '<i class="fa-solid fa-chevron-left" id="minimizeIcon"></i>';

        minimizeBtn.addEventListener('click', function() {
            sidebar.classList.toggle('minimized');

            const icon = document.getElementById('minimizeIcon');
            if (sidebar.classList.contains('minimized')) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
            }
        });
    </script>
</body>

</html>
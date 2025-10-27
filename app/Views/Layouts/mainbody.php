<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Bienvenido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="favicon.ico">
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"
        rel="stylesheet" />
    <!-- App Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/themify-icons@1.0.6/themify-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr@1.9.1/dist/themes/classic.min.css">
    <link rel="stylesheet" href="backend/assets/css/styles.css">
    <link rel="stylesheet" href="backend/assets/css/helper.css">
    <link rel="stylesheet" href="backend/assets/css/timeline.css?v=1.0">
    <!-- Modernizr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <script type="text/javascript">
        //var _url = "https://suplidoresdiversos.tec101cloud.net";
        var _date_format = "d/m/Y";
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
        /* Preloader Styles */
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

        /* Spinner de carga */
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

        /* Opcional: Texto de carga */
        .loading-text {
            margin-top: 20px;
            font-family: Arial, sans-serif;
            color: #333;
            font-size: 16px;
        }
    </style>

</head>


<body class="sb-nav-fixed">
    <!-- Main Modal -->
    <div id="main_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger d-none m-3"></div>
                <div class="alert alert-primary d-none m-3"></div>
                <div class="modal-body overflow-hidden"></div>

            </div>
        </div>
    </div>

    <!-- Secondary Modal -->
    <div id="secondary_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title mt-0 text-dark"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="alert alert-danger d-none m-3"></div>
                <div class="alert alert-primary d-none m-3"></div>
                <div class="modal-body overflow-hidden"></div>
            </div>
        </div>
    </div>

    <!-- Preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
        <div class="loading-text">Cargando...</div>
    </div>
    <!-- Preloader area end -->

    <!--Header Nav-->

    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #1d2744;">



        <div class="container-fluid">
            <a class="navbar-brand text-md-center" href="https://suplidoresdiversos.tec101cloud.net/dashboard">FC
                Encomiendas</a>
            <button class="btn btn-link btn-sm mr-auto" id="sidebarToggle" href="#">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown animate-dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Casa Matriz</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item selected disabled"
                            href="https://suplidoresdiversos.tec101cloud.net/change-company/1">
                            Casa Matriz</a>
                        <a class="dropdown-item " href="https://suplidoresdiversos.tec101cloud.net/change-company/15">
                            BODEGA MEJICANOS</a>
                        <a class="dropdown-item " href="https://suplidoresdiversos.tec101cloud.net/change-company/16">
                            SANTORINI</a>
                        <a class="dropdown-item " href="https://suplidoresdiversos.tec101cloud.net/change-company/17">
                            COL. MEDICA</a>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown animate-dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-user"></i> Ricardo Fernandez

                        <img src="upload/profile/logo.jpg"
                            alt="user-image" height="42" class="rounded-circle shadow-sm">
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="https://suplidoresdiversos.tec101cloud.net/profile"><i
                                class="fa-regular fa-user"></i>
                            Mi perfil</a>
                        <a class="dropdown-item" href="https://suplidoresdiversos.tec101cloud.net/profile/edit"><i
                                class="fa-solid fa-gear"></i>
                            Configuración de perfil</a>
                        <a class="dropdown-item"
                            href="https://suplidoresdiversos.tec101cloud.net/profile/change_password"><i
                                class="fa-solid fa-key"></i> Cambiar la contraseña</a>

                        <a class="dropdown-item"
                            href="https://suplidoresdiversos.tec101cloud.net/admin/administration/general_settings"><i
                                class="fa-solid fa-layer-group"></i> Ajustes del sistema</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="https://suplidoresdiversos.tec101cloud.net/logout"><i
                                class="fa-solid fa-power-off"></i>
                            Cerrar sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!--End Header Nav-->

    <div id="layoutSidenav" class="container-fluid d-flex align-items-stretch">
        <div id="layoutSidenav_nav">
            <span class="close-mobile-nav"><i class="ti-close"></i></span>
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">

                <div class="sidebar-user">

                    <div
                        style=" position: absolute; top: 0; background-color: #1d2744; width: 100%; left: 0; height: 69px; z-index: -1; border-radius: 6px 6px 0 0px;">
                    </div>
                    <a href="javascript: void(0);">

                        <img class="logo" src="https://suplidoresdiversos.tec101cloud.net/public/uploads/media/logo.jpg"
                            alt="logo-company" height="60" class="shadow-sm">
                        <span class="sidebar-user-name">Casa Matriz</span>
                    </a>
                </div>

                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">NAVEGACION</div>

                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                            Menú General
                        </a>

                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            Vendedores
                        </a>
                        
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inventories"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-shopping-cart"></i></div>
                            Inventarios
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="inventories" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav" id="navAccordionInventories">

                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/products">Productos</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/contact_prices">Precios para
                                    Clientes</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/movements">Movimientos de
                                    Inventario</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/movements_type">Tipo de
                                    Movimiento</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/inventory_adjustments/create">Ajuste
                                    de Inventario</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/inventory_adjustments_fp/create">Ajuste
                                    por Compras</a>

                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#maintenance"
                                    aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="ti-settings"></i></div>
                                    Mantenimientos
                                    <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="maintenance" aria-labelledby="headingOne"
                                    data-parent="#navAccordionInventories">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/kits">Kits</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/categories">Categorias</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/brands">Marcas</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/codigo_arancelarios">Códigos
                                            arancelarios</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/product_units">Unidad de
                                            producto</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/product_group">Grupos de
                                            producto</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/product_lines">Líneas de
                                            Productos</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/product_subtypes">SubTipo
                                            de Productos</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/product_subsubtypes">Sub
                                            SubTipo de Productos</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/companies">Bodegas/Sucursales</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                                    data-target="#tranfer-items" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="ti-exchange-vertical"></i></div>
                                    Transferencias
                                    <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="tranfer-items" aria-labelledby="headingOne"
                                    data-parent="#navAccordionInventories">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/passes/create">Añadir
                                            nueva</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/transfer-list/1">Transferencias</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/transfer_receive/0">Transferencias
                                            recibidas</a>
                                    </nav>
                                </div>


                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#suppliers"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-truck"></i></div>
                            Proveedor
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="suppliers" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="https://suplidoresdiversos.tec101cloud.net/suppliers">Lista de
                                    proveedores</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/suppliers/create">Añadir nueva</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#purchase_orders"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-bag"></i></div>
                            Compra
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="purchase_orders" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/purchase_orders">Ordenes de
                                    compra</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/purchase_orders/create">Nueva orden
                                    de compra</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/purchase_returns">Devolución de
                                    compra</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sales"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-shopping-cart-full"></i></div>
                            Ventas
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="sales" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/invoices/create">Crear factura</a>
                                <a class="nav-link" href="https://suplidoresdiversos.tec101cloud.net/invoices">Lista de
                                    facturas</a>

                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/sales_returns">Devolución de
                                    ventas</a>

                                <a class="nav-link" href="https://suplidoresdiversos.tec101cloud.net/tpn_control">Venta
                                    TPN</a>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#order_type"
                                    aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="ti-bookmark"></i></div>
                                    Notas de pedido
                                    <div class="sb-sidenav-collapse-arrow"><i class="ti-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="order_type" aria-labelledby="headingOne"
                                    data-parent="#navAccordionTreasury">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/private_order_notes">Venta
                                            Privada</a>
                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#type_sales"
                                    aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="ti-bookmark"></i></div>
                                    Tipos de ventas
                                    <div class="sb-sidenav-collapse-arrow"><i class="ti-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="type_sales" aria-labelledby="headingOne"
                                    data-parent="#navAccordionTreasury">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/private_sales_subtype">Privadas</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/institutional_sales_subtype">Institucionales</a>
                                    </nav>
                                </div>
                            </nav>

                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#cash"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-package"></i></div>
                            Cajas
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="cash" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="https://suplidoresdiversos.tec101cloud.net/cash">Creación de
                                    caja</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/cash_movement/create?cashmov_type=Closing">Corte
                                    de caja</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/cash_movement">Movimientos de
                                    caja</a>
                            </nav>
                        </div>





                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#treasury"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-server"></i></div>
                            Tesorería
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="treasury" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav" id="navAccordionTreasury">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#accounts"
                                    aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="ti-credit-card"></i></div>
                                    Cuentas
                                    <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="accounts" aria-labelledby="headingOne"
                                    data-parent="#navAccordionTreasury">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/accounts">Toda la
                                            cuenta</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/accounts/create">Añadir
                                            nueva cuenta</a>
                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                                    data-target="#transactions" aria-expanded="false" aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="ti-receipt"></i></div>
                                    Transacciones
                                    <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="transactions" aria-labelledby="headingOne"
                                    data-parent="#navAccordionTreasury">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/income">Ingreso/Depósito</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/expense">Gastos</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/transfer/create">Transferir</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/income/calendar">Calendario
                                            de ingresos</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/expense/calendar">Calendario
                                            de gastos</a>
                                    </nav>
                                </div>

                                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                                    data-target="#recurring_transaction" aria-expanded="false"
                                    aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class="ti-wallet"></i></div>
                                    Transacción recurrente
                                    <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="recurring_transaction" aria-labelledby="headingOne"
                                    data-parent="#navAccordionTreasury">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/repeating_income/create">Añadir
                                            ingresos recurrentes</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/repeating_income">Lista de
                                            ingresos repetitivos</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/repeating_expense/create">Añadir
                                            gastos recurrentes</a>
                                        <a class="nav-link"
                                            href="https://suplidoresdiversos.tec101cloud.net/repeating_expense">Lista de
                                            gastos repetitivos</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#request"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-file"></i></div>
                            Solicitudes
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="request" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav" id="navAccordionRequest">
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/request_order_notes">Modificación
                                    de Notas de pedido</a>

                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/request_lote_uses">Uso de Lotes</a>

                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reports"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-bar-chart"></i></div>
                            Informes
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="reports" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/reports/account_statement">Estado
                                    de cuenta</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/reports/income_report">Informe de
                                    Ingresos</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/reports/expense_report">Informe de
                                    gastos</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/reports/transfer_report">Informe de
                                    transferencia</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/reports/income_vs_expense">Ingresos
                                    VS Gastos</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/reports/report_by_payer">Informe
                                    del pagador</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/reports/report_by_payee">Informe
                                    por beneficiario</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/sales_report">Informe de Ventas</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/reports/report_dtes">Report
                                    DTE´s</a>
                            </nav>
                        </div>


                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#activos"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-money"></i></div>
                            Activos
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="activos" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/lista-activos">Lista activos</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/activos-debaja">Activos de baja</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/lista-mantenimiento">Mantenimiento</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/lista-depreciaciones">Depreciaciones</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/tpn_categories">Categorias TPN</a>

                            </nav>
                        </div>


                        <div class="sb-sidenav-menu-heading">Ajustes del sistema</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#departments"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-layout-grid2"></i></div>
                            Departamentos
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="departments" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/departments/create">Añadir
                                    nueva</a>
                                <a class="nav-link" href="https://suplidoresdiversos.tec101cloud.net/departments">Lista
                                    de Departamentos</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#job_position"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-briefcase"></i></div>
                            Puestos de Trabajo
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="job_position" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/job_positions/create">Añadir
                                    nueva</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/job_positions">Lista de Puestos de
                                    Trabajo</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#company_settings"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-panel"></i></div>
                            Ajustes del sistema
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="company_settings" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/admin/administration/general_settings">Configuración
                                    general</a>



                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#staffs"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-user"></i></div>
                            Gestión de usuarios
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="staffs" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="https://suplidoresdiversos.tec101cloud.net/admin/users">Todos
                                    los usuarios</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/admin/users/create">Añadir
                                    nueva</a>
                                <a class="nav-link" href="https://suplidoresdiversos.tec101cloud.net/roles">Roles del
                                    usuario</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/permission/control">Control de
                                    acceso</a>
                            </nav>
                        </div>



                        <a class="nav-link collapsed" href="#" data-toggle="collapse"
                            data-target="#transaction_settings" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="ti-credit-card"></i></div>
                            Configuración de transacciones
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="transaction_settings" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/chart_of_accounts">Tipos de
                                    ingresos y gastos</a>
                                <a class="nav-link"
                                    href="https://suplidoresdiversos.tec101cloud.net/payment_methods">Métodos de
                                    pago</a>
                                <a class="nav-link" href="https://suplidoresdiversos.tec101cloud.net/taxs">Configuración
                                    de impuestos</a>
                            </nav>
                        </div>

                        <a class="nav-link" href="https://suplidoresdiversos.tec101cloud.net/logs">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>Bitácora
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <!--ENd layoutSidenav_nav-->

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


            </main>

        </div>
        <!--End layoutSidenav_content-->
    </div>
    <!--End layoutSidenav-->

    <!-- Core Js  -->
    <script src="https://suplidoresdiversos.tec101cloud.net/public/backend/assets/js/jquery-3.6.0.min.js"></script>
    <script
        src="https://suplidoresdiversos.tec101cloud.net/public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://suplidoresdiversos.tec101cloud.net/public/backend/assets/js/print.js"></script>
    <script src="https://suplidoresdiversos.tec101cloud.net/public/backend/assets/js/pace.min.js"></script>
    <script src="https://suplidoresdiversos.tec101cloud.net/public/backend/assets/js/clipboard.min.js"></script>
    <script src="https://suplidoresdiversos.tec101cloud.net/public/backend/plugins/moment/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>



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
    <script
        src="https://suplidoresdiversos.tec101cloud.net/public/backend/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="https://suplidoresdiversos.tec101cloud.net/public/backend/plugins/tinymce/tinymce.min.js"></script>
    <script src="https://suplidoresdiversos.tec101cloud.net/public/backend/plugins/parsleyjs/parsley.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

    <!-- App js -->
    <script src="https://suplidoresdiversos.tec101cloud.net/public/backend/assets/js/scripts.js?v=1.21"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js"
        integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        (function ($) {

            "use strict";

            const color = "#1d2744";
            const text_color = "#ffffff";
            document.documentElement.style.setProperty('--tab-active-bg', color);
            document.documentElement.style.setProperty('--tab-active-color', text_color);

            //Show Success Message

            //Show Single Error Message



        })(jQuery);
    </script>

    <!-- Custom JS -->
    <script
        src="https://suplidoresdiversos.tec101cloud.net/public/backend/assets/js/datatables/products-table.js"></script>



</body>

</html>
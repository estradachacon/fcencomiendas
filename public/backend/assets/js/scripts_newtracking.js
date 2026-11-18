document.addEventListener("DOMContentLoaded", () => {
    // VARIABLES GLOBALES
    let paquetesSeleccionados = {};   // id => paquete seleccionado
    let paquetesCache = {};           // id => paquete cargado de API
    let listaRuta = [];               // paquetes filtrados por ruta
    let listaEspeciales = [];         // paquetes tipo 2 y 3
    let listaPendientes3 = [];
    let municipioSeleccionado = "";
    let reenvioSet = new Set();       // IDs de paquetes que requieren reenvío

    // ELEMENTOS DEL DOM
    const tablaTracking = document.getElementById("tracking-body");

    const modalRutas = $("#modalRutas");          // Bootstrap 4
    const modalEspeciales = $("#modalEspeciales");

    const selectRuta = document.getElementById("ruta_select");
    const tablaPaquetesRuta = document.getElementById("tablaPaquetesRuta");

    const selectFiltroTipo = document.getElementById("filtro_tipo");
    const tablaEspecialesBody = document.getElementById("tablaEspeciales");

    const btnAgregarRuta = document.getElementById("agregarPorRuta");
    const btnAgregarEspeciales = document.getElementById("agregarEspeciales");

    const motorista = document.getElementById("motorista");
    const fechaTracking = document.getElementById("fecha_tracking");
    const btnGuardar = document.getElementById("btnGuardar");

    const modalPendientes3 = $("#modalPendientes3");
    const tablaPendientes3 = document.getElementById("tablaPendientes3");
    const btnAgregarPendientes3 = document.getElementById("agregarPendientes3");
    const selectMunicipio = document.getElementById("municipioEspecial");

    // CSRF si existe
    const csrfInput = document.querySelector("input[name='csrf_test_name']");

    function coincideConFecha(pkg, fecha) {

        switch (parseInt(pkg.tipo_servicio)) {
            // Punto fijo
            case 1:
                return fecha && pkg.fecha_entrega_puntofijo === fecha;
            // Personalizado
            case 2:
                return fecha && pkg.fecha_entrega_personalizado === fecha;
            // Recolección → SIEMPRE disponible
            case 3:
                return true;
            default:
                return false;
        }
    }

    // CARGA DE PAQUETES POR RUTA
    async function loadPaquetesPorRuta(rutaId) {
        tablaPaquetesRuta.innerHTML = `<p class="text-muted text-center py-3">Cargando...</p>`;
        try {
            const resp = await fetch(`/tracking-pendientes/ruta/${rutaId}`);
            const data = await resp.json();
            listaRuta = data;
            listaRuta.forEach(p => paquetesCache[p.id] = p);
            renderPaquetesRuta();
        } catch (e) {
            tablaPaquetesRuta.innerHTML = `<p class="text-danger text-center py-3">Error al cargar</p>`;
        }
    }

    function renderPaquetesRuta() {
        tablaPaquetesRuta.innerHTML = "";
        const fechaGlobal = fechaTracking.value;
        const lista = listaRuta.filter(p => coincideConFecha(p, fechaGlobal));

        if (!lista.length) {
            tablaPaquetesRuta.innerHTML = `<p class="text-muted text-center py-3">No hay paquetes para esta ruta y esta fecha</p>`;
            return;
        }

        lista.forEach(p => {
            const monto = isNaN(parseFloat(p.monto)) ? 'Cancelado' : '$' + parseFloat(p.monto).toFixed(2);
            const sub   = [p.punto_fijo_nombre, p.vendedor].filter(Boolean).join(' · ');

            const card = document.createElement("div");
            card.className = "pkg-card";
            card.innerHTML = `
                <input type="checkbox" class="chkRuta" data-id="${p.id}">
                <div class="pkg-card-body">
                    <div class="pkg-card-top">
                        <span class="pkg-card-id">#${p.id}</span>
                        <span class="pkg-card-name">${p.cliente}</span>
                    </div>
                    <div class="pkg-card-sub">${sub}</div>
                </div>
                <span class="pkg-card-monto">${monto}</span>
            `;

            card.addEventListener("click", function (e) {
                if (e.target.type === "checkbox") return;
                const chk = this.querySelector(".chkRuta");
                chk.checked = !chk.checked;
                this.classList.toggle("selected", chk.checked);
            });
            card.querySelector(".chkRuta").addEventListener("change", function () {
                card.classList.toggle("selected", this.checked);
            });

            tablaPaquetesRuta.appendChild(card);
        });
    }

    // CARGA PAQUETES ESPECIALES (tipo 2 y 3)
    async function loadEspeciales() {
        tablaEspecialesBody.innerHTML = `<p class="text-muted text-center py-3">Cargando...</p>`;
        try {
            const resp = await fetch("/tracking-pendientes/todos");
            const data = await resp.json();
            listaEspeciales = data.filter(p =>
                p.tipo_servicio == 2 || (p.tipo_servicio == 3 && p.estatus === 'recolectado')
            );
            listaEspeciales.forEach(p => paquetesCache[p.id] = p);
            cargarMunicipiosDesdeEspeciales(fechaTracking.value);
            renderEspeciales();
        } catch (err) {
            tablaEspecialesBody.innerHTML = `<p class="text-danger text-center py-3"><i class="fa fa-exclamation-circle mr-1"></i>Error al cargar</p>`;
        }
    }

    function renderEspeciales() {
        tablaEspecialesBody.innerHTML = "";

        const fechaGlobal = fechaTracking.value;
        const filtro      = selectFiltroTipo.value;
        const municipioId = municipioSeleccionado === VALOR_TODOS || !municipioSeleccionado
            ? null : municipioSeleccionado;

        const lista = listaEspeciales.filter(p => {
            if (filtro && p.tipo_servicio != filtro) return false;
            if (municipioId && p.municipio_id != municipioId) return false;
            return coincideConFecha(p, fechaGlobal);
        });

        if (!lista.length) {
            tablaEspecialesBody.innerHTML = `<p class="text-muted text-center py-3">Sin resultados para esta fecha</p>`;
            return;
        }

        const cmp = (a, b) => a.localeCompare(b, 'es', { sensitivity: 'base' });
        const grupos = {};
        lista.forEach(p => {
            const muni = p.municipio_nombre || 'Sin municipio';
            const col  = p.colonia_nombre   || 'Sin colonia';
            ((grupos[muni] ??= {})[col] ??= []).push(p);
        });

        Object.keys(grupos).sort(cmp).forEach(muni => {
            const colonias = grupos[muni];
            const totalMuni = Object.values(colonias).reduce((n, arr) => n + arr.length, 0);
            const hMuni = document.createElement("div");
            hMuni.className = "pkg-group-muni";
            hMuni.innerHTML = `<i class="fa fa-map-marker-alt mr-1"></i>${muni}<span class="pkg-group-count">${totalMuni}</span>`;
            tablaEspecialesBody.appendChild(hMuni);

            Object.keys(colonias).sort(cmp).forEach(col => {
                const hCol = document.createElement("div");
                hCol.className = "pkg-group-col";
                hCol.innerHTML = `${col}<span class="pkg-group-count">${colonias[col].length}</span>`;
                tablaEspecialesBody.appendChild(hCol);

                colonias[col].sort((a, b) => cmp(a.cliente || '', b.cliente || '')).forEach(renderEspecialCard);
            });
        });
    }

    function renderEspecialCard(p) {
            const monto    = isNaN(parseFloat(p.monto)) ? 'Cancelado' : '$' + parseFloat(p.monto).toFixed(2);
            const sub      = (p.tipo_servicio == 2 ? p.destino_personalizado : p.lugar_recolecta_paquete) || '';
            const checked  = paquetesSeleccionados[p.id] ? 'checked' : '';

            const card = document.createElement("div");
            card.className = "pkg-card" + (checked ? " selected" : "");
            card.innerHTML = `
                <input type="checkbox" class="chkEspecial" data-id="${p.id}" ${checked}>
                <div class="pkg-card-body">
                    <div class="pkg-card-top">
                        <span class="pkg-card-id">#${p.id}</span>
                        <span class="pkg-card-name">${p.cliente}</span>
                    </div>
                    <div class="pkg-card-sub">${sub}</div>
                    <div class="pkg-card-sub" style="color:#374151">${p.vendedor}</div>
                </div>
                <span class="pkg-card-monto">${monto}</span>
            `;

            card.addEventListener("click", function (e) {
                if (e.target.type === "checkbox") return;
                const chk = this.querySelector(".chkEspecial");
                chk.checked = !chk.checked;
                this.classList.toggle("selected", chk.checked);
            });
            card.querySelector(".chkEspecial").addEventListener("change", function () {
                card.classList.toggle("selected", this.checked);
            });

            tablaEspecialesBody.appendChild(card);
    }

    async function loadPendientes3() {
        tablaPendientes3.innerHTML = `<p class="text-muted text-center py-3">Cargando...</p>`;
        try {
            const resp = await fetch("/tracking-pendientes/todos");
            const data = await resp.json();
            listaPendientes3 = data.filter(p =>
                (p.tipo_servicio == 3 && p.estatus !== 'recolectado' && p.estatus !== 'finalizado') || p.estatus == 'recolecta_fallida'
            );
            listaPendientes3.forEach(p => paquetesCache[p.id] = p);
            renderPendientes3();
        } catch (e) {
            tablaPendientes3.innerHTML = `<p class="text-danger text-center py-3">Error al cargar</p>`;
        }
    }

    const VALOR_TODOS = "__ALL__";

    function cargarMunicipiosDesdeEspeciales(fecha) {
        const select = document.getElementById("municipioEspecial");

        // Guardar selección actual
        const valorPrevio = municipioSeleccionado || VALOR_TODOS;

        // Reset select
        select.innerHTML = "";

        // Opción Todos
        const optTodos = document.createElement("option");
        optTodos.value = VALOR_TODOS;
        optTodos.textContent = "Todos los municipios";
        select.appendChild(optTodos);

        if (fecha) {
            const municipiosMap = {};

            listaEspeciales.forEach(p => {
                if (!coincideConFecha(p, fecha)) return;
                if (!p.municipio_id || !p.municipio_nombre) return;

                municipiosMap[p.municipio_id] = p.municipio_nombre;
            });

            Object.entries(municipiosMap).forEach(([id, nombre]) => {
                const opt = document.createElement("option");
                opt.value = id;
                opt.textContent = nombre;
                select.appendChild(opt);
            });
        }

        // Restaurar selección
        $('#municipioEspecial')
            .val(valorPrevio)
            .trigger('change.select2');
    }


    function renderPendientes3() {
        tablaPendientes3.innerHTML = "";

        if (!listaPendientes3.length) {
            tablaPendientes3.innerHTML = `<p class="text-muted text-center py-3">No hay paquetes pendientes de recolecta</p>`;
            return;
        }

        listaPendientes3.forEach(p => {
            const monto   = isNaN(parseFloat(p.monto)) ? 'Cancelado' : '$' + parseFloat(p.monto).toFixed(2);
            const destino = p.descripcion || p.destino_personalizado || p.punto_fijo_nombre || "Sin información";
            const badge   = p.estatus === 'recolecta_fallida'
                ? `<span style="font-size:.7rem;background:#fef2f2;color:#dc2626;border:1px solid #fca5a5;border-radius:4px;padding:1px 5px;margin-left:4px;">Fallida</span>`
                : '';

            const card = document.createElement("div");
            card.className = "pkg-card";
            card.innerHTML = `
                <input type="checkbox" class="chkPend3" data-id="${p.id}">
                <div class="pkg-card-body">
                    <div class="pkg-card-top">
                        <span class="pkg-card-id">#${p.id}</span>
                        <span class="pkg-card-name">${p.cliente}</span>${badge}
                    </div>
                    <div class="pkg-card-sub">${destino}</div>
                    <div class="pkg-card-sub" style="color:#374151">${p.vendedor}</div>
                </div>
                <span class="pkg-card-monto">${monto}</span>
            `;

            card.addEventListener("click", function (e) {
                if (e.target.type === "checkbox") return;
                const chk = this.querySelector(".chkPend3");
                chk.checked = !chk.checked;
                this.classList.toggle("selected", chk.checked);
            });
            card.querySelector(".chkPend3").addEventListener("change", function () {
                card.classList.toggle("selected", this.checked);
            });

            tablaPendientes3.appendChild(card);
        });
    }

    // SELECT / DESELECT ALL – RECOLECTAS
    document.getElementById("selectAllPendientes3").addEventListener("click", () => {
        const checks = document.querySelectorAll("#tablaPendientes3 .chkPend3");
        const allChecked = [...checks].every(c => c.checked);
        checks.forEach(c => {
            c.checked = !allChecked;
            c.closest(".pkg-card").classList.toggle("selected", !allChecked);
        });
    });

    // SELECT / DESELECT ALL – RUTAS
    document.getElementById("selectAllRuta").addEventListener("click", () => {
        const checks = document.querySelectorAll("#tablaPaquetesRuta .chkRuta");
        const allChecked = [...checks].every(c => c.checked);
        checks.forEach(c => {
            c.checked = !allChecked;
            c.closest(".pkg-card").classList.toggle("selected", !allChecked);
        });
    });

    // Disparadores de Modales
    document.getElementById("btnRutas").addEventListener("click", () => {
        if (!fechaTracking.value) {
            Swal.fire({
                icon: "warning",
                title: "Fecha faltante",
                text: "Debe seleccionar la fecha del tracking antes de usar rutas."
            });
            return;
        }
        modalRutas.modal("show");
    });

    document.getElementById("btnEspeciales").addEventListener("click", () => {
        if (!fechaTracking.value) {
            Swal.fire({
                icon: "warning",
                title: "Fecha faltante",
                text: "Seleccione la fecha del tracking antes de agregar personalizados."
            });
            return;
        }
        modalEspeciales.modal("show");
    });

    document.getElementById("btnPendientes3").addEventListener("click", () => {
        if (!fechaTracking.value) {
            Swal.fire({
                icon: "warning",
                title: "Fecha faltante",
                text: "Seleccione la fecha del tracking antes de agregar pendientes."
            });
            return;
        }
        modalPendientes3.modal("show");
    });

    // SELECT / DESELECT ALL – ESPECIALES
    document.getElementById("selectAllEspeciales").addEventListener("click", () => {
        const checks = document.querySelectorAll("#tablaEspeciales .chkEspecial");
        const allChecked = [...checks].every(c => c.checked);
        checks.forEach(c => {
            c.checked = !allChecked;
            c.closest(".pkg-card").classList.toggle("selected", !allChecked);
        });
    });

    selectFiltroTipo.addEventListener("change", renderEspeciales);
    fechaTracking.addEventListener("change", () => {
        if (modalRutas.hasClass("show")) renderPaquetesRuta();

        if (modalEspeciales.hasClass("show")) {
            cargarMunicipiosDesdeEspeciales(fechaTracking.value);

            // 🔁 restaurar selección si existe
            if (municipioSeleccionado) {
                $("#municipioEspecial")
                    .val(municipioSeleccionado)
                    .trigger("change.select2");
            }

            renderEspeciales();
        }
    });


    // AGREGAR DESDE MODAL RUTA
    btnAgregarRuta.addEventListener("click", () => {
        const fechaGlobal = fechaTracking.value;
        if (!fechaGlobal) {
            Swal.fire({
                icon: "warning",
                title: "Fecha faltante",
                text: "Debe seleccionar la fecha del tracking antes de agregar paquetes por ruta."
            });
            return;
        }

        const checks = document.querySelectorAll(".chkRuta:checked");

        if (!checks.length) {
            alert("Seleccione al menos un paquete.");
            return;
        }
        checks.forEach(chk => {
            const id = chk.dataset.id;
            let pkg = paquetesCache[id];

            pkg.assigned_date = fechaGlobal; // usamos la fecha principal
            paquetesSeleccionados[id] = pkg;
        });
        renderTracking();
        actualizarTotal();
        modalRutas.modal("hide");
    });

    // AGREGAR DESDE MODAL ESPECIALES
    btnAgregarEspeciales.addEventListener("click", () => {
        const checks = document.querySelectorAll(".chkEspecial:checked");

        if (!checks.length) {
            alert("Seleccione al menos un paquete.");
            return;
        }

        const fechaGlobal = fechaTracking.value.trim();
        if (!fechaGlobal) {
            alert("Debe seleccionar la fecha del tracking antes de agregar paquetes.");
            return;
        }

        checks.forEach(chk => {
            const id = chk.dataset.id;
            const pkg = paquetesCache[id];
            pkg.assigned_date = fechaGlobal;
            paquetesSeleccionados[id] = pkg;
        });

        renderTracking();
        actualizarTotal();
        modalEspeciales.modal("hide");
    });

    // AGREGAR DESDE MODAL ESPECIALES

    btnAgregarPendientes3.addEventListener("click", () => {
        const checks = document.querySelectorAll(".chkPend3:checked");
        if (!checks.length) {
            alert("Seleccione al menos un paquete.");
            return;
        }

        checks.forEach(chk => {
            const id = chk.dataset.id;
            const pkg = paquetesCache[id];
            pkg.assigned_date = null; // no tienen fecha
            paquetesSeleccionados[id] = pkg;
        });

        renderTracking();
        actualizarTotal();
        modalPendientes3.modal("hide");
    });

    function construirDestinoConUbicacion(pkg) {
        let ubicacion = [];

        if (pkg.departamento_nombre) ubicacion.push(pkg.departamento_nombre);
        if (pkg.municipio_nombre) ubicacion.push(pkg.municipio_nombre);
        if (pkg.colonia_nombre) ubicacion.push(pkg.colonia_nombre);

        const ubicacionTexto = ubicacion.length
            ? `<div class="text-muted small">${ubicacion.join(" → ")}</div>`
            : "";

        let destinoPrincipal = "";

        switch (parseInt(pkg.tipo_servicio)) {
            case 1:
                destinoPrincipal = `Punto fijo → ${pkg.punto_fijo_nombre}`;
                break;

            case 2:
                destinoPrincipal = `Personalizado → ${pkg.destino_personalizado}`;
                break;

            case 3:
                destinoPrincipal = `Recolección → ${pkg.lugar_recolecta_paquete}`;
                if (pkg.destino_personalizado) {
                    destinoPrincipal += ` → Entregar en: ${pkg.destino_personalizado}`;
                }
                if (pkg.punto_fijo_nombre) {
                    destinoPrincipal += ` → Punto fijo: ${pkg.punto_fijo_nombre}`;
                }
                break;

            default:
                destinoPrincipal = "No definido";
        }

        return `
        <div>${destinoPrincipal}</div>
        ${ubicacionTexto}
    `;
    }

    function agregarPaqueteEscaneado(pkg, esReenvio = false) {
        const id = String(pkg.id);
        if (paquetesSeleccionados[id]) return false;
        const normalizado = Object.assign({}, pkg, {
            punto_fijo_nombre: pkg.point_name || pkg.punto_fijo_nombre || null,
            vendedor: pkg.seller_name || pkg.vendedor || '—',
            ruta_id: pkg.ruta_id || pkg.route_id || null
        });
        paquetesSeleccionados[id] = normalizado;
        paquetesCache[id] = normalizado;
        if (esReenvio) reenvioSet.add(id);
        renderTracking();
        actualizarTotal();
        return true;
    }

    function rutaEsCompatible(pkg) {
        const rutaSel = selectRuta ? selectRuta.value : '';
        if (!rutaSel || !pkg.ruta_id) return true; // sin ruta elegida o paquete sin ruta → siempre ok
        return String(pkg.ruta_id) === String(rutaSel);
    }

    window.rutaEsCompatible = rutaEsCompatible;

    // Expone la API para el scanner inline
    window.trackingApp = {
        agregarPaqueteEscaneado,
        isYaSeleccionado: id => !!paquetesSeleccionados[String(id)]
    };

    function actualizarTotal() {
        let total = 0;
        Object.values(paquetesSeleccionados).forEach(pkg => {
            total += parseFloat(pkg.monto) || 0;
        });
        document.getElementById("totalTracking").textContent =
            "$" + total.toFixed(2);
    }

    // RENDER TABLA PRINCIPAL
    function renderTracking() {
        tablaTracking.innerHTML = "";

        const pkgs = Object.values(paquetesSeleccionados);

        if (!pkgs.length) {
            tablaTracking.innerHTML = `
                <tr><td colspan="6" class="trk-empty-state">
                    <i class="fa fa-box-open"></i>
                    <strong>Sin paquetes agregados</strong>
                    <p>Usa los botones de arriba para agregar paquetes al tracking.</p>
                </td></tr>`;
            return;
        }

        pkgs.forEach(pkg => {
            const tipo = parseInt(pkg.tipo_servicio);

            const tipoTexto =
                tipo === 1 ? "Punto fijo" :
                tipo === 2 ? "Personalizado" :
                tipo === 3 ? "Recolección" :
                tipo === 4 ? "Casillero" : "Desconocido";

            // Destino principal (conciso)
            let destinoMain = "";
            let destinoSub  = "";
            switch (tipo) {
                case 1:
                    destinoMain = pkg.punto_fijo_nombre || "—";
                    break;
                case 2:
                    destinoMain = pkg.destino_personalizado || "—";
                    if (pkg.municipio_nombre) destinoSub = pkg.municipio_nombre;
                    break;
                case 3:
                    destinoMain = pkg.lugar_recolecta_paquete || "—";
                    if (pkg.destino_personalizado) destinoSub = `Entregar: ${pkg.destino_personalizado}`;
                    else if (pkg.punto_fijo_nombre) destinoSub = `Punto fijo: ${pkg.punto_fijo_nombre}`;
                    break;
                default:
                    destinoMain = "No definido";
            }

            const montoNum = parseFloat(pkg.monto);
            const montoHTML = isNaN(montoNum)
                ? `<span class="trk-monto cancelado">Cancelado</span>`
                : `<span class="trk-monto">$${montoNum.toFixed(2)}</span>`;

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><span class="trk-tipo-badge trk-tipo-${tipo}">${tipoTexto}</span></td>
                <td data-label="Paquete">
                    <span class="trk-tipo-badge trk-tipo-${tipo} trk-badge-mobile">${tipoTexto}</span>
                    <span class="trk-pkg-id">#${pkg.id}</span>
                </td>
                <td data-label="Cliente">${pkg.cliente}</td>
                <td data-label="Destino">
                    <div class="trk-dest-main">${destinoMain}</div>
                    ${destinoSub ? `<div class="trk-dest-sub">${destinoSub}</div>` : ''}
                </td>
                <td data-label="Monto">${montoHTML}</td>
                <td>
                    <button class="trk-btn-quit btnQuit" data-id="${pkg.id}" title="Quitar">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            `;
            tablaTracking.appendChild(tr);
        });

        // Botones quitar
        tablaTracking.querySelectorAll(".btnQuit").forEach(btn => {
            btn.addEventListener("click", () => {
                delete paquetesSeleccionados[btn.dataset.id];
                renderTracking();
                actualizarTotal();
            });
        });
    }

    if (selectMunicipio) {
        selectMunicipio.addEventListener("change", function () {
            municipioSeleccionado = this.value || "";
            renderEspeciales();
        });
    }

    // ── Select2 para Rutas (no selector nativo) ──
    let rutasConPaquetesIds = new Set();

    function starTemplate(state) {
        if (!state.id) return state.text;
        if (rutasConPaquetesIds.has(String(state.id))) {
            return $('<span>').append(
                $('<span style="color:#0891b2;font-weight:700;margin-right:4px;">★</span>'),
                document.createTextNode(state.text)
            );
        }
        return state.text;
    }

    $('#ruta_select').select2({
        placeholder:     'Seleccione una ruta',
        allowClear:      true,
        width:           '100%',
        dropdownParent:  $('#modalRutas'),
        templateResult:  starTemplate,
        templateSelection: starTemplate
    }).on('change', function () {
        if (!this.value) { tablaPaquetesRuta.innerHTML = ''; return; }
        loadPaquetesPorRuta(this.value);
    });

    // CARGA AUTOMÁTICA DE LISTAS AL ABRIR MODALES
    modalRutas.on('show.bs.modal', function () {
        const fecha = fechaTracking.value;
        if (!fecha) return;
        fetch('/tracking-pendientes/rutas-con-paquetes/' + fecha)
            .then(r => r.json())
            .then(data => {
                rutasConPaquetesIds = new Set(data.map(r => String(r.id)));
            });
    });

    modalEspeciales.on("shown.bs.modal", () => {
        if (!fechaTracking.value) {
            Swal.fire({
                icon: "warning",
                title: "Fecha faltante",
                text: "Seleccione la fecha del tracking antes de agregar paquetes especiales."
            });
            modalEspeciales.modal("hide");
            return;
        }
        loadEspeciales();
        // Restaurar selección
        if (municipioSeleccionado) {
            $("#municipioEspecial")
                .val(municipioSeleccionado)
                .trigger("change");
        }
    });

    modalPendientes3.on("shown.bs.modal", () => {
        if (!fechaTracking.value) {
            Swal.fire({
                icon: "warning",
                title: "Fecha faltante",
                text: "Seleccione la fecha del tracking antes de agregar paquetes pendientes."
            });
            modalPendientes3.modal("hide");
            return;
        }
        if (!listaPendientes3.length) loadPendientes3();
    });

    // GUARDAR TRACKING FINAL
    btnGuardar.addEventListener("click", () => {
        if (!Object.keys(paquetesSeleccionados).length) {
            Swal.fire({
                icon: "warning",
                title: "Sin paquetes",
                text: "Debe seleccionar al menos un paquete."
            });
            return;
        }

        if (!motorista.value) {
            Swal.fire({
                icon: "warning",
                title: "Motorista faltante",
                text: "Seleccione un motorista."
            });
            return;
        }

        // ===== Antes de levantar SweetAlert de confirmación =====
        if (!Object.keys(paquetesSeleccionados).length) {
            Swal.fire({
                icon: "warning",
                title: "Sin paquetes",
                text: "Debe seleccionar al menos un paquete."
            });
            return;
        }

        // 📌 SOLUCIÓN #2: Validación estricta del campo de Flatpickr
        const fechaSeleccionada = fechaTracking.value ? fechaTracking.value.trim() : '';

        if (!fechaSeleccionada) {
            // Para depurar, puedes agregar un 'console.log("Fecha vacía detectada: " + fechaTracking.value);' aquí
            Swal.fire({
                icon: "warning",
                title: "Fecha faltante",
                text: "Debe seleccionar la fecha de seguimiento antes de guardar."
            });
            return; // corta la ejecución, SweetAlert de confirmación NO se levanta
        }

        Swal.fire({
            title: "¿Guardar Tracking?",
            text: "Se registrará este seguimiento con los paquetes seleccionados.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#dc3545",
            confirmButtonText: "Sí, guardar",
            cancelButtonText: "Cancelar"
        }).then(result => {

            if (result.isConfirmed) {
                // Loader
                Swal.fire({
                    title: "Procesando...",
                    text: "Espere un momento",
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
                // ====== Construcción del formulario ======
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "/tracking/store";
                if (csrfInput) {
                    let c = document.createElement("input");
                    c.type = "hidden";
                    c.name = csrfInput.name;
                    c.value = csrfInput.value;
                    form.appendChild(c);
                }
                let m = document.createElement("input");
                m.type = "hidden";
                m.name = "motorista_id";
                m.value = motorista.value;
                form.appendChild(m);

                let f = document.createElement("input");
                f.type = "hidden";
                f.name = "fecha_tracking";
                f.value = fechaTracking.value.trim() || null; // nunca vacío
                form.appendChild(f);


                let r = document.createElement("input");
                r.type = "hidden";
                r.name = "ruta_id";       // <-- este nombre debe coincidir con tu columna en la DB
                r.value = selectRuta.value || "";   // <-- valor seleccionado en el select de ruta
                form.appendChild(r);

                Object.keys(paquetesSeleccionados).forEach(id => {
                    const i = document.createElement("input");
                    i.type = "hidden";
                    i.name = "paquetes[]";
                    i.value = id;
                    form.appendChild(i);
                });

                reenvioSet.forEach(id => {
                    const rp = document.createElement("input");
                    rp.type = "hidden";
                    rp.name = "reenvio_paquetes[]";
                    rp.value = id;
                    form.appendChild(rp);
                });

                document.body.appendChild(form);
                form.submit();
            }
        });
    });
    $(document).ready(function () {
        $('#motorista').select2({
            placeholder: 'Seleccione un motorista',
            allowClear: true,
            width: '100%',
            dropdownAutoWidth: false
        });

        // Reposicionar dropdown dentro del viewport en mobile
        var $motoristaDd = null;
        $('#motorista').on('select2:open', function () {
            var $sel = $(this);
            setTimeout(function () {
                $motoristaDd = $('body > .select2-container--open .select2-dropdown');
                if (!$motoristaDd.length) { $motoristaDd = null; return; }
                var rect    = $sel[0].getBoundingClientRect();
                var vw      = document.documentElement.clientWidth;
                var ddW     = $motoristaDd[0].offsetWidth;
                var left    = Math.max(12, Math.min(rect.left, vw - ddW - 12));
                $motoristaDd.css({
                    position:    'fixed',
                    top:         (rect.bottom + 1) + 'px',
                    left:        left + 'px',
                    'max-width': (vw - 24) + 'px',
                    'z-index':   9999
                });
            }, 0);
        }).on('select2:close', function () {
            if ($motoristaDd) {
                $motoristaDd.css({ position: '', top: '', left: '', 'max-width': '', 'z-index': '' });
                $motoristaDd = null;
            }
        });
    });
    // Cuando cambio la ruta manualmente
    $("#ruta_select").on("change", function () {
        if (!this.value) return;
        loadPaquetesPorRuta(this.value);
    });
    $('#municipioEspecial')
        .select2({
            placeholder: 'Todos los municipios',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalEspeciales')
        })
        .on('change', function () {
            municipioSeleccionado = $(this).val() || "";
            renderEspeciales();
        });

});

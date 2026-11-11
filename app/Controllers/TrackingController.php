<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PackageModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TrackingHeaderModel;
use App\Models\TrackingDetailsModel;
use App\Models\RouteModel;


class TrackingController extends BaseController
{
    protected $trackingHeaderModel;
    protected $trackingDetailsModel;
    protected $routeModel;
    protected $paqueteModel;

    public function __construct()
    {
        $this->trackingDetailsModel = new TrackingDetailsModel();
        $this->trackingHeaderModel = new TrackingHeaderModel();
        $this->routeModel = new RouteModel();
        $this->paqueteModel = new PackageModel();
    }
    public function index()
    {
        $chk = requerirPermiso('ver_tracking');
        if ($chk !== true) return $chk;

        $perPage = 10;
        $routeModel = new RouteModel();
        $filter_motorista_id = $this->request->getGet('motorista_id');
        $filter_status = $this->request->getGet('status');
        $filter_ruta_id = $this->request->getGet('ruta_id');
        $filter_date_from = $this->request->getGet('date_from');
        $filter_date_to = $this->request->getGet('date_to');
        $filter_search_id = $this->request->getGet('search_id');

        $builder = $this->trackingHeaderModel
            ->select('tracking_header.*, users.user_name AS motorista_name, routes.route_name AS route_name')
            ->join('users', 'users.id = tracking_header.user_id', 'left')
            ->join('routes', 'routes.id = tracking_header.route_id', 'left')
            ->orderBy('tracking_header.date', 'DESC')
            ->orderBy('tracking_header.id', 'ASC');

        if (!empty($filter_motorista_id))
            $builder->where('tracking_header.user_id', $filter_motorista_id);
        if (!empty($filter_ruta_id))
            $builder->where('tracking_header.route_id', $filter_ruta_id);
        if (!empty($filter_status) && is_array($filter_status))
            $builder->whereIn('tracking_header.status', $filter_status);
        if (!empty($filter_date_from))
            $builder->where('tracking_header.date >=', $filter_date_from);
        if (!empty($filter_date_to))
            $builder->where('tracking_header.date <=', $filter_date_to);
        if (!empty($filter_search_id))
            $builder->where('tracking_header.id', $filter_search_id);

        $trackings = $builder->paginate($perPage);
        $pager = $this->trackingHeaderModel->pager;

        $userModel = new \App\Models\UserModel();
        $motoristas = $userModel->where('role_id', 4)->findAll();

        $statusList = ['asignado', 'finalizado'];

        return view('trackings/index', [
            'trackings' => $trackings,
            'pager' => $pager,
            'motoristas' => $motoristas,
            'rutas' => $routeModel->orderBy('route_name', 'ASC')->findAll(),
            'statusList' => $statusList,
            'filter_motorista_id' => $filter_motorista_id,
            'filter_ruta_id' => $filter_ruta_id,
            'filter_status' => $filter_status,
            'filter_date_from' => $filter_date_from,
            'filter_date_to' => $filter_date_to,
            'filter_search_id' => $filter_search_id
        ]);
    }
    public function new()
    {
        $chk = requerirPermiso('crear_tracking');
        if ($chk !== true) return $chk;

        $userModel = new \App\Models\UserModel();
        $rutaModel = new RouteModel();
        $paqueteModel = new PackageModel();

        $motoristas = $userModel
            ->where('role_id', 4)
            ->orderBy('user_name', 'ASC')
            ->findAll();

        $rutas = $rutaModel
            ->orderBy('route_name', 'ASC')
            ->findAll();

        $municipios = $paqueteModel->getMunicipiosConPaquetesPersonalizados();

        return view('trackings/new', [
            'motoristas'  => $motoristas,
            'rutas'       => $rutas,
            'municipios'  => $municipios,
        ]);
    }

    public function getPendientesPorRuta($rutaId)
    {
        $paqueteModel = new PackageModel();

        $paquetes = $paqueteModel
            ->select('
                packages.*, 
                sellers.seller AS vendedor, 
                routes.route_name AS ruta_nombre, 
                settled_points.point_name AS punto_fijo_nombre
            ')
            ->join('sellers', 'sellers.id = packages.vendedor', 'left')
            ->join('settled_points', 'settled_points.id = packages.id_puntofijo', 'left')
            ->join('routes', 'routes.id = settled_points.ruta_id', 'left')
            ->where('settled_points.ruta_id', $rutaId)
            ->groupStart()
            ->where('packages.estatus', 'pendiente')
            ->orWhere('packages.estatus', 'recolectado')
            ->groupEnd()
            ->findAll();

        return $this->response->setJSON($paquetes);
    }

    public function getTodosPendientes()
    {
        $paqueteModel = new PackageModel();

        $paquetes = $paqueteModel
            ->select('
            packages.*,
            sellers.seller AS vendedor,
            routes.route_name AS ruta_nombre,
            settled_points.point_name AS punto_fijo_nombre,

            colonias.nombre AS colonia_nombre,
            municipios.id AS municipio_id,
            municipios.nombre AS municipio_nombre,
            departamentos.nombre AS departamento_nombre
        ')
            ->join('sellers', 'sellers.id = packages.vendedor', 'left')
            ->join('settled_points', 'settled_points.id = packages.id_puntofijo', 'left')
            ->join('routes', 'routes.id = settled_points.ruta_id', 'left')

            // 🔽 JOINS DE UBICACIÓN
            ->join('colonias', 'colonias.id = packages.colonia_id', 'left')
            ->join('municipios', 'municipios.id = colonias.municipio_id', 'left')
            ->join('departamentos', 'departamentos.id = municipios.departamento_id', 'left')

            ->groupStart()
            ->where('packages.estatus', 'pendiente')
            ->orWhere('packages.estatus', 'recolecta_fallida')
            ->orWhere('packages.estatus', 'recolectado')
            ->groupEnd()
            ->findAll();

        return $this->response->setJSON($paquetes);
    }

    public function store()
    {
        helper(['form', 'bitacora']);
        $session = session();

        $headerModel = new TrackingHeaderModel();
        $detailModel = new TrackingDetailsModel();
        $packageModel = new PackageModel();

        $motorista_id = $this->request->getPost('motorista_id');
        $fecha_seguimiento = $this->request->getPost('fecha_tracking');
        $paquetes = $this->request->getPost('paquetes'); // array
        $reenvio_paquetes = $this->request->getPost('reenvio_paquetes') ?: []; // paquetes marcados para reenvío desde escáner

        if (empty($motorista_id) || empty($paquetes)) {
            return redirect()->back()->with('error', 'Motorista y paquetes son requeridos')->withInput();
        }

        $ruta_id = $this->request->getPost('ruta_id') ?: null;

        // Preparar paquetes marcados para reenvío: actualizar su estatus antes del loop principal
        if (!empty($reenvio_paquetes)) {
            foreach ($reenvio_paquetes as $rpid) {
                $packageModel->update($rpid, [
                    'estatus'  => 'pendiente',
                    'estatus2' => 'reenvio',
                ]);
            }
        }

        $idHeader = $headerModel->insert([
            'user_id' => $motorista_id,
            'route_id' => $ruta_id,
            'date' => $fecha_seguimiento ?: date('Y-m-d'),
            'status' => 'asignado',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if (!$idHeader) {
            if (function_exists('registrar_bitacora')) {
                registrar_bitacora(
                    'Error de Creación de Tracking',
                    'Tracking',
                    'Fallo al insertar el encabezado del tracking. Motorista ID: ' . esc($motorista_id) . ', Paquetes: ' . count($paquetes),
                    $session->get('user_id')
                );
            }
            return redirect()->back()->with('error', 'No se pudo crear el tracking.');
        }

        $paquetesActualizados = [];

        foreach ($paquetes as $pid) {

            $paquete = $packageModel->find($pid);
            $paqueteEstatus = $paquete['estatus'] ?? 'pendiente';

            $estatus2 = $paquete['estatus2'] ?? null;
            $reenviosActuales = (int) ($paquete['reenvios'] ?? 0);

            $estadoInicial = 'asignado_para_entrega';

            if ($paquete) {
                if ($paquete['tipo_servicio'] == 3) {
                    if ($paqueteEstatus == 'pendiente' || $paqueteEstatus == 'recolecta_fallida') {
                        $estadoInicial = 'asignado_para_recolecta';
                    } else {
                        $estadoInicial = 'asignado_para_entrega';
                    }
                }

                if ($paqueteEstatus == 'recolecta_fallida') {
                    $estadoInicial = 'asignado_para_recolecta';
                }
            }

            $detailModel->insert([
                'tracking_header_id' => $idHeader,
                'package_id' => $pid,
                'status' => 'asignado',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $updateData = [
                'estatus' => $estadoInicial,
                'tracking_id' => $idHeader
            ];

            if ($estatus2 === 'reenvio') {
                $updateData['reenvios'] = $reenviosActuales + 1;
            }

            $packageModel->update($pid, $updateData);
            $paquetesActualizados[] = "ID " . esc($pid) . " → " . esc($estadoInicial);
        }

        $descripcionBitacora = 'Seguimiento **#' . esc($idHeader) . '** creado y asignado al motorista ID ' . esc($motorista_id) . ' (' . count($paquetes) . ' paquetes). Detalles de estado: ' . implode('; ', $paquetesActualizados);

        if (function_exists('registrar_bitacora')) {
            registrar_bitacora(
                'Creación de Tracking',
                'Tracking',
                $descripcionBitacora,
                $session->get('user_id')
            );
        }

        return redirect()->to(base_url('tracking/' . $idHeader))->with('success', 'Tracking creado correctamente.');
    }
    public function show($id)
    {
        $headerModel = new TrackingHeaderModel();
        $detailsModel = new TrackingDetailsModel();
        $tracking = $headerModel->getHeaderWithRelations($id);

        if (!$tracking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tracking ID $id no encontrado");
        }

        $detalles = $detailsModel->getDetailsWithPackages($id);

        return view('trackings/show', [
            'tracking' => $tracking,
            'detalles' => $detalles
        ]);
    }
    public function paquetesPorRuta($rutaId)
    {
        $fecha = $this->request->getVar('fecha');
        $paquetes = $this->paqueteModel->where('ruta_id', $rutaId)->findAll();
        return $this->response->setJSON($paquetes);
    }

    public function todos()
    {
        $paquetes = $this->paqueteModel->findAll();
        return $this->response->setJSON($paquetes);
    }

    public function fechasPaquetesDisponibles()
    {
        $from = $this->request->getGet('from');
        $to   = $this->request->getGet('to');

        $db      = \Config\Database::connect();
        $where   = "WHERE estatus IN ('pendiente','Pendiente','recolectado','recolecta_fallida')";
        $params  = [];

        if ($from && $to) {
            $where  .= " AND DATE(COALESCE(NULLIF(fecha_entrega_puntofijo,'0000-00-00'),NULLIF(fecha_ingreso,'0000-00-00'),created_at)) BETWEEN ? AND ?";
            $params  = [$from, $to];
        }

        $rows = $db->query("
            SELECT
                DATE(COALESCE(
                    NULLIF(fecha_entrega_puntofijo, '0000-00-00'),
                    NULLIF(fecha_ingreso, '0000-00-00'),
                    created_at
                )) AS fecha,
                COUNT(*) AS total
            FROM packages
            {$where}
            GROUP BY fecha
            HAVING fecha IS NOT NULL
            ORDER BY fecha ASC
        ", $params)->getResultArray();

        $data = [];
        foreach ($rows as $r) {
            if (!empty($r['fecha']) && $r['fecha'] !== '0000-00-00') {
                $data[$r['fecha']] = (int) $r['total'];
            }
        }

        return $this->response->setJSON($data);
    }

    public function rutasConPaquetes($fecha)
    {
        $fecha = filter_var($fecha, FILTER_SANITIZE_SPECIAL_CHARS);
        $db = \Config\Database::connect();
        $builder = $db->table('routes AS r');
        $builder->select('r.id, r.route_name AS text');
        $builder->distinct();
        $builder->join('packages AS p', 'r.id = p.ruta_id', 'inner');
        $builder->groupStart()
            ->where('p.fecha_entrega_puntofijo', $fecha)
            ->orWhere('p.fecha_ingreso', $fecha)
            ->groupEnd();

        $builder->groupStart()
            ->groupStart()
            ->where('p.tipo_servicio', 1)
            ->whereIn('p.estatus', ['pendiente', 'Pendiente'])
            ->groupEnd()
            ->orGroupStart()
            ->where('p.tipo_servicio', 3)
            ->whereIn('p.estatus', ['recolectado', 'recolecta_fallida'])
            ->where('p.id_puntofijo IS NOT NULL')
            ->groupEnd()
            ->groupEnd();

        $search = $this->request->getVar('search');
        if (!empty($search)) {
            $builder->like('r.route_name', $search);
        }
        $rutas = $builder->get()->getResult();
        return $this->response->setJSON($rutas);
    }

    public function labels(int $id)
    {
        $chk = requerirPermiso('ver_tracking');
        if ($chk !== true) return $chk;

        $headerModel  = new TrackingHeaderModel();
        $detailsModel = new TrackingDetailsModel();

        $tracking = $headerModel->getHeaderWithRelations($id);
        if (!$tracking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tracking #$id no encontrado");
        }

        $detalles = $detailsModel->getDetailsWithPackages($id);

        $paquetes = [];
        foreach ($detalles as $d) {
            $qrCode = !empty($d->qr_code)
                ? $d->qr_code
                : str_pad(\App\Libraries\Base62Converter::encode((int)$d->package_id), 6, '0', STR_PAD_LEFT);

            $paquetes[] = [
                'id'       => $d->package_id,
                'cliente'  => $d->cliente  ?? '—',
                'vendedor' => $d->vendedor ?? '—',
                'qr_code'  => $qrCode,
                'qr_svg'   => $this->makeQrDataUri($qrCode),
            ];
        }

        $html = view('trackings/labels_pdf', [
            'tracking' => $tracking,
            'paquetes' => $paquetes,
        ]);

        if (ob_get_length()) ob_clean();

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => [50.8, 25.4],
            'tempDir'       => WRITEPATH . 'temp',
            'margin_left'   => 2,
            'margin_right'  => 2,
            'margin_top'    => 1.5,
            'margin_bottom' => 1.5,
        ]);
        $mpdf->WriteHTML($html);

        $filename = "vinetas_tracking_{$id}.pdf";
        $pdfOutput = $mpdf->Output($filename, 'S');

        return $this->response
            ->setStatusCode(200)
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfOutput);
    }

    public function labelSingle(int $packageId)
    {
        $chk = requerirPermiso('ver_tracking');
        if ($chk !== true) return $chk;

        $packageModel = new PackageModel();
        $package = $packageModel
            ->select('packages.*, sellers.seller AS vendedor_nombre')
            ->join('sellers', 'sellers.id = packages.vendedor', 'left')
            ->find($packageId);

        if (!$package) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Paquete #$packageId no encontrado");
        }

        $qrCode = !empty($package['qr_code'])
            ? $package['qr_code']
            : str_pad(\App\Libraries\Base62Converter::encode($packageId), 6, '0', STR_PAD_LEFT);

        $paquetes = [[
            'id'       => $packageId,
            'cliente'  => $package['cliente'] ?? '—',
            'vendedor' => $package['vendedor_nombre'] ?? '—',
            'qr_code'  => $qrCode,
            'qr_svg'   => $this->makeQrDataUri($qrCode),
        ]];

        $html = view('trackings/labels_pdf', [
            'tracking' => (object)['id' => $packageId],
            'paquetes' => $paquetes,
        ]);

        if (ob_get_length()) ob_clean();

        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => [50.8, 25.4],
            'tempDir'       => WRITEPATH . 'temp',
            'margin_left'   => 2,
            'margin_right'  => 2,
            'margin_top'    => 1.5,
            'margin_bottom' => 1.5,
        ]);
        $mpdf->WriteHTML($html);

        $filename = "vineta_paquete_{$packageId}.pdf";
        $pdfOutput = $mpdf->Output($filename, 'S');

        return $this->response
            ->setStatusCode(200)
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody($pdfOutput);
    }

    private function makeQrDataUri(string $code): string
    {
        try {
            $qr   = new \TCPDF2DBarcode($code, 'QRCODE,H');
            $data = $qr->getBarcodeArray();
            if (empty($data['bcode'])) return '';

            $rows = $data['num_rows'];
            $cols = $data['num_cols'];
            $cell = round(80 / max($rows, $cols), 4);
            $w    = round($cols * $cell, 2);
            $h    = round($rows * $cell, 2);

            $rects = '';
            foreach ($data['bcode'] as $r => $row) {
                foreach ($row as $c => $v) {
                    if ($v) {
                        $rects .= '<rect x="' . round($c * $cell, 2) . '" y="' . round($r * $cell, 2)
                            . '" width="' . $cell . '" height="' . $cell . '"/>';
                    }
                }
            }

            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $h . '"'
                 . ' viewBox="0 0 ' . $w . ' ' . $h . '">'
                 . '<rect width="100%" height="100%" fill="white"/>'
                 . '<g fill="black">' . $rects . '</g></svg>';

            return 'data:image/svg+xml;base64,' . base64_encode($svg);
        } catch (\Throwable $e) {
            return '';
        }
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\SesionUsuarioModel;

class HorarioController extends BaseController
{
    protected UserModel $userModel;
    protected SesionUsuarioModel $sesionModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->sesionModel = new SesionUsuarioModel();
    }

    // Vista: trazabilidad de sesiones
    public function index()
    {
        $chk = requerirPermiso('gestionar_horarios');
        if ($chk !== true) return $chk;

        $userId  = (int)$this->request->getGet('user_id') ?: null;
        $sesiones = $this->sesionModel->getSesionesConUsuario($userId);
        $usuarios = $this->userModel
            ->select('id, user_name, email')
            ->orderBy('user_name', 'ASC')
            ->findAll();

        return view('horario/sesiones', [
            'title'          => 'Registro de Sesiones',
            'sesiones'       => $sesiones,
            'usuarios'       => $usuarios,
            'filtro_user_id' => $userId,
        ]);
    }

    // AJAX POST: actualizar horario de un usuario
    public function actualizarHorario(int $id)
    {
        $chk = requerirPermiso('gestionar_horarios');
        if ($chk !== true) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sin permiso.']);
        }

        $activo = (int)$this->request->getPost('horario_activo');
        $inicio = $this->request->getPost('horario_inicio');
        $fin    = $this->request->getPost('horario_fin');

        if ($activo && (empty($inicio) || empty($fin))) {
            return $this->response->setJSON(['success' => false, 'message' => 'Debe indicar hora de inicio y fin.']);
        }

        $this->userModel->update($id, [
            'horario_activo' => $activo,
            'horario_inicio' => $activo ? $inicio : null,
            'horario_fin'    => $activo ? $fin : null,
        ]);

        registrar_bitacora(
            'Actualizar horario',
            'Horarios',
            "Actualizó el horario del usuario ID {$id}.",
            $id
        );

        return $this->response->setJSON(['success' => true, 'message' => 'Horario actualizado correctamente.']);
    }

    // AJAX POST: marcar un usuario para cierre de sesión forzado
    public function forzarCierre(int $id)
    {
        $chk = requerirPermiso('gestionar_horarios');
        if ($chk !== true) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sin permiso.']);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Usuario no encontrado.']);
        }

        $this->userModel->update($id, ['forzar_cierre' => 1]);

        $adminName = session()->get('user_name') ?? 'Administrador';
        $this->sesionModel->registrar(
            $id,
            'forzado',
            "Cierre solicitado por {$adminName}"
        );

        registrar_bitacora(
            'Forzar cierre de sesión',
            'Horarios',
            "Solicitó el cierre de sesión del usuario ID {$id} ({$user['user_name']}).",
            $id
        );

        return $this->response->setJSON(['success' => true, 'message' => 'Solicitud de cierre enviada al usuario.']);
    }

    // AJAX GET: endpoint de polling — verifica si la sesión actual sigue siendo válida
    public function verificarSesion()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['forzar' => true, 'razon' => 'no_sesion']);
        }

        $userId = (int)session()->get('id');
        $user   = $this->userModel->find($userId);

        if (!$user) {
            return $this->response->setJSON(['forzar' => true, 'razon' => 'usuario_no_encontrado']);
        }

        // Prioridad 1: cierre forzado por administrador
        if (!empty($user['forzar_cierre']) && (int)$user['forzar_cierre'] === 1) {
            return $this->response->setJSON([
                'forzar'  => true,
                'razon'   => 'cierre_forzado',
                'mensaje' => 'Un administrador ha solicitado el cierre de tu sesión.',
            ]);
        }

        // Prioridad 2: restricción de horario
        if (!empty($user['horario_activo']) && (int)$user['horario_activo'] === 1) {
            $ahora  = date('H:i:s');
            $inicio = $user['horario_inicio'];
            $fin    = $user['horario_fin'];

            if ($inicio && $fin) {
                if ($ahora < $inicio || $ahora > $fin) {
                    return $this->response->setJSON([
                        'forzar'  => true,
                        'razon'   => 'fuera_de_horario',
                        'mensaje' => "Tu jornada laboral ha concluido ({$inicio} – {$fin}). La sesión será cerrada.",
                    ]);
                }

                $minutos = (int)((strtotime($fin) - strtotime($ahora)) / 60);

                return $this->response->setJSON([
                    'forzar'            => false,
                    'minutos_restantes' => $minutos,
                    'advertencia'       => $minutos <= 5 && $minutos > 0,
                    'fin'               => $fin,
                ]);
            }
        }

        return $this->response->setJSON([
            'forzar'            => false,
            'minutos_restantes' => null,
            'advertencia'       => false,
        ]);
    }
}

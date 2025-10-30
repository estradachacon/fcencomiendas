<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\PermisosRolModel;
use App\Models\LogModel;

class AuthController extends Controller
{
    // Carga los modelos necesarios
    protected $userModel;
    protected $permisosRolModel;
    protected $logModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->permisosRolModel = new PermisosRolModel();
        $this->logModel = new LogModel(); // <-- Instancia del nuevo modelo
    }


    public function login()
{
    if ($this->request->getMethod() !== 'post') {
        return $this->response->setJSON(['success' => false, 'message' => 'Acceso no permitido.']);
    }

    die('Entró correctamente al método POST');
}

    // public function login()
    // {
    //     // Solo aceptar peticiones POST y si es AJAX
    //     if ($this->request->getMethod() !== 'post') {
    //         // Esto es solo para evitar acceso directo, opcional.
    //         return $this->response->setJSON(['success' => false, 'message' => 'Acceso no permitido.']);
    //     }

    //     $username_input = $this->request->getPost('username');
    //     $password = $this->request->getPost('password');

    //     // 1. Validar las credenciales
    //     $user = $this->userModel->getUserByCredentials($username_input);

    //     if (!$user || !password_verify($password, $user['user_password'])) {
    //         // Error
    //         return $this->response->setJSON(['success' => false, 'message' => 'Credenciales inválidas.']);
    //     }

    //     // 2. Autenticación exitosa: Cargar Permisos
    //     $permisos_activos = $this->permisosRolModel->getPermissionsForRole($user['role_id']);

    //     $this->logModel->save([
    //         'user_id' => $user['id'], // <-- ID del usuario autenticado
    //         'tipo_accion' => 'LOGIN_EXITOSO',
    //         'modulo_afectado' => 'AUTH',
    //         'descripcion' => 'Usuario ' . $user['user_name'] . ' ha iniciado sesión.',
    //     ]);

    //     // 3. Crear el Array de Sesión
    //     $sessionData = [
    //         'isLoggedIn' => TRUE,
    //         'user_id' => $user->id,
    //         'user_name' => $user->user_name, // <-- Usamos tu campo user_name
    //         'email' => $user->email,
    //         'role_id' => $user->role_id,
    //         'role_name' => $user->role_name,
    //         'permisos_activos' => $permisos_activos,
    //     ];

    //     // 4. Guardar en la Sesión de CodeIgniter
    //     $session = session();
    //     $session->set($sessionData);

    //     // 5. Respuesta de éxito al cliente
    //     return $this->response->setJSON([
    //         'success' => true,
    //         'message' => 'Bienvenido(a) al ERP.',
    //         'redirect' => base_url('dashboard') // Redirigir al dashboard o página principal
    //     ]);
    // }
    // En App\Controllers\AuthController.php

    // ... (Clase AuthController) ...

    public function logout()
    {
        $session = session();
        $user_name = $session->get('user_name');
        $user_id = $session->get('user_id');

        // 1. Registrar el log de cierre de sesión
        if ($user_id) {
            $this->logModel->save([
                'user_id' => $user_id,
                'tipo_accion' => 'LOGOUT',
                'modulo_afectado' => 'AUTH',
                'descripcion' => 'Usuario ' . $user_name . ' ha cerrado sesión.',
            ]);
        }

        // 2. Destruir toda la información de la sesión
        $session->destroy();

        // 3. Redirigir al login
        // Puedes usar 'with('success', ...)' para mostrar un mensaje al redirigir
        return redirect()->to(base_url('/'))->with('success', '¡Has cerrado sesión correctamente!');
    }
}
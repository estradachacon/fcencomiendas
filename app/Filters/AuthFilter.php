<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Se ejecuta ANTES de que el controlador se ejecute.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Verificar si la sesión ha sido iniciada
// En App\Filters\AuthFilter.php -> before()
        if (!session()->get('isLoggedIn')) {
            // Redirige a la URL raíz, donde está tu modal de login
            return redirect()->to(base_url('/'))->with('error', 'Debes iniciar sesión para acceder al sistema.');
        }

        // OPCIONAL: Aquí también podrías implementar la verificación de PERMISOS
        // Ejemplo: Si en $arguments viene el permiso requerido, lo chequeas aquí.
    }

    /**
     * Se ejecuta DESPUÉS de que el controlador se ejecuta.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario hacer nada después de la autenticación
    }
}
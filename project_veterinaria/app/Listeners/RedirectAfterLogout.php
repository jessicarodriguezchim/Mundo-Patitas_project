<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Listener: RedirectAfterLogout
 * 
 * Este listener se ejecuta cuando ocurre el evento Logout.
 * Puede usarse para realizar acciones adicionales después del cierre de sesión,
 * como limpiar datos, registrar actividad, o redirigir a páginas específicas.
 * 
 * Nota: Actualmente no está implementado (método handle() está vacío).
 * Si necesitas acciones adicionales después del logout, puedes implementarlas aquí.
 * 
 * Uso:
 * Este listener debe registrarse en EventServiceProvider para que funcione.
 * 
 * Eventos relacionados:
 * - Logout: Se dispara cuando un usuario cierra sesión
 */
class RedirectAfterLogout
{
    /**
     * Crear una nueva instancia del listener
     * 
     * El constructor se ejecuta cuando Laravel crea una instancia del listener.
     */
    public function __construct()
    {
        // Por ahora no hay inicialización necesaria
    }

    /**
     * Manejar el evento de logout
     * 
     * Este método se ejecuta cuando ocurre el evento Logout.
     * Aquí puedes agregar lógica personalizada como:
     * - Limpiar datos de sesión adicionales
     * - Registrar la actividad de logout
     * - Redirigir a una página específica
     * - Enviar notificaciones
     * 
     * @param Logout $event Evento de logout que contiene información del usuario
     * @return void
     */
    public function handle(Logout $event): void
    {
        // Por ahora no hay acciones personalizadas
        // Puedes agregar aquí acciones que quieras ejecutar después del logout
        // Ejemplo: Log::info('Usuario cerro sesión', ['user_id' => $event->user->id]);
    }
}

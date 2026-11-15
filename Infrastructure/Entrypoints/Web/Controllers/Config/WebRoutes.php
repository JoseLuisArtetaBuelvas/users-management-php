<?php

declare(strict_types=1);

final class WebRoutes
{
    /**
     * @return array<string, array<string, string>>
     */
    public static function routes(): array
    {
        return array(
            'home' => array(
                'method' => 'GET',
                'action' => 'home',
            ),
            'users.create' => array(
                'method' => 'GET',
                'action' => 'create',
            ),
            'users.store' => array(
                'method' => 'POST',
                'action' => 'store',
            ),
            'users.index' => array(
                'method' => 'GET',
                'action' => 'index',
            ),
            'users.show' => array(
                'method' => 'GET',
                'action' => 'show',
            ),
            'users.edit' => array(
                'method' => 'GET',
                'action' => 'edit',
            ),
            'users.update' => array(
                'method' => 'POST',
                'action' => 'update',
            ),
            'users.delete' => array(
                'method' => 'POST',
                'action' => 'delete',
            ),
            'auth.login' => array(
                'method' => 'GET',
                'action' => 'login',
            ),
            'auth.authenticate' => array(
                'method' => 'POST',
                'action' => 'authenticate',
            ),
            'auth.logout' => array(
                'method' => 'GET',
                'action' => 'logout',
            ),
            'auth.forgot' => array(
                'method' => 'GET',
                'action' => 'forgot',
            ),
            'auth.forgot.send' => array(
                'method' => 'POST',
                'action' => 'forgot.send',
            ),

            // ── Docentes (ejercicio 3) ── requieren sesión iniciada
            'docentes.index' => array(
                'method' => 'GET',
                'action' => 'docentes.index',
            ),
            'docentes.create' => array(
                'method' => 'GET',
                'action' => 'docentes.create',
            ),
            'docentes.store' => array(
                'method' => 'POST',
                'action' => 'docentes.store',
            ),
            'docentes.show' => array(
                'method' => 'GET',
                'action' => 'docentes.show',
            ),
            'docentes.edit' => array(
                'method' => 'GET',
                'action' => 'docentes.edit',
            ),
            'docentes.update' => array(
                'method' => 'POST',
                'action' => 'docentes.update',
            ),
            'docentes.delete' => array(
                'method' => 'POST',
                'action' => 'docentes.delete',
            ),
        );
    }
}
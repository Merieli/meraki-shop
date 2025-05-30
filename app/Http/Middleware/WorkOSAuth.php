<?php

namespace MerakiShop\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WorkOSAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o token está presente no header
        if (!$request->bearerToken()) {
            return response()->json([
                'message' => 'Token não fornecido'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Tenta autenticar o usuário com o token
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'message' => 'Token inválido ou expirado'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Adiciona o usuário autenticado ao request para uso posterior
        $request->merge(['auth_user' => Auth::guard('sanctum')->user()]);

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Pemakaian di route: ->middleware('role:admin') atau ->middleware('role:admin,petugas')
     * Guest (belum login) diarahkan ke halaman login.
     * User login tetapi role tidak diizinkan mendapat error 403.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! in_array($request->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki hak akses untuk aksi ini.');
        }

        return $next($request);
    }
}

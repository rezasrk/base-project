<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessControlMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $permissions = Permission::query()->get()->pluck('name')->toArray();
        $permission = preg_replace('/\.v\d+\./', '.', $request->route()->getName());

        if (in_array($permission, $permissions) && !$request->user()->hasPermissionTo($permission, 'sanctum')) {
            return response()->error(__('messages.exceptions.access_denied'), JsonResponse::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}

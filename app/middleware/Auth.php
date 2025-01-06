<?php
declare (strict_types = 1);

namespace app\middleware;

use think\facade\Session;
use think\facade\Log;

class Auth
{
    public function handle($request, \Closure $next)
    {
        // Public routes that don't require authentication
        $publicRoutes = [
            'user/login',
            'user/register',
            'user/loginpage',
            'user/registerpage'
        ];

        // Get the current route
        $route = strtolower($request->controller() . '/' . $request->action());
        
        Log::info('Current route: ' . $route);
        Log::info('Session user_id: ' . Session::get('user_id'));
        Log::info('Session data: ' . json_encode(Session::all()));

        // Check if the route requires authentication
        if (!in_array($route, $publicRoutes)) {
            // Check if user is logged in
            if (!Session::has('user_id')) {
                Log::warning('Auth middleware: User not logged in, redirecting to login page');
                // If it's an AJAX request
                if ($request->isAjax()) {
                    return json(['code' => 401, 'msg' => 'Please login first']);
                }
                // If it's a regular request
                return redirect((string)url('/user/login'));
            }
            Log::info('Auth middleware: User authenticated, proceeding to route');
        } else {
            Log::info('Auth middleware: Public route, no authentication required');
        }

        return $next($request);
    }
}

<?php
declare (strict_types = 1);

namespace app\middleware;

use think\facade\Session;

class CheckAuth
{
    public function handle($request, \Closure $next)
    {
        // Add CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');
        header('Access-Control-Max-Age: 1728000');
        
        if ($request->isOptions()) {
            return response();
        }

        // Check if the route requires authentication
        $authRoutes = ['chat', 'message'];
        $controllerName = strtolower($request->controller());
        
        if (in_array($controllerName, $authRoutes) && !Session::has('user_id')) {
            if ($request->isAjax()) {
                return json(['code' => 401, 'msg' => 'Please login first']);
            }
            return redirect('/user/login');
        }

        return $next($request);
    }
}

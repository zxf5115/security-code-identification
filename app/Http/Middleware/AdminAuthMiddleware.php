<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\System\Iptable;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {
        $guard='admin';

        $iptable = Iptable::getIptableList();

        if(in_array($request->getClientIp(), $iptable))
        {
            return response('您已被禁止访问该系统，请联系管理员。', 401);
        }

        if (Auth::guard($guard)->guest()) {
            //记录需要登陆的页面，登陆之后跳回
            //$request->session()->put('login_back_url',$request->getUri());

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('admin.login');
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\Manager;
use App\Models\OaWechat;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
//            return response('Unauthorized.', 401);
            return response([
                "code" => 401,
                "message" => "未授权",
                "data" => []
            ], 200);
        }
        $raw = "find_in_set(?,". Manager::DB_FILED_LEVEL_MAP .")";
        $budding = [$this->auth->guard($guard)->user()->getkey()];
        $wechat = OaWechat::whereRaw($raw,$budding)
            ->leftJoin(
                Manager::TABLE_NAME,
                Manager::TABLE_NAME . '.' .Manager::DB_FILED_ID, "=",
                OaWechat::TABLE_NAME . "." . OaWechat::DB_FILED_MANAGER_ID
            )
            ->select(OaWechat::TABLE_NAME . ".*")
            ->get();
        $wechatIds = $wechat->pluck(OaWechat::DB_FILED_ID)->all();
        $request->offsetSet('wechatIds', $wechatIds);
        if ($request->has("oa_wechat_id")) {
            if (!in_array($request->has("oa_wechat_id"), $wechatIds)) {
                return response([
                    "code" => 401,
                    "message" => "非法操作",
                    "data" => []
                ], 200);
            }
        }
        return $next($request);
    }
}

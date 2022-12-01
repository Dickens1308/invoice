<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if (is_null($request->bearerToken())) {
            if ($request->url() === route('auth.login') || $request->url() === route('auth.register')) {
                return $next($request);
            } else {
                return response()->json(['status' => Response::HTTP_BAD_REQUEST, 'message' => 'Token required'], Response::HTTP_BAD_REQUEST);
            }
        }

        if ($request->url() == route('auth.login') || $request->url() == route('auth.register')) {
            return $next($request);
        }

        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            $payload = json_decode(auth()->payload(), true);
            $rawUriPath = explode("\\", $request->route()->getActionName());
            $controllerName = end($rawUriPath);

            if ($request->url() === route('auth.refresh') && $e instanceof TokenExpiredException) {
                $payload = json_decode(auth()->payload(), true);
                if (
                    array_key_exists('type', $payload)
                    and $payload['type'] == 'refresh'
                    and env('TOKEN_REFRESH_PATH') == $controllerName
                )
                    return $next($request);
                else {
                    if (isset($payload['type']) and $payload['type'] == 'refresh')
                        return response()->json([
                            'status' => Response::HTTP_BAD_REQUEST,
                            'message' => 'Invalid access token'
                        ], Response::HTTP_BAD_REQUEST);

                    if (array_key_exists('uuid', $payload) and $request->route()->getPrefix() === 'api/user-log') {
                        return $next($request);
                    }
                }
                // try {
                //     $token = JWTAuth::refresh();
                // } catch (TokenBlacklistedException $exception) {
                //     return response()->json([
                //         'status' => Response::HTTP_UNAUTHORIZED,
                //         'message' => $exception->getMessage()
                //     ], Response::HTTP_UNAUTHORIZED);
                // }

                // return response()->json([
                //     'status' => Response::HTTP_OK,
                //     'access_token' => $token,

                // ], Response::HTTP_OK);
            }

            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => $e->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}

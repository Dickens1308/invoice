<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use PHPUnit\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.jwt', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        Log::channel("authentication")->info("User with Email " . $request->email . " tries to login");
        $validator = Validator::make($request->all(), [
            'password' => 'required|max:8|string',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            Log::channel("authentication")->error("Invalid form data for logging user");
            return response()->json(
                array(
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'invalid form input',
                    'data' => $validator->errors()
                ), Response::HTTP_FORBIDDEN
            );
        }

        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            Log::channel("authentication")->error("User with Email " . $request->email . " failed to login");
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        Log::channel("authentication")->info("User with Email " . $request->email
            . " successful logged in at " . Carbon::now());
        return $this->respondWithToken($token, $credentials);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $credentials): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'access_token' => $token,
            'refresh_token' => auth()->claims(['type' => 'refresh', 'expIn' => (auth()->factory()->getTTL() * 60) * 2])->setTTL(10)->attempt($credentials),
            'data' => [
                'name' => Auth::user()->name,
                'roles' => Auth::user()->getRoleNames()
            ],
            'message' => 'Logged in',
        ], Response::HTTP_OK);
    }

    /**
     *Register User and Redirect To Login
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|max:20|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required', Password::min(8)->mixedCase()->numbers()
                        ->symbols()
                ],
            ]);


            if ($validator->fails()) {
                return response()->json(
                    array(
                        'status' => Response::HTTP_FORBIDDEN,
                        'message' => 'invalid form input',
                        'data' => $validator->errors()
                    ), Response::HTTP_FORBIDDEN
                );
            }

            $userData = array(
                'name' => $request->input('username'),
                'email' => $request->input('email'),
                'uuid' => fake()->uuid(),
                'password' => bcrypt($request->input('password'))
            );

            $user = User::create($userData);
            if ($user) {
                $user->assignRole('user');

                return response()->json(
                    array(
                        'status' => Response::HTTP_OK,
                        'message' => 'succesful registered, login to continue'
                    ), Response::HTTP_OK
                );
            } else {
                return response()->json(
                    array(
                        'status' => Response::HTTP_FORBIDDEN,
                        'message' => 'Registration fail'
                    ), Response::HTTP_FORBIDDEN
                );
            }

        } catch (Exception $e) {
            return response()->json(
                array(
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Registration fail. please try again',
                ), Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): JsonResponse
    {
        try {
            return response()->json([
                "status" => Response::HTTP_OK,
                "data" => auth()->user(),
                "roles" => auth()->user()->getRoleNames(),
            ], 200);
        } catch (UserNotDefinedException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'access_token' => auth()->refresh(),
        ], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers;

use App\Eloquent\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login action.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $data = User::login($request);

            return response()->json($data, $data['code']);
        } catch (Exception $e) {
            return response()->json(['data' => $e, 'message' => 'Error'], 500);
        }
    }

    /**
     * Register action.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $data = User::register($request);

            return response()->json($data, $data['code']);
        } catch (Exception $e) {
            return response()->json(['data' => $e, 'message' => 'Error'], 500);
        }
    }

}

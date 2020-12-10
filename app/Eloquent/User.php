<?php

namespace App\Eloquent;

use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return bool
     */
    public function blocked()
    {
        return $this->role_id == 4;
    }

    /**
     * @return array|false
     */
    protected static function credentials()
    {
        $numargs = func_num_args();
        if ($numargs == 1) {
            $args = func_get_args();
            if (gettype($args[0]) == 'array') {
                return [
                    'email' => strtolower($args[0]['email']),
                    'password' => $args[0]['password'],
                ];
            }
            if (gettype($args[0]) == "object") {

                return [
                    'email' => strtolower($args[0]->email),
                    'password' => $args[0]->password,
                ];
            }

        }
        return false;
    }

    /**
     * @param Request $request
     * @return array
     */
    public static function login(Request $request)
    {
        if (!Auth::attempt(self::credentials($request))) {
            return [
                'data' => 'You cannot sign with these credentials',
                'message' => 'Unauthorised',
                'code' => 401
            ];
        }

        $user = Auth::user();

        if ($user->blocked()) {
            return [
                'data' => 'User blocked',
                'message' => 'Unauthorised',
                'code' => 401
            ];
        }

        $token = $user->createToken(config('app.name'));
        $token->token->save();

        $data = [
            'data' => [
                'user' => $user,
                'token_type' => 'Bearer',
                'token' => $token->accessToken,
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
            ],
            'message' => 'Success',
            'code' => 200
        ];
        return $data;
    }

    /**
     * @param $request
     * @param string $role
     * @return array
     */
    public static function register($request, $role = 'default') {
        $role = Roles::where('name', $role)->first();
        $credentials = self::credentials($request);

        $user = new self();
        $user->name = $request->username;
        $user->email = $credentials['email'];
        $user->password = bcrypt($credentials['password']);
        $user->role_id = $role->id;

        if (!$user->save()) {
            return [
                'data' => "User not created",
                'message' => 'Error',
                'code' => 500
            ];
        }

        return [
            'data' => $user,
            'message' => 'Success',
            'code' => 200
        ];
    }
}

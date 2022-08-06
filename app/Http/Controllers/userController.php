<?php


namespace App\Http\Controllers;

use App\import\UsersImport;
use App\Model\admin;
use App\Model\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use Tymon\JWTAuth\Facades\JWTAuth;

class userController extends Controller

{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

//    public function __construct()
//
//    {
//
//        $this->middleware('auth:api', ['except' => ['login']]);
//
//    }

    public function registed(Request $registeredRequest)
    {
        $count = User::checknumber($registeredRequest);   //检测账号密码是否存在
        if($count == 0)
        {
            $student_id = User::createUser(self::userHandle($registeredRequest));
            return  $student_id ?
                json_success('注册成功!',$student_id,200  ) :
                json_fail('注册失败!',null,100  ) ;
        }
        else{
            return
                json_success('注册失败!该工号已经注册过了！',null,100  ) ;
        }
    }

    /**
     * @param Request $registeredRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminregisted(Request $registeredRequest)
    {
        $count = admin::checknumber($registeredRequest);   //检测账号密码是否存在
        if($count == 0)
        {
            $student_id = admin::createUser(self::userHandle($registeredRequest));
            return  $student_id ?
                json_success('注册成功!',$student_id,200  ) :
                json_fail('注册失败!',null,100  ) ;
        }
        else{
            return
                json_success('注册失败!该工号已经注册过了！',null,100  ) ;
        }
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login()

    {

        $credentials = request(['email', 'password']);
        $token = auth('api')->attempt($credentials);

        return $token?
            json_success('登录成功!',$token,  200):
            json_fail('登录失败!账号或密码错误',null, 100 ) ;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminlogin()

    {

        $credentials = request(['email', 'password']);
        $token = auth('api2')->attempt($credentials);

        return $token?
            json_success('登录成功!',$token,  200):
            json_fail('登录失败!账号或密码错误',null, 100 ) ;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout()

    {

        JWTAuth::parseToken()->invalidate();

        return response()->json(['message' => 'Successfully logged out']);

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function refresh()

    {

        return $this->respondWithToken(JWTAuth::parseToken()->refresh());

    }

    /**

     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

    protected function respondWithToken($token)

    {

        return response()->json([

            'access_token' => $token,

            'token_type' => 'bearer',

            'expires_in' => JWTAuth::factory()->getTTL() * 60

        ]);

    }

    /**
     * 获取账号密码返回
     */
    protected function credentials($request)   //从前端获取账号密码
    {
        return ['email' => $request['email'], 'password' => $request['password']];
    }
    /**
     * 对密码进行哈希256加密
     */
    protected function userHandle($request)   //对密码进行哈希256加密
    {
        $registeredInfo = $request->except('password_confirmation');
        $registeredInfo['password'] = bcrypt($registeredInfo['password']);
        $registeredInfo['email'] = $request['email'];
        return $registeredInfo;
    }
    /**
     * 修改密码时从新加密
     */
    protected function userHandle111($password)   //对密码进行哈希256加密
    {
        $red = bcrypt($password);
        return $red;
    }






}

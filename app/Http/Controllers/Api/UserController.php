<?php
namespace App\Http\Controllers\Api;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Alumno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
           
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        $user = new User([
       
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->save();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        return response([
            'message' => 'User created successfully!'
        ], 201);
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            /*  'remember_me' => 'boolean', */
        ]);
        $credentials = $request->only('email', 'password');

        $user = User::firstWhere('email',$credentials['email']);

        if(!$user){
            return response([
                'message' => 'User not found',
            ], 401);
        }

        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(4);
        }
        $data = [];
        if($user->role == "alumno"){
            $data = Alumno::select('nombre','paterno','materno', 'cuenta')->firstWhere('user_id',$user->id);
            $data = $this->objectToArray($data);
        }

        $token->save();
        $userData = [];
        $userData['id'] = $user->id;
        $userData['email'] = $user->email;
        $userData['role'] = $user->role;
        return response([
            'user' => array_merge($userData,$data),
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at
            )
                ->toDateTimeString(),
        ]);
    }

    public function objectToArray(&$object)
    {
        return @json_decode(json_encode($object), true);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response(['message' =>
        'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response($request->user());
    }


    public function all(Request $request){
        return response(User::all());
    }

    public function single($id){
        $user = User::find($id);
        if($user){
            return response($user);
        }
        return response([
            'message' => 'User not found'
        ],404);
    }


    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string',
        ]);

        $item = User::find($id);
        if($item){
            $item->update([
                'name' => $request->name,
            ]);
            return response($item);
        }
        return response(['message' => "User not found"],404);
    }


    public function delete($id){
        $item = User::find($id);
        if($item){
            $item->delete();
            return response(['message' => "User deleted"]);
        }
        return response(['message' => "User not found"],404);
    }


    public function updatePassword(Request $request, $id){
        $user = $request->user();
        
        if($user->id != $id){
            return response([ 'message' => 'Unauthorized'],401);
        }
        
        $data = $request->only('old_password', 'password', 'password_confirmation');
    
        if($data['password'] != $data['password_confirmation']){
            return response(['message' => "Invalid password confirmation"],400);
        }
        
        
        $userDB = User::find($user->id);

         if (!Hash::check($data['old_password'], $userDB->password)) {
            return response([
                'message' => 'Unauthorized'
            ], 401);
        } 
        //Update password
        
        $userDB->update([
            'password' =>  bcrypt($data['password'])
        ]);
        
        return response(['message' => "Password updated successfully"]);
    }   
    
}
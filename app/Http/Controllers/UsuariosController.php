<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\RolUsuario;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuariosController extends Controller 
{
    


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
   
        $data = json_encode( $request->header('authorization')) ;
        Log::info(trim(str_replace("Bearer ", "", $data).""));
        $token = str_replace("Bearer ", "", $data);
        $header = "";
        $payload  ="";
        $signature = "";

        $iterator =0;
        foreach ( str_split( $token) as $value) {
            if($value == "."){
                $iterator++;
                continue;
            }

            if($iterator == 0){

                $header.= $value;
            }
            if($iterator == 1){
                $payload.= $value;
            }
            if($iterator == 2){
                $signature.= $value;
            }

        }
        $header = str_replace("\"","",$header);
        $signature = str_replace("\"","",$signature);
        Log::info("Header: ". $header."\n"."Payload: ".$payload."\n"."Signature: ".$signature);
        
        $token = $header.".".$payload.".".$signature;
      
     
        
         $decoded =base64_decode($payload);
         $arrayToken = json_decode($decoded,true);
         Log::info("Token : ". json_encode($arrayToken));
        
        try {
            if (! $token = JWTAuth::attempt($arrayToken)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Get the authenticated user.
            $user = Auth::user();
            $idRol = RolUsuario::where('user_id', $user->email)->first()->role_id;
            $rol = Rol::where('id', $idRol)->first();
             
        

            return $rol->name;
        } catch (JWTException $e) {
            return null;
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::getUser());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
      Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
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
            'expires_in' =>  2* 60
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = $this->login($request);
        if($user){
            $users = User::all();
            return response()->json(['usuarios' => json_encode($users)]);
        }else{

            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(($rol= $this->login($request)) == "Administrador"){
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
                'rol' => 'required|string', 
            ]);
        
            try {
        
                DB::beginTransaction();
        
              
                $newUser = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password), 
                ]);
        
            
                $rol = Rol::where('name', $request->rol)->firstOrFail();
        
            
                $newRolUsuario = RolUsuario::create([
                    'user_id' => $newUser->email,
                    'role_id' => $rol->id,    
                ]);
        
             
                DB::commit();
        
                return response()->json(['response' => "Usuario creado con éxito."], 201);
        
            } catch (\Exception $e) {
                
                DB::rollBack();
                return response()->json(['error' => 'Hubo un problema al crear el usuario.', 'details' => $e->getMessage()], 500);
            }
        }else{
            return response()->json(['error' => 'No tienes las credenciales', 401]);
        }
        
       
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $id)
    {
        //
        if ($rol= $this->login($request)){
            Log::info(json_encode($rol));
            $desiredUser = User::where('email', $id)->first();
            return response()->json(["usuario" => $desiredUser]);
        }else{
            return response()->json(['error' => 'No tienes las credenciales', 401]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if($rol= $this->login($request) == "Administrador"){
          
            $request->validate([
                'name' => 'string|max:255',
                'email' => 'email|unique:users,email',
                'password' => 'string',
                'rol' => 'string', 
            ]);
            Log::info("En VALIDADO");
        
            try {
        
                DB::beginTransaction();
                    $rol = Rol::where('name', $request->rol)->firstOrFail();
                    $newUser = User::where('email', $id)->first();

                   
                    RolUsuario::where('user_id', $newUser->email)
                        ->update(['user_id' => $request->email]);

                 
                    $newUser->name = $request->name;
                    $newUser->email = $request->email;
                    $newUser->password = bcrypt($request->password);
                    $newUser->save();

                    
                    $newRolUsuario = RolUsuario::updateOrCreate([
                        'user_id' => $request->email,
                        'role_id' => $rol->id
                    ]);
                
                DB::commit();
        
                return response()->json(['response' => "Usuario modificado con éxito."], 201);
        
            } catch (\Exception $e) {
       
                DB::rollBack();
                return response()->json(['error' => 'Hubo un problema al modificar el usuario.', 'details' => $e->getMessage()], 500);
            }
        }else{
            return response()->json(['error' => 'No tienes las credenciales', 401]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        //

        if ($rol= $this->login($request) == "Administrador"){
            $desiredUser = User::where('email', $id)->first();
            if($desiredUser){
                $desiredUser->delete();
                return response()->json(["response" => 'usuario eliminado con exito']);
            }   
        
            return response()->json(["error" => 'no se pudo eliminar al usuario']);
        }else{
            return response()->json(['error' => 'No tienes las credenciales', 401]);
        }
        
    }
}

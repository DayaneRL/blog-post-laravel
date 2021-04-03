<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Roles;
use App\UserRoles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Foto;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()){
            if(userIsAdmin(Auth::user())){
                $users = $this->user->paginate(5);

                return view('users.index', compact('users'));
            }else{
                return redirect()->route('os.index');
            }
        }else{
            return redirect()->route('login')->with('warning',"Faça login primeiro");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles= Roles::all();
        if(Auth::user()){
             return view('users.create', compact('roles'));
        }else{
            return redirect()->route('login')->with('warning',"Faça login primeiro");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        DB::beginTransaction();
        try {
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            
            foreach($request->roles as $role){
                UserRoles::create([
                    'user_id' => $user->id,
                    'roles_id' => $role
                ]);
            }
            
            DB::commit();
            return redirect()->route('os.index')->with('status', "Usuário $user->name cadastrado com sucesso" );
        }  catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()){
            return redirect()->route('login')->with('warning',"É obrigatório fazer login.");
        }
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()){
            return redirect()->route('login')->with('warning',"É obrigatório fazer login.");
        }
        $user = User::findOrFail($id);
        $roles= Roles::all();

        $objectUserRoles = $user->user_roles;
        $array = json_decode($objectUserRoles, true);
        $userRoles = array_column($array, 'roles_id');
        
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        DB::beginTransaction();
        try {
            if($request->password && $request->password_confirmation){
                if($request->password != $request->password_confirmation){
                    return back()->with('error', "A confirmação para o campo Senha não coincide.");
                }
            }
            $user->name = strtoupper($request->name);
            $user->email = $request->email;
            if($request->password) $user->password = Hash::make($request->password);
            $user->update();

            $user->roles()->sync($request->roles);
            DB::commit();

            return redirect()->route('user.show', $id)->with('success', "Usuário $user->name atualizado(a) com sucesso" );
        }  catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            DB::beginTransaction();
            $user = User::find($id);
            $user->delete();

            DB::commit();
            return redirect()->route('post.index')->with('success', "Usuário $user->name deletado com sucesso" );
        }  catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function imagem(Request $request)
    {
        
        try{
            DB::beginTransaction();
            $user = User::find(Auth::user()->id);

            $file = $request->file;
            $imageArray1 = explode(';',$file);
            $imageArray2 = explode(',',$imageArray1[1]);

            $data = base64_decode($imageArray2[1]);
            
            $name = date('HisYmd');
            $extension = explode('/', $imageArray1[0]);
            $nameFile = "$name.$extension[1]";

            $upload = file_put_contents('../public/storage/categories/'.$nameFile, $data);
            
            if ( !$upload ){
                return ['error'=> 'Falha ao fazer upload'];
            }else{
                $foto = new Foto;
                $foto->foto = $nameFile;
                $foto->save();

                $user->id_foto = $foto->id;
            }
            $user->update();
            
            DB::commit();
            return ['deucerto'=>"Imagem de perfil  atualizado(a) com sucesso",'nomeCriado'=>$nameFile];
        }  catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return ['error'=>$exception->getMessage()];
        }
    }

    public function destroyImagem($id)
    {
        try{
            DB::beginTransaction();
            $user = User::find($id);
            $foto = Foto::find($user->foto->id);

            unlink('../public/storage/categories/'.$foto->foto);
            $foto->delete();
            $user->id_foto = null;
            $user->update();
            
            DB::commit();
            return ['deucerto'=>"Imagem de perfil deletado com sucesso"];
        }  catch (ModelNotFoundException $exception) {
            DB::rollBack();
            return ['error'=>$exception->getMessage()];
        }
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\MyResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;


    protected static function get_list_user($request){

        $estado = $request->state;
    
        $list  = DB::select('call User_List (?,?)', array(1,$estado));

        return $list;
    
    }


    protected static function get_user_detalle($request){

        $id_user = $request->usuario;
    
        $list  = DB::select('call User_Get (?,?)', array(1,$id_user));

        return $list;
    
    }

    protected static function delete_user($request){

        $usuario = $request->usuario;

        $id_user = Auth::user()->id;

        $rpta  = DB::update('call User_Delete (?,?,?)', array(1,$usuario,$id_user));

        return $rpta;
    
    }


    protected static function save_user($request){

        $usuario    = $request->user_id;
        $nombre     = $request->user_nombre;
        $apepat     = $request->ape_pat;
        $apemat     = $request->ape_mat;
        $email      = $request->email;
        $estado     = $request->user_estado;
        $rol        = $request->user_roles;
        
        $id_user    = Auth::user()->id;
        $imagen     = (isset(User::find($usuario)->imagen))?User::find($usuario)->imagen:null;


        $correo_contacto = $request->email_contacto;
        $celular         = $request->celular;
        $telefono_fijo   = $request->fijo;


        if ($request->hasFile('setImage')) {
            $dir = 'profiles/';
            $ext = strtolower($request->file('setImage')->getClientOriginalExtension()); 
            $fileName = str_random() . '.' . $ext;
            $request->file('setImage')->move($dir, $fileName);
            $imagen = $fileName;

        }


        if($request->remove==1){

            $imagen=null;
        }

        if($usuario==0){
            
            $generate_password = str_random(8);

            $user = new User;

            $nombres = $nombre." ".$apepat." ".$apemat;

            $user->enviar_contrasena_email($nombres,$email,$generate_password);

            $contrasena = bcrypt($generate_password);


            $rpta  = DB::insert('call User_InsertUpdate (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array(1,$usuario,$apepat,$apemat,$nombre,$email,$contrasena,$rol,$estado,$id_user,$imagen,$correo_contacto,$celular,$telefono_fijo));


            $message = ($rpta==1)?'Se creo satisfactoriamente el usuario':'Ocurrió un error';

            return array("status"=>$rpta,"description"=>$message);

        }else{

            $old_password = User::find($usuario)->password;

            if($old_password==$request->password){

                $contrasena = $old_password;

            }else{

                $contrasena = bcrypt($request->password);
            }

             $rpta  = DB::update('call User_InsertUpdate (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array(1,$usuario,$apepat,$apemat,$nombre,$email,$contrasena,$rol,$estado,$id_user,$imagen,$correo_contacto,$celular,$telefono_fijo));

             $message = ($rpta==1)?'Se actualizó satisfactoriamente el usuario':'Ocurrió un error';

             return array("status"=>$rpta,"description"=>$message);
            
        }

     
    
    }



    protected static function reset_contrasena_usuario($request){

    
        $user = User::find($request->usuario);

        $send = new User;

        $generate_password = str_random(8);

        $user->password = bcrypt($generate_password);
        $user->IdUsuarioModificacion = Auth::user()->id;
        $user->FechaModificacion = Carbon::now();
        $user->save();
        

        $nombres = $user->nombres." ".$user->apellido_paterno." ".$user->apellido_materno;
        $email   = $user->email;

        $send->enviar_contrasena_email($nombres,$email,$generate_password);

        return $user->save();
    }

    public function enviar_contrasena_email($nombres,$destinatario,$generate_password){

        $correo = new \App\Mail\WelcomeUser($nombres,$generate_password);
    
        \Mail::to($destinatario)->send($correo);
    }


    public function sendPasswordResetNotification($token)
    {
    
        $this->notify(new MyResetPassword($token));

    }


     public function bloqueo_usuario_intentos_fallidos($email){

        DB::update("UPDATE users SET flag_activo=0 WHERE email=?",array($email));
        

    }


}

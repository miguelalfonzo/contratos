<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Carbon\Carbon;
class Cliente extends Model
{   
    protected $table='cliente';

   
   protected static function get_list_clientes($request){

   		$id_estado = $request->state;

    	$list  = DB::select('call Cliente_List (?)', array($id_estado));

    	return $list;
    
   }


    protected static function delete_cliente($request){

   		$identificador = $request->identificador;

   		$id_user = Auth::user()->id;

    	$rpta  = DB::update('call Cliente_Delete (?,?)', array($identificador,$id_user));

    	return $rpta;
    
    }

    
    protected static function get_cliente($id){

      $cliente = Cliente::select('cliente.*', 'ubigeo.*','consorcio.IdConsorcio')
                ->leftJoin('ubigeo', 'cliente.Ubigeo', '=', 'ubigeo.IdUbigeo')
                ->leftJoin('consorcio', 'consorcio.IdCliente', '=', 'cliente.IdCliente')
                ->where('cliente.IdCliente',$id)
                ->first();

      return $cliente;
    
   }

   protected static function get_cliente_contactos($id){

      $list  = DB::select('call Cliente_Contacto_List (?)', array($id));

      return $list;
    
   }

    protected static function get_cliente_representantes($request){

      $id_cliente = $request->id_cliente;

      $list  = DB::select('call Cliente_Representante_List (?)', array($id_cliente));

      return $list;
    
   }


   protected static function get_cliente_empresas($request){

      $cliente_id_consorcio = $request->cliente_id_consorcio;

      $list  = DB::select('call Cliente_Empresas_List (?)', array($cliente_id_consorcio));

      return self::set_array_clientes_consorcio($list);

      
    
   }


  protected static function get_combo_empresas($query){

      $list  = DB::select('call Cliente_List_Autocompletar (?)', array($query));

        return $list;

      
    
   }


protected static function get_combo_empresas_financieras($query){

      $list  = DB::select('call Cliente_List_Autocompletar_Financieras (?)', array($query));

        return $list;

      
    
   }


   protected static function get_combo_empresas_beneficiarias($query){

      $list  = DB::select('call Cliente_List_Autocompletar_Beneficiarios (?)', array($query));

        return $list;

      
    
   }

   protected static function set_array_clientes_consorcio($list){

      $array= array();

      foreach ($list as $value) {
        
        $clientes_asociados = $value->clientes_asociados;
        
        $porcentajes_asociados = $value->porcentajes_asociados;

        $clientes_asociados_json = json_decode($clientes_asociados,true);

        $porcentajes_asociados_json = json_decode($porcentajes_asociados,true);

          foreach ($clientes_asociados_json as $key => $clientes_asociados_list) {
            
              foreach ($porcentajes_asociados_json as $key2 => $porcentajes_asociados_json_list) {
              
                if($key == $key2){

                  $cliente = Cliente::where('IdCliente',$clientes_asociados_list)->first();

                  $razon_social = $cliente->Nombre;

                  $numero_documento = $cliente->Identificacion;

                  $array[]=array("IdCliente"=>$clientes_asociados_list,"NumeroDocumento"=>$numero_documento,"RazonSocial"=>$razon_social,"Porcentaje"=>$porcentajes_asociados_json_list);

                }
                


              }

            
          }

      }

      return $array;

   }


   protected static function get_cliente_accionistas($request){

      $id_cliente = $request->id_cliente;

      $list  = DB::select('call Cliente_Accionista_List (?)', array($id_cliente));

      return $list;
    
   }

  
  protected static function get_cliente_documentos($request){

      $id_cliente = $request->id_cliente;

      $list  = DB::select('call Cliente_Documento_List (?)', array($id_cliente));

      return $list;
    
   }

   protected static function set_insert_masivo_contactos($matriz,$idCliente){

        $row =' ';

        $matriz = json_decode($matriz,true);
        
        foreach ($matriz as $list) {
            
            $row.="($idCliente,'".$list['nombres']."','".$list['telefono']."','".$list['celular']."','".$list['email']."'),";

        }
        $row = rtrim($row, ',');

        $subquery ="INSERT INTO cliente_contactos(IdCliente,Contacto,TelefonoContacto,CelularContacto,MailContacto) VALUES ".$row;

        return $subquery ;
    }

   protected static function save_cliente($request){

      $id_cliente     = $request->cliente_id_empresa;
      $identificacion = $request->cliente_identificacion;
      $tipo_documento = $request->cliente_documento;
      $razon_social   = $request->cliente_rsocial;
      $nombre         = $request->cliente_ncomercial;
      $direccion      = $request->cliente_direccion;
      $referencia     = $request->cliente_referencia;
      $ubigeo         = $request->cliente_id_ubigeo;
      $fecha_ingreso  = $request->cliente_ingreso;
      $moneda         = $request->cliente_moneda;
      $flag_activo    = $request->cliente_estado;
      $tipo_cliente   = $request->tipo_cliente;
      $actividad      = $request->cliente_actividad;
      $user_creacion  = Auth::user()->id;

      $contactos      = $request->contactos;

      $localidad      = '';

      if(!empty($ubigeo)){

          $full_ubigeo  = $request->cliente_ubigeo;

          $ubigeo_array = explode(" ", $full_ubigeo);

          $localidad = $ubigeo_array[0];

      }


      
      

      $id_consorcio = $request->cliente_id_consorcio;

      $asociados = $request->empresas;

      


      if($id_cliente == 0){

        $rpta  = DB::select('call Cliente_Insert (?,?,?,?,?,?,?,?,?,?,?,?,?,?,@res)', array($identificacion,$tipo_cliente,$moneda,$fecha_ingreso,$actividad,$razon_social,$direccion,$nombre,$ubigeo,$flag_activo,$user_creacion,$tipo_documento,$referencia,$localidad));

        $results = DB::select('select @res as res');

        $rpta_last_id = json_decode(json_encode($results), true);

        $last_id = $rpta_last_id[0]["res"];

        if(!is_null($last_id)){

            $rpta  = 1 ;

        }else{

          $rpta  = 0 ;
          
        }

        $new_id = $last_id;


      }else{

        $rpta  = DB::update('call Cliente_Update (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array($identificacion,$tipo_cliente,$moneda,$actividad,$razon_social,$direccion,$nombre,$ubigeo,$tipo_documento,$referencia,$flag_activo,$user_creacion,$id_cliente,$localidad));

        $new_id = $id_cliente;

      }


      if($contactos!="[]"){

        
        DB::delete('call Cliente_Contacto_Delete (?)', array($new_id));

        $subquery= self::set_insert_masivo_contactos($contactos,$new_id);

        DB::insert('call Cliente_Contacto_InsertMasivo (?)', array($subquery));

      }


      if($tipo_cliente=="05"){

        if(!empty($id_consorcio)){

          self::delete_empresas_consorcio($id_consorcio);
          
        }

        self::inserta_nuevas_empresas_consorcio($new_id,$asociados);
      }

      return $rpta ;


   }

   protected static function delete_empresas_consorcio($id_consorcio){

    $rpta = DB::delete('call Consorcio_Delete (?)', array($id_consorcio));

    return $rpta;

   }


   protected static function inserta_nuevas_empresas_consorcio($id_cliente,$asociados){

      $clientes_asoc = array();

      $porcentajes_asoc = array();

      
      $asociados =json_decode($asociados,true);

     
      foreach ($asociados as $value) {
        
        $clientes_asoc[] = $value['id_cliente'];

        $porcentajes_asoc[] = (!empty($value['porcentaje']))?$value['porcentaje']:0;

      }

    $clientes = implode(",",$clientes_asoc);

    $porcentajes = implode(",",$porcentajes_asoc);

    $clientes = "[".$clientes."]";

    $porcentajes = "[".$porcentajes."]";

    $rpta = DB::insert('call Consorcio_Insert (?,?,?)', array($id_cliente,$clientes,$porcentajes));

    return $rpta;
    
   }

    protected static function salvar_representante($request){


      $id_representante_cliente = $request->id_representante_cliente;

      $nombres   = $request->nombres;
      $apepat    = $request->apepat;
      $apemat    = $request->apemat;
      $fe_inicio = Carbon::parse($request->fe_inicio)->format('Y-m-d H:m:s');
      $fe_fin    = Carbon::parse($request->fe_fin)->format('Y-m-d H:m:s');
      $cargo     = $request->cargo;

      $id_cliente = $request->id_cliente;

      $fe_nacimiento = Carbon::parse($request->fe_nacimiento)->format('Y-m-d');

      $dni = $request->dni;


      if($id_representante_cliente == 0){

        $rpta  = DB::insert('call Cliente_Representante_Insert (?,?,?,?,?,?,?,?,?)', array($id_cliente,$nombres,$apepat,$apemat,$fe_inicio,$fe_fin,$cargo,$fe_nacimiento,$dni));

      }else{

        $rpta  = DB::update('call Cliente_Representante_Update (?,?,?,?,?,?,?,?,?,?)', array($id_cliente,$id_representante_cliente,$nombres,$apepat,$apemat,$fe_inicio,$fe_fin,$cargo,$fe_nacimiento,$dni));
      }
      

      return $rpta;
    
   }


   protected static function salvar_accionista($request){


      $id_accionista_cliente = $request->id_accionista_cliente;

      $nombres    = $request->nombres;
      $apepat     = (empty($request->apepat))?'':$request->apepat;
      $apemat     = (empty($request->apemat))?'':$request->apemat;
      $dni        = $request->dni;
      $porcentaje = (empty($request->porcentaje))?0:$request->porcentaje;
      $cargo      = $request->cargo;

      $id_cliente = $request->id_cliente;

      if($id_accionista_cliente == 0){

        $rpta  = DB::insert('call Cliente_Accionista_Insert (?,?,?,?,?,?,?)', array($id_cliente,$dni,$nombres,$apepat,$apemat,$cargo,$porcentaje));

      }else{

        $rpta  = DB::update('call Cliente_Accionista_Update (?,?,?,?,?,?,?,?)', array($id_cliente,$dni,$nombres,$apepat,$apemat,$cargo,$porcentaje,$id_accionista_cliente));
      }
      

      return $rpta;
    
   }

   protected static function load_file_cliente_documento($request){

      

      if ($request->file('file')) {

            $dir      = 'files_documentos_cliente/';
            $ext      = strtolower($request->file('file')->getClientOriginalExtension()); 
            $fileName = str_random() . '.' . $ext;
            $request->file('file')->move($dir, $fileName);
            $file     = $fileName;
        }
       

        $id_cliente_documento   = $request->IdClienteDocumento_documento;
        $id_cliente  = $request->IdCliente_documento;
        $valor       = $request->Valor_documento;
        $descripcion = $request->Descripcion_documento;
        $id_user       = Auth::user()->id;


      
        if($id_cliente_documento=="null"){

          $rpta  = DB::insert('call Cliente_Documento_Insert (?,?,?,?,?)', array($id_cliente,$valor,$descripcion,$file,$id_user));

        }else{

          self::elimina_antiguo_documento($id_cliente_documento);

          $rpta  = DB::update('call Cliente_Documento_Update (?,?,?)', array($file,$id_user,$id_cliente_documento));
        }
       
        return $rpta;

   }

   protected static function elimina_antiguo_documento($id_cliente_documento){

    $query  = DB::select('SELECT Valor FROM cliente_documento WHERE IdClienteDocumento=?', array($id_cliente_documento));

    $query_json  = json_decode(json_encode($query),true);

    $old_valor = $query_json[0]['Valor'];

    if(!is_null($old_valor)){

        $file_path = public_path().'/files_documentos_cliente/'.$old_valor;

        if (file_exists($file_path)) {

            unlink($file_path);

          }

    }


   }


   protected static function elimina_documento_cliente($request){

    $file_path = public_path().'/files_documentos_cliente/'.$request->file;
        

        if (file_exists($file_path)) {

            unlink($file_path);

            $id_user = Auth::user()->id;

            $rpta = DB::update("call Cliente_Documento_Delete (?,?)", array($request->IdClienteDocumento,$id_user));

            $description=($rpta==0)?'Ocurrió un error':'Se eliminó correctamente';

            return array("status"=>$rpta,"description"=>$description);

                

        } else {
                
            return array("status"=>0,"description"=>"El archivo no se encuentra o ya fue eliminado");;
                
        }
   }
}

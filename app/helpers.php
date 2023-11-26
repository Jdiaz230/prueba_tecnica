<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Home;

function User()
{
	return Auth::user();
}

function breadcrumb($url)
{
	if(!empty($url)){
		$url = explode('/', $url);
		$url = $url[0];
		$select = DB::connection('soporte')->table('menu')->where('url', '=', $url)->limit(1)->get();
		$respuesta = '<li class="breadcrumb-item"><a href="'.route('home').'">Home</a></li>';
		//dd($select[0]);
		if (count($select) > 0) {
			if($select[0]->nivel == 1){
				$select1 = DB::connection('soporte')->table('menu')->where('id', '=', $select[0]->submenu)->limit(1)->get();
				//dd($select1[0]);
				if (count($select1) > 0) {
					$respuesta .= '<li class="breadcrumb-item">'.$select1[0]->nombre.'</li>';
					$respuesta .= '<li class="breadcrumb-item"><a href="'.route($select[0]->url).'">'.$select[0]->nombre.'</a></li>';
				}else{
					$respuesta .= '<li class="breadcrumb-item"><a href="'.route($select[0]->url).'">'.$select[0]->nombre.'</a></li>';
					return $respuesta;
				}
			}else{
				$respuesta .= '<li class="breadcrumb-item active"><a href="'.route($select[0]->url).'">'.$select[0]->nombre.'</a></li>';
			}
			return $respuesta;
		}else{
			return $respuesta;
		}
	}else{
		return '';
	}
}

function menu()
{
	$select = DB::connection('soporte')->table('menu')->where('submenu', '=', 0)->orderBy('orden', 'asc')->get();
	// printer($select, 1);
	if (count($select) > 0) {
		return $select;
	}else{
		return 0;
    }
}

function ButtonFullscreen($ruta)
{
	return '<div class="text-center">
				<button type="button" class="btn btn-outline-default btn-sm " onclick="Fullscreen(\'' . $ruta . '\')" data-toggle="tooltip" title="VISTA PREVIA DEL REGISTRO" >
					<i class="fad fa-eye"></i>
				</button>
			</div>';
}

function submenu($id, $nivel)
{
	$select = DB::connection('soporte')->table('menu')->where([['submenu', '=', $id], ['nivel', '=', $nivel]])->orderBy('orden', 'asc')->get();
	if (count($select) > 0) {
		return $select;
	}else{
		return 0;
    }
}

function GetEstadoByAccion($accion)
{
	$select = DB::connection('soporte')->table('estados')->where(['accion' => $accion])->first();
	if (isset($select->id)) {
		return $select->id;
	}else{
		return false;
    }
}

function tecnicoTicket($user_id)
{
	$select = DB::connection('soporte')->table('usuarios')->where(['user_id' => $user_id])->first();
	if (isset($select->id)) {
		return $select->id;
	}else{
		return false;
    }
}

function tecnicoTicketRol($user_id)
{
	$select = DB::connection('soporte')->table('usuarios')->where(['user_id' => $user_id])->first();
	if (isset($select->id)) {
		return $select->rol_id;
	}else{
		return false;
    }
}

function Imagen($imagen)
{
	if(empty($imagen)){
		return asset('asset/lte3/dist/img/user.png');
	}else{
    	return 'data:image/png;base64, '.base64_encode($imagen);
	}
}

function mensaje($string, $tipo)
{
	return '<div class="alert alert-'.$tipo.' alert-dismissible" style="width: 100%">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				'.$string.'
			</div>
			<br>';
}




function ButtonEdit($ruta, $permiso = 2){
	if($permiso > 1){
		return '<div class="text-center">
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="Edit(\''.$ruta.'\')" data-toggle="tooltip" title="EDITAR REGISTRO" >
						<i class="fad fa-edit"></i>
					</button>
				</div>';
	}
	return '';
}

function ButtonDelete($ruta, $permiso = 2, $response='response'){
	if($permiso > 1){
		return '<div class="text-center">
					<button type="button" class="btn btn-outline-danger btn-sm" onclick="Delete(\''.$ruta.'\',\''.$response.'\')" data-toggle="tooltip" title="ELIMINAR REGISTRO" >
						<i class="fad fa-trash"></i>
					</button>
				</div>';
	}
	return '';
}

function ButtonPreview($ruta){
	return '<div class="text-center">
				<button type="button" class="btn btn-outline-default btn-sm" onclick="Preview(\''.$ruta.'\')" data-toggle="tooltip" title="VISTA PREVIA DEL REGISTRO" >
					<i class="fad fa-eye"></i>
				</button>
			</div>';
}

function printer($code, $continue = false)
{
	echo'<pre>';
	print_r($code);
	echo'</pre>';
	if(!$continue){	exit(); }
}

// function sendMail($asunto, $to, $data, $view = 'email.index', $adjunto = null)
// {
// 	$newto = array();
// 	if(is_array($to)){
// 		foreach ($to as $key => $value) {
// 			if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
// 				$newto[] = array('email' => $value, 'name' => $value);
// 			}
// 		}
// 	}else{
// 		if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
// 			$newto[] = array('email' => $to, 'name' => $to);
// 		}
// 	}
// 	$view = View($view, compact('asunto', 'data'))->render();
// 	$to   = $newto;
// 	$attachment = null;
// 	if(!is_null($adjunto)){
// 		$attachment = $adjunto;
// 	}
// 	//dd($view);
// 	//dd($to);
// 	return require_once ('laravel/apiV3sendinblue.php');
// }

function NameUser($id){
	$user = App\User::find($id);
	if($user){
		if(isset($user->nombre) AND !empty($user->nombre)){
			return $user->nombre;
		}else{
			$name = '';
			$user = (array) $user;
			if(isset($user['1_nombre_usu']) AND !empty($user['1_nombre_usu'])){
				$name .= $user['1_nombre_usu'];
			}
			if(isset($user['2_nombre_usu']) AND !empty($user['2_nombre_usu'])){
				$name .= ' '.$user['2_nombre_usu'];
			}
			if(isset($user['1_apellido_usu']) AND !empty($user['1_apellido_usu'])){
				$name .= ' '.$user['1_apellido_usu'];
			}
			if(isset($user['2_apellido_usu']) AND !empty($user['2_apellido_usu'])){
				$name .= ' '.$user['2_apellido_usu'];
			}
			return $name;
		}
	}else{
		return '';
	}
}

function accessByRol($url)
{
	$menu = DB::connection('soporte')->table('menu')->where(['url' => $url])->first();
	if($menu){
		$usuario				= User();
        $rol_id        			= tecnicoTicketRol($usuario->id);
        if(in_array($rol_id, explode(',', $menu->rol_id))) {
			return true;
		}
	}
	return false;
}

// function permisoRol($user_id)
// {
// 	if(is_numeric($user_id) && $user_id > 0) {
// 		$select = DB::connection('soporte')->select("SELECT r.* FROM usuarios u, roles r WHERE u.user_id = $user_id AND u.rol_id = r.id ");
// 		if (isset($select[0]->id)) {
// 			return (int)$select[0]->permission_id;
// 		}
// 	}
// 	return 0;

// }

function createArrayByField($object, $field, $is_array = false)
{
    $array = array();
    if($object){
        foreach($object as $item){
            if($is_array){
                $array[$item->$field][] = $item;
            }else{
                $array[$item->$field] = $item;
            }
        }
    }
    return $array;
}



function validateDatetime($date, $format = 'Y-m-d H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validateTime($date, $format = 'H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function newFecha($fecha, $accion, $dias, $time){
	return date("Y-m-d", strtotime((string)$fecha.$accion.$dias." ".$time));
}

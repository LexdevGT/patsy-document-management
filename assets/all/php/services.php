
<?php
	session_start();
	date_default_timezone_set('America/Guatemala');
	require_once('connect.php');


	if(isset($_POST['option'])){
		$option = $_POST['option'];
	
		switch ($option) {
			case 'load_explorer':
				loadExplorerFunction();
				break;
			case 'manto_mapaprocesos-carga_inicial':
				mm_ci_Function();
				break;
			case 'load_folders':
				loadFoldersFunction();
				break;
			case 'delete_folder':
				mm_df_Function();
				break;
			case 'rename_folder':
			    renameFolderFunction();
			    break;
			case 'create_folder':
				createFolderFunction();
				break;
			case 'load_roles_list':
				mr_lrl_Function();
				break;
			case 'cambio_de_status':
		        mr_cds_Function(); 
		        break;
		    case 'crear_rol':
		        mr_cr_Function(); 
		        break;
		    case 'cargar_select_roles':
		        mp_csr_Function(); 
		        break;
		    case 'cargar_privilegios':
		    	mp_cp_Function();
		    	break;
		    case 'guardar_privilegios':
		    	mp_gp_Function();
		    	break;
		    case 'crear_region':
		        mregion_cr_Function(); 
		        break;
		    case 'load_region_list':
				mregion_lrl_Function();
				break;
			case 'cambio_de_status_region':
		        mregion_cds_Function(); 
		        break;
		    case 'crear_sucursal':
		        ms_cs_Function(); 
		        break;
		    case 'load_sucursal_list':
				ms_lsl_Function();
				break;
			case 'cambio_de_status_sucursal':
		        ms_cds_Function(); 
		        break;
		    case 'crear_tipo_docto':
		        mtdd_ctdd_Function(); 
		        break;
		    case 'load_tipo_docto_list':
				mtdd_ltdl_Function();
				break;
			case 'cambio_de_status_tipo_docto':
		        mtdd_cdstd_Function(); 
		        break;	
		    case 'cargar_select_region':
		        mu_csr_Function(); 
		        break;
		    case 'cargar_select_sucursal':
		        mu_css_Function(); 
		        break;
		    case 'crear_usuario':
		        mu_cu_Function(); 
		        break;
		    case 'load_user_list':
				mu_lul_Function();
				break;
			case 'cambio_de_status_usuario':
		        mu_cdsu_Function(); 
		        break;
		    case 'login':
		        i_li_Function(); 
		        break;
		}
	}

	function nueva(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		$query = "SELECT id_rol,nombre_rol FROM roles 
				  WHERE status_rol = 1;
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){

		}else{
			$error = 'Error cargando los roles de base de datos: '.$conn->error;
		}

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function i_li_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if (isset($_POST['email']) && isset($_POST['contra'])) {
	    	$email = $_POST['email'];
	    	$pass  = $_POST['contra'];

	    	$query = "SELECT email,password,nombre,apellido,rol_id 
					FROM users
					WHERE email = '$email'
					AND MD5('$pass')
					AND status = 1";

			// Ejecuta la consulta y verifica si se ejecutó correctamente
	    	$execute_query = $conn->query($query);

	    	if ($execute_query->num_rows > 0) {
		        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
		        $rows = array();
		        while ($row = $execute_query->fetch_array()) {
		            
		            $nombre 	= $row['nombre'];
		            $apellido 	= $row['apellido'];
		            $rol_id 	= $row['rol_id'];

		            $_SESSION['nombre_u'] 	= $nombre . ' ' . $apellido;
		            $_SESSION['rol_id'] 	= $rol_id; 
		            
		            // Agrega los resultados al arreglo $rows
		            $data_rows[] = array(
		                'nombre' 	=> $nombre,
		                'apellido'	=> $apellido
		            );
		        }

		        // Agrega los resultados al arreglo jsondata
		        $jsondata['data'] = $data_rows;
		        $message = 'Consulta ejecutada con éxito.';
		    } else {
		        // La consulta falló, establece un mensaje de error
		        $error = 'Usuario o contraseña incorrecto';
		    }
	    }else{
	    	$error = "Contraseña o correo no fueron ingresados correctamente!";
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function mu_cdsu_Function() {
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if (isset($_POST['id']) && isset($_POST['nuevo_estado'])) {
	        $id = $_POST['id'];
	        $nuevo_estado = $_POST['nuevo_estado'];

	        // Realiza la actualización en la base de datos
	        $query = "UPDATE users SET status = '$nuevo_estado' WHERE id = '$id'";
	        //error_log($query);
	        $execute_query = $conn->query($query);

	        if ($execute_query) {
	            $message = 'Estado actualizado correctamente en la base de datos.';
	        } else {
	            $error = 'Error al actualizar el estado en la base de datos: ' . $conn->error;
	        }
	    } else {
	        $error = 'Falta información requerida para realizar la actualización de estado.';
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function mu_lul_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    $query = "SELECT id, nombre, apellido, email, status FROM users";

	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	            $id 		= $row['id'];
	            $nombre 	= $row['nombre'];
	            $apellido 	= $row['apellido'];
	            $email 		= $row['email'];
	            $status 	= $row['status'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	                'id' 		=> $id,
	                'nombre' 	=> $nombre,
	                'apellido'	=> $apellido,
	                'email'		=> $email,
	                'status' => $status
	            );
	        }

	        // Agrega los resultados al arreglo jsondata
	        $jsondata['data'] = $data_rows;
	        $message = 'Consulta ejecutada con éxito.';
	    } else {
	        // La consulta falló, establece un mensaje de error
	        $error = 'Error al ejecutar la consulta: ' . $conn->error;
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function mu_cu_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		if (isset($_POST['nombre']) && isset($_POST['apellido'])){
			$nombre 	= $_POST['nombre'];
			$apellido 	= $_POST['apellido'];
			$email 		= $_POST['email'];
			$foto 		= $_POST['foto'];
			$region 	= $_POST['region'];
			$sucursal 	= $_POST['sucursal'];
			$rol 		= $_POST['rol'];
			$status 	= $_POST['status'];
			$pass1 		= $_POST['pass1'];
			$pass2 		= $_POST['pass2'];
			$firma 		= $_POST['firma'];

			if($pass1 == $pass2){
				$query = "INSERT INTO users (nombre,apellido,email,foto,region_id,sucursal_id,rol_id,status,password,firma) VALUES ('$nombre','$apellido','$email','$foto',$region,$sucursal,$rol,$status,md5('$pass1'),'$firma')";
				$execute_query = $conn->query($query);

				if ($execute_query) {
		            $message = 'Usuario agregado correctamente en la base de datos.';
		        } else {
		            $error = 'Error al crear el usuario en la base de datos: ' . $conn->error;
		        }
			}else{
				$error = 'Las contraseñas no coinciden.';
			}

		}else {
	        $error = 'Falta información requerida para la creación del usuario.';
	    }

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function mu_css_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';
		$html 	  = '';

		$query = "SELECT id,nombre FROM sucursal 
				  WHERE status = 1;
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			$html .= "<option value='0'>Selecciona una sucursal...</option>";
			while($row = $execute_query->fetch_array()){
				$id 	= $row['id'];
				$nombre = $row['nombre'];
				$html .= "<option value='$id'>$nombre</option>";	
			}
			
		}else{
			$error = 'Error cargando las sucursales de base de datos: '.$conn->error;
		}

		$jsondata['html'] 		= $html;
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function mu_csr_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';
		$html 	  = '';

		$query = "SELECT id_region,nombre_region FROM region 
				  WHERE status_region = 1;
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			$html .= "<option value='0'>Selecciona una región...</option>";
			while($row = $execute_query->fetch_array()){
				$id 	= $row['id_region'];
				$nombre = $row['nombre_region'];
				$html .= "<option value='$id'>$nombre</option>";	
			}
			
		}else{
			$error = 'Error cargando las regiones de base de datos: '.$conn->error;
		}

		$jsondata['html'] 		= $html;
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function mtdd_cdstd_Function() {
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if (isset($_POST['id']) && isset($_POST['nuevo_estado'])) {
	        $id = $_POST['id'];
	        $nuevo_estado = $_POST['nuevo_estado'];

	        // Realiza la actualización en la base de datos
	        $query = "UPDATE tipo_de_documentos SET status = '$nuevo_estado' WHERE id = '$id'";
	        //error_log($query);
	        $execute_query = $conn->query($query);

	        if ($execute_query) {
	            $message = 'Estado actualizado correctamente en la base de datos.';
	        } else {
	            $error = 'Error al actualizar el estado en la base de datos: ' . $conn->error;
	        }
	    } else {
	        $error = 'Falta información requerida para realizar la actualización de estado.';
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function mtdd_ltdl_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    $query = "SELECT id, tipo_de_documento, status FROM tipo_de_documentos";

	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	            $id = $row['id'];
	            $nombre = $row['tipo_de_documento'];
	            $status = $row['status'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	                'id' => $id,
	                'nombre' => $nombre,
	                'status' => $status
	            );
	        }

	        // Agrega los resultados al arreglo jsondata
	        $jsondata['data'] = $data_rows;
	        $message = 'Consulta ejecutada con éxito.';
	    } else {
	        // La consulta falló, establece un mensaje de error
	        $error = 'Error al ejecutar la consulta: ' . $conn->error;
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function mtdd_ctdd_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		if (isset($_POST['nombre'])){
			$nombre = $_POST['nombre'];
			$query = "INSERT INTO tipo_de_documentos (tipo_de_documento,status) VALUES ('$nombre',1)";
			$execute_query = $conn->query($query);

			if ($execute_query) {
	            $message = 'Tipo de documento agregado correctamente en la base de datos.';
	        } else {
	            $error = 'Error crear el tipo de documento en la base de datos: ' . $conn->error;
	        }
		}else {
	        $error = 'Falta información requerida para la creación del tipo de documento.';
	    }

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function ms_cds_Function() {
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if (isset($_POST['id']) && isset($_POST['nuevo_estado'])) {
	        $id = $_POST['id'];
	        $nuevo_estado = $_POST['nuevo_estado'];

	        // Realiza la actualización en la base de datos
	        $query = "UPDATE sucursal SET status = '$nuevo_estado' WHERE id = '$id'";
	        //error_log($query);
	        $execute_query = $conn->query($query);

	        if ($execute_query) {
	            $message = 'Estado actualizado correctamente en la base de datos.';
	        } else {
	            $error = 'Error al actualizar el estado en la base de datos: ' . $conn->error;
	        }
	    } else {
	        $error = 'Falta información requerida para realizar la actualización de estado.';
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function ms_lsl_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    $query = "SELECT id, nombre, status FROM sucursal";

	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	            $id = $row['id'];
	            $nombre = $row['nombre'];
	            $status = $row['status'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	                'id' => $id,
	                'nombre' => $nombre,
	                'status' => $status
	            );
	        }

	        // Agrega los resultados al arreglo jsondata
	        $jsondata['data'] = $data_rows;
	        $message = 'Consulta ejecutada con éxito.';
	    } else {
	        // La consulta falló, establece un mensaje de error
	        $error = 'Error al ejecutar la consulta: ' . $conn->error;
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function ms_cs_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		if (isset($_POST['nombre'])){
			$nombre = $_POST['nombre'];
			$query = "INSERT INTO sucursal (nombre,status) VALUES ('$nombre',1)";
			$execute_query = $conn->query($query);

			if ($execute_query) {
	            $message = 'Sucursal agregada correctamente en la base de datos.';
	        } else {
	            $error = 'Error crear la sucursal en la base de datos: ' . $conn->error;
	        }
		}else {
	        $error = 'Falta información requerida para la creación de la sucursal.';
	    }

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function mregion_cds_Function() {
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if (isset($_POST['id']) && isset($_POST['nuevo_estado'])) {
	        $id = $_POST['id'];
	        $nuevo_estado = $_POST['nuevo_estado'];

	        // Realiza la actualización en la base de datos
	        $query = "UPDATE region SET status_region = '$nuevo_estado' WHERE id_region = '$id'";
	        //error_log($query);
	        $execute_query = $conn->query($query);

	        if ($execute_query) {
	            $message = 'Estado actualizado correctamente en la base de datos.';
	        } else {
	            $error = 'Error al actualizar el estado en la base de datos: ' . $conn->error;
	        }
	    } else {
	        $error = 'Falta información requerida para realizar la actualización de estado.';
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function mregion_lrl_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    $query = "SELECT id_region AS id, nombre_region AS nombre, status_region AS status FROM region";

	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	            $id = $row['id'];
	            $nombre = $row['nombre'];
	            $status = $row['status'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	                'id' => $id,
	                'nombre' => $nombre,
	                'status' => $status
	            );
	        }

	        // Agrega los resultados al arreglo jsondata
	        $jsondata['data'] = $data_rows;
	        $message = 'Consulta ejecutada con éxito.';
	    } else {
	        // La consulta falló, establece un mensaje de error
	        $error = 'Error al ejecutar la consulta: ' . $conn->error;
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function mregion_cr_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		if (isset($_POST['nombre_region'])){
			$nombre_region = $_POST['nombre_region'];
			$query = "INSERT INTO region (nombre_region,status_region) VALUES ('$nombre_region',1)";
			$execute_query = $conn->query($query);

			if ($execute_query) {
	            $message = 'Región agregado correctamente en la base de datos.';
	        } else {
	            $error = 'Error crear el rol en la base de datos: ' . $conn->error;
	        }
		}else {
	        $error = 'Falta información requerida para la creación del rol.';
	    }

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function mp_gp_Function() {
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if (isset($_POST['rol_id']) && isset($_POST['privilegios'])) {
	        $rol_id = $_POST['rol_id'];
	        $privilegios = $_POST['privilegios']; // Array de ID de privilegios seleccionados

	        // Elimina todos los registros existentes para el rol dado
	        $delete_query = "DELETE FROM privilegios WHERE id_rol = '$rol_id'";
	        $conn->query($delete_query);

	        // Inserta los nuevos registros en la tabla privilegios
	        foreach ($privilegios as $privilegio_id) {
	            $insert_query = "INSERT INTO privilegios (id_privilegio, id_rol) VALUES ('$privilegio_id', '$rol_id')";
	            $conn->query($insert_query);
	        }

	        $message = 'Privilegios actualizados correctamente en la base de datos.';
	    } else {
	        $error = 'Falta información requerida para actualizar los privilegios.';
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}


	function mp_cp_Function(){
	    global $conn;
	    $jsondata 	= array();
	    $error 		= '';
	    $message 	= '';
	    $id_rol 	= $_POST['id_rol'];

	    $query = "
	    			SELECT 
					    op.id_opcion_privilegio,
					    op.nombre_opcion_privilegio,
					    op.path,
					    CASE WHEN p.id IS NOT NULL THEN 1 ELSE 0 END AS chequed
					FROM opciones_privilegios op
					LEFT JOIN privilegios p ON op.id_opcion_privilegio = p.id_privilegio
					    AND p.id_rol = $id_rol
					ORDER BY id_opcion_privilegio
				";
//error_log($query);
	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	            $id_privilege 	= $row['id_opcion_privilegio'];
	            $name_privilege = $row['nombre_opcion_privilegio'];
	            $path 			= $row['path'];
	            $chequed 		= $row['chequed'];

	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	                'id_privilegio' => $id_privilege,
	                'nombre_privilegio' => $name_privilege,
	                'path' => $path,
	                'chequed' => $chequed
	            );
	        }

	        // Agrega los resultados al arreglo jsondata
	        $jsondata['data'] = $data_rows;
	 
	        //error_log(print_r($data_rows,true));
	        $message = 'Consulta ejecutada con éxito.';
	    } else {
	        // La consulta falló, establece un mensaje de error
	        $error = 'Error al ejecutar la consulta: ' . $conn->error;
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;

	   //error_log(print_r($jsondata,true));
	    echo json_encode($jsondata);
	}

	function mp_csr_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';
		$html 	  = '';

		$query = "SELECT id_rol,nombre_rol FROM roles 
				  WHERE status_rol = 1;
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			$html .= "<option value='0'>Selecciona un rol...</option>";
			while($row = $execute_query->fetch_array()){
				$id 	= $row['id_rol'];
				$nombre = $row['nombre_rol'];
				$html .= "<option value='$id'>$nombre</option>";	
			}
			
		}else{
			$error = 'Error cargando los roles de base de datos: '.$conn->error;
		}

		$jsondata['html'] 		= $html;
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function mr_cr_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		if (isset($_POST['nombre_rol'])){
			$nombre_rol = $_POST['nombre_rol'];
			$query = "INSERT INTO roles (nombre_rol,status_rol) VALUES ('$nombre_rol',1)";
			$execute_query = $conn->query($query);

			if ($execute_query) {
	            $message = 'Rol agregado correctamente en la base de datos.';
	        } else {
	            $error = 'Error crear el rol en la base de datos: ' . $conn->error;
	        }
		}else {
	        $error = 'Falta información requerida para la creación del rol.';
	    }

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function mr_cds_Function() {
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if (isset($_POST['rol_id']) && isset($_POST['nuevo_estado'])) {
	        $rol_id = $_POST['rol_id'];
	        $nuevo_estado = $_POST['nuevo_estado'];

	        // Realiza la actualización en la base de datos
	        $query = "UPDATE roles SET status_rol = '$nuevo_estado' WHERE id_rol = '$rol_id'";
	        //error_log($query);
	        $execute_query = $conn->query($query);

	        if ($execute_query) {
	            $message = 'Estado actualizado correctamente en la base de datos.';
	        } else {
	            $error = 'Error al actualizar el estado en la base de datos: ' . $conn->error;
	        }
	    } else {
	        $error = 'Falta información requerida para realizar la actualización de estado.';
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}


	function mr_lrl_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    $query = "SELECT id_rol, nombre_rol, status_rol FROM roles";

	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	            $id_rol = $row['id_rol'];
	            $nombre_rol = $row['nombre_rol'];
	            $status_rol = $row['status_rol'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	                'id_rol' => $id_rol,
	                'nombre_rol' => $nombre_rol,
	                'status_rol' => $status_rol
	            );
	        }

	        // Agrega los resultados al arreglo jsondata
	        $jsondata['data'] = $data_rows;
	        $message = 'Consulta ejecutada con éxito.';
	    } else {
	        // La consulta falló, establece un mensaje de error
	        $error = 'Error al ejecutar la consulta: ' . $conn->error;
	    }

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}


	function createFolderFunction(){
		$jsondata 	= array();
		$error    	= '';
		$success  	= false;
		$newFolder 	= '';

		$dir_var    = isset($_POST['folderPath']) ? $_POST['folderPath'] : '';
		$folderName = isset($_POST['folderName']) ? $_POST['folderName'] : '';

		if (empty($folderName) || preg_match('/[\/:*?"<>|]/', $folderName)) {
			$error = 'Nombre de carpeta inválido.';
		} else {
			$folderPath = '../../../pages/documents/' . $dir_var;
			$newFolder  = $folderPath . '/' . $folderName;

			// Verificar si la carpeta ya existe
			if (!file_exists($newFolder)) {
				// Intentar crear la carpeta
				if (mkdir($newFolder, 0755)) { // Crea la carpeta con permisos de lectura y escritura
					$success = true;
				} else {
					$error = 'No se pudo crear la carpeta.';
				}
			} else {
				$error = 'Ya existe una carpeta con ese nombre en esta ubicación.';
			}
		}
		
//error_log("Ruta completa: $newFolder");
		if ($success) {
			$jsondata['message'] = 'Carpeta creada correctamente.';
			$jsondata['error']   = $error;
		} else {
			$jsondata['error'] = 'Error al crear la carpeta: ' . $error;
		}

		echo json_encode($jsondata);
	}

	function renameFolderFunction() {
		$jsondata = array();
		$error = '';
		$success = false;

		$dir_var = isset($_POST['folderPath']) ? $_POST['folderPath'] : '';
		$newFolderName = isset($_POST['newFolderName']) ? $_POST['newFolderName'] : '';

		if ($dir_var == '' || $newFolderName == '') {
		    $error = 'Ruta de carpeta o nuevo nombre de carpeta inválido.';
		} else {
		    $folderPath = '../../../pages/documents/' . $dir_var;
		    $newPath = dirname($folderPath) . '/' . $newFolderName;

		    if (rename($folderPath, $newPath)) {
		        $success = true;
		    } else {
		        $error = 'No se pudo cambiar el nombre de la carpeta.';
		    }
		}

		if ($success) {
		    $jsondata['message'] 	= 'Nombre de carpeta modificado correctamente.';
		    $jsondata['error'] 		= $error;
		} else {
		    $jsondata['error'] = 'Error al modificar el nombre de la carpeta: ' . $error;
		}

		echo json_encode($jsondata);
	}


	function mm_df_Function() {
		$jsondata = array();
		$error = '';
		$success = false;
		$dir_var = isset($_POST['folderPath']) ? $_POST['folderPath'] : '';

		if ($dir_var == '') {
			$folderPath = '../../../pages/documents/';
		} else {
			$folderPath = '../../../pages/documents/' . $dir_var;
		}

		if (is_dir($folderPath)) {
			// Verificar si la carpeta está vacía antes de intentar eliminarla
			if (isEmptyDirectory($folderPath)) {
				try {
					if (rmdir($folderPath)) {
						$success = true;
					}
				} catch (Exception $e) {
					$error = 'No se pudo eliminar la carpeta.';
				}
			} else {
				$error = 'La carpeta no está vacía. No se puede eliminar.';
			}
		} else {
			$error = 'No es una carpeta válida.';
		}

		if ($success) {
			$jsondata['message'] 	= 'Carpeta eliminada correctamente.';
			$jsondata['error'] 		= $error;
		} else {
			$jsondata['error'] = 'Error al eliminar la carpeta: ' . $error;
		}

		echo json_encode($jsondata);
	}

	function isEmptyDirectory($folderPath) {
		$contents = scandir($folderPath);
		return count($contents) <= 2; // Contará . y ..
	}


	function loadExplorerFunction() {
		$jsondata 	= array();
		$error 		= '';
		$html 		= '';
		$folder_count = '';

		$dir_var = isset($_POST['directory']) ? $_POST['directory'] : '';

		if ($dir_var == '') {
			$dir = '../../../pages/documents/';
		} else {
			$dir = '../../../pages/documents/' . $dir_var;
		}

		$folders = scandir($dir);

		foreach ($folders as $folder) {
			if ($folder !== '.' && $folder !== '..' && is_dir($dir . $folder)) {
				$folder_count++;
				$subfolderPath = $dir_var . $folder . '/';
				$html .= '<div class="folder-card">';
				$html .= '<a href="#" class="list-group-item list-group-item-action manto_mapaprocesos_li" data-path="' . $subfolderPath . '">' . $folder . '</a>';
				$html .= '<div class="action-buttons">';
				$html .= '<button class="btn btn-sm btn-danger delete-folder" data-folder="' . $subfolderPath . '"><i class="fas fa-trash"></i></button>';
				$html .= '<button class="btn btn-sm btn-primary edit-folder" data-folder="' . $subfolderPath . '"><i class="fas fa-edit"></i></button>';
				$html .= '</div>';
				$html .= '</div>';
			}
		}

	  //error_log('Contador: '.$folder_count);
		if ($folder_count<1) {
			$html = "<h3 class='mt-5'>No existen carpetas en esta ubicación!</h3>";
		}

		$jsondata['html'] = $html;
		$jsondata['error'] = $error;
		echo json_encode($jsondata);
	}

	function mm_ci_Function(){
		global $conn;
		$jsondata 	= array();
		$error 	  	= '';
		$html 		= '';

		$initialFolderPath = '../../../pages/documents/'; // Ruta inicial de las carpetas
		$folders = scandir($initialFolderPath);

		foreach ($folders as $folder) {
			if ($folder !== '.' && $folder !== '..' && is_dir($initialFolderPath . $folder)) {
				$subfolderPath = $folder . '/';
				$html .= '<div class="folder-card">';
				$html .= '<a href="#" class="list-group-item list-group-item-action manto_mapaprocesos_li" data-path="' . $subfolderPath . '">' . $folder . '</a>';
				$html .= '<div class="action-buttons">';
				$html .= '<button class="btn btn-sm btn-danger delete-folder" data-folder="' . $subfolderPath . '"><i class="fas fa-trash"></i></button>';
				$html .= '<button class="btn btn-sm btn-primary edit-folder" data-folder="' . $subfolderPath . '"><i class="fas fa-edit"></i></button>';
				$html .= '</div>';
				$html .= '</div>';
			}
		}

		$jsondata['html'] 	= $html;
		$jsondata['error'] 	= $error;
		echo json_encode($jsondata);
	}

	
  
?>

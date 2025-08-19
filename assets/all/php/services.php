<?php
//error_log('Reconoce PHP');
	session_start();
	date_default_timezone_set('America/Guatemala');
	header('Content-Type: application/json; charset=ISO-8859-1');
	
	require_once('connect.php');
	require '../vendor/autoload.php';
	use setasign\Fpdi\Fpdi;
	use PhpOffice\PhpWord\IOFactory;
	use Mpdf\Mpdf;



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
		    case 'editar_tipo_docto':
		        mtdd_etd_Function(); 
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
		    case 'cargar_barra_izquierda':
		        coreJS_cbi_Function(); 
		        break;
		    case 'cargar_proceso_principal_select':
		        cd_cpps_Function(); 
		        break;
		    case 'cargar_select_tipo_de_documentos':
		        cd_cstdd_Function(); 
		        break;
		    case 'cargar_select_usuarios':
		        cd_csu_Function(); 
		        break;
		    case 'crear_documento':
		        cd_cd_Function(); 
		        break;
		    case 'cargar_lista_documentos':
		        r_cld_Function(); 
		        break;
		    case 'cargar_informacion_basica_documento':
		        r_cibd_Function(); 
		        break;
		    case 'cargar_informacion_footer_documento':
		        r_cifd_Function(); 
		        break;
		    case 'cargar_documento_word':
		    	r_cdw_Function();
		    	break;
		   	case 'guardar_comentario_rechazo':
		    	r_gcr_Function();
		    	break;
		    case 'cambio_estatus_documento':
		    	r_ced_Function();
		    	break;
		    case 'cargar_estatus_documentos':
		    	sd_ced_Function();
		    	break;
		    case 'cargar_document_name':
		    	sddi_cdn_Function();
		    	break;
		    case 'buscar_documentos_por_keyword':
		    	sddi_bdpk_Function();
		    	break;
		    case 'history':
		    	sddi_h_Function();
		    	break;
		    case 'cambiar_estatus_documento':
		    	sddi_ced_Function();
		    	break;
		    case 'cargar_lista_control_cambios':
		    	cdc_clcc_Function();
		    	break;
		    case 'cargar_procesos_obsoletos':
		    	o_cpo_Function();
		    	break;
		    case 'load_folders_obsoletos':
		    	o_lfo_Function();
		    	break;
		    case 'obtener_datos':
		    	mu_od_Function();
		    	break;
		    case 'datos_select':
		    	mu_ds_Function();
		    	break;
		    case 'modificar_usuario':
		    	mu_mu_Function();
		    	break;
		    case 'procesar_documento':
		    	r_pd_Function();
		    	break;
	    	case 'cargar_lista_reporte':
		    	r_clr_Function();
		    	break;
		    case 'obtener_conteo_documentos_aprobados':
		    	d_ocda_Function();
		    	break;
		    case 'documentos_creados_por_dia':
		    	d_dcpd_Function();
		    	break;
		    case 'documentos_revisados_por_dia':
		    	d_drpd_Function();
		    	break;
		    case 'getLineChartData':
			    d_glcd_Function();
			    break;
			case 'get_nombre_region':
				mr_gnr_Function();
				break;
			case 'update_region':
				mr_ur_Function();
				break;
			case 'cargar_select_pendientes':
				cd_csp_Function();
				break;
			case 'revisar_obtener_path_documento':
				r_dd_function();
				break;
			case 'obtener_info_pendientes':
				cd_oip_function();
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

	function cd_oip_function(){
		global $conn;
		$jsondata  = array();
		$error 	   = '';
		$message   = '';
		$html 	   = '';
		$data_rows = array();


		// Este query lista todos los documentos en estado de "En Documentación"
		$query = "SELECT quien_visualiza,quien_imprime 
					FROM documentos d 
					WHERE id = $id;
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			
			while($row = $execute_query->fetch_array()){
				$visualizan	= $row['quien_visualiza'];
				$imprimen = $row['quien_imprime'];
				$data_rows[] = array(
					'visualizan' => $visualizan,
					'imprimen' => $imprimen
				);
			}
	error_log(print_r($data_rows,true));
			/*
			$query_select = "SELECT nombre, apellido
				FROM users u 
				WHERE u.id IN ($data_rows['visualizan'])
				UNION 
				SELECT nombre, apellido
				FROM users u 
				WHERE u.id NOT IN ($data_rows['imprimen']);
				 ";
			
			$execute_query = $conn->query($query_select);
			if($execute_query){
				//$html .= "<option value='0'>Selecciona un usuario...</option>";
				while($row = $execute_query->fetch_array()){
					$id 	= $row['id'];
					$nombre = $row['nombre'] . ' ' . $row['apellido'];
					//$html .= "<option value='$id'>$nombre</option>";	
					$data_rows[] = array(
						'id' => $id,
						'nombre' => $nombre
					);
				}
				
			}else{
				$error = 'Error cargando los usuarios de base de datos: '.$conn->error;
			}
			*/
		}else{
			$error = 'Error cargando los documentos pendientes de base de datos: '.$conn->error;
		}


		$jsondata['html'] 		= $data_rows;
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function r_dd_function() {
		//http://localhost/Patsy-DM/pages/newdocuments/Test%20de%20descarga%20%232.docx
		//http://localhost/Patsy-DM/pages/newdocuments/Test%20de%20descarga%20
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if (isset($_POST['id'])) {
	        $id = $_POST['id'];
	        $call_document_path = "
	            SELECT path_documento
	            FROM documentos
	            WHERE id = $id
	        ";
	        $query_execute = $conn->query($call_document_path);
	        $result = $query_execute->fetch_array();
	        $path = $result['path_documento'];

	    //error_log("PATH: $path");

	        // Obtener la URL base del servidor
	        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	        $host = $_SERVER['HTTP_HOST'];
	        $path = trim($path, '/'); // Elimina cualquier barra inclinada al principio o al final
	    //error_log("TRIm PATH: $path");
	    //error_log("HOST: $host");
	        // Construir la URL completa del archivo
	        $full_url = $protocol . $host . '/' . $path;
	     //error_log("FULL URL: $full_url");
	        // Obtener la información de la ruta
	        $info = pathinfo($full_url);
	        $filename = $info['basename'];

        //error_log("INFO: ".print_r($info, true));
        //error_log("FILENAME: $filename");
        //error_log("SERVER CHECK: ".$_SERVER['DOCUMENT_ROOT'] . '/' . $path );
	       // if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $path)) {

	            //$jsondata['path'] = $full_url;
        		$jsondata['path'] = $path;
	            $jsondata['filename'] = $filename;
	        //} else {
	            //$error = 'El archivo no existe.';
	        //}
	    } else {
	        $error = 'No se proporcionó un ID válido.';
	    }

	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function cd_csp_Function(){
		global $conn;
		$jsondata  = array();
		$error 	   = '';
		$message   = '';
		$html 	   = '';
		$data_rows = array();

		// Este query lista todos los documentos en estado de "En Documentación"
		$query = "SELECT id, nombre, codigo 
					FROM documentos d 
					WHERE status = 13;
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			
			while($row = $execute_query->fetch_array()){
				$id 	= $row['id'];
				$nombre = $row['nombre'];
				$codigo = $row['codigo'];	
				$data_rows[] = array(
					'id' => $id,
					'nombre' => $nombre,
					'codigo' => $codigo
				);
			}
			
		}else{
			$error = 'Error cargando los documentos pendientes de base de datos: '.$conn->error;
		}

		$jsondata['html'] 		= $data_rows;
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function mr_ur_Function(){
		global $conn;
		$jsondata 		 = array();
		$error 	  		 = '';
		$message  		 = '';
		$id 			 = $_POST['id'];
		$name 			 = $_POST['n'];

		$query = "
				UPDATE region
				SET nombre_region = '$name'
				WHERE id_region = $id
				 ";

		//error_log($query);
		
		$execute_query = $conn->query($query);

		if($execute_query){
			$message = 'Documento procesado correctamente!';
		}else{
			$error = 'Error en la base de datos urgente revisar: '.$conn->error;
		}

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function mr_gnr_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';
	    $id = $_POST['id'];

	    $query = "SELECT id_region AS id, nombre_region AS nombre, status_region AS status 
	    	FROM region
	    	WHERE id_region = $id
	    	";
//error_log("QUERY: $query");
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

	function d_glcd_Function() {
		// Grafica de solicitud de documentos nuevos por día
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    $query = "SELECT DATE_FORMAT(fecha, '%W, %M %e, %Y') AS fecha_formateada, cantidad
	              FROM (
						SELECT fecha, count(*) cantidad
						FROM documentos
						WHERE status NOT IN( 11)
						GROUP BY fecha
						ORDER BY fecha DESC
						
						LIMIT 6
					) a";

	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        $fechas = array();
	        $cantidades = array();

	        while ($row = $execute_query->fetch_assoc()) {
	            $fechas[] = $row['fecha_formateada'];
	            $cantidades[] = $row['cantidad'];
	        }

	        $data = array(
	            'labels' => $fechas,
	            'datasets' => array(
	                array(
	                    'label' => 'Documentos Creados por Día',
	                    'borderColor' => 'rgba(60,141,188,0.8)',
	                    'pointRadius' => false,
	                    'pointColor' => '#3b8bba',
	                    'pointStrokeColor' => 'rgba(60,141,188,1)',
	                    'pointHighlightFill' => '#fff',
	                    'pointHighlightStroke' => 'rgba(60,141,188,1)',
	                    'data' => $cantidades
	                )
	            )
	        );

	        $jsondata['data'] = $data;
	        $message = 'Consulta ejecutada con éxito.';
	    } else {
	        $error = 'Error al ejecutar la consulta: ' . $conn->error;
	    }

	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}


	function d_drpd_Function() {
		// DOCUMENTOS REVISADOS POR DIA
	 
	    global $conn;

	    $jsondata = array();
	    $error = '';
	    $message = '';

	    $query = "SELECT DATE_FORMAT(date_time, '%W, %M %e, %Y') AS fecha_formateada, COUNT(*) AS cantidad
	              FROM history
	              WHERE status = 9
	              GROUP BY fecha_formateada
	              ORDER BY fecha_formateada DESC
	              LIMIT 6
	              ";

	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        $fechas = array();
	        $cantidades = array();

	        while ($row = $execute_query->fetch_assoc()) {
	            $fechas[] = $row['fecha_formateada'];
	            $cantidades[] = $row['cantidad'];
	        }

	        $data = array(
	            'labels' => $fechas,
	            'datasets' => array(
	                array(
	                    'label' => 'Documentos Revisados',
	                    'backgroundColor' => 'rgba(60,141,188,0.9)',
	                    'borderColor' => 'rgba(60,141,188,0.8)',
	                    'pointRadius' => false,
	                    'pointColor' => '#3b8bba',
	                    'pointStrokeColor' => 'rgba(60,141,188,1)',
	                    'pointHighlightFill' => '#fff',
	                    'pointHighlightStroke' => 'rgba(60,141,188,1)',
	                    'data' => $cantidades
	                )
	            )
	        );

	        $jsondata['data'] = $data;
	        $message = 'Consulta ejecutada con éxito.';
	    } else {
	        $error = 'Error al ejecutar la consulta: ' . $conn->error;
	    }

	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function d_dcpd_Function() {
		//Documentos creados por dia
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    $query = "
	    	SELECT DATE_FORMAT(fecha, '%W, %M %e, %Y') AS fecha_formateada, cantidad
              FROM (
					SELECT fecha, count(*) cantidad
					FROM documentos
					WHERE status = 11
					GROUP BY fecha
					ORDER BY fecha DESC
					LIMIT 6
					) a";

	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        $fechas = array();
	        $cantidades = array();

	        while ($row = $execute_query->fetch_assoc()) {
	            $fechas[] = $row['fecha_formateada'];
	            $cantidades[] = $row['cantidad'];
	        }

	        $data = array(
	            'fechas' => $fechas,
	            'cantidades' => $cantidades
	        );

	        $jsondata['data'] = $data;
	        $message = 'Consulta ejecutada con éxito.';
	    } else {
	        $error = 'Error al ejecutar la consulta: ' . $conn->error;
	    }

	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}


	function d_ocda_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		$query = "SELECT count(*) AS c
					FROM documentos
					WHERE status = 10
				 ";
		$execute_query = $conn->query($query);
		$fila = $execute_query->fetch_array();
		if($execute_query){
			$message = $fila['c'];
		}else{
			$error = 'Error cargando los documentos aprobados de base de datos: '.$conn->error;
		}

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function r_clr_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';
	    $u = $_SESSION['id_u'];
	    $rol = $_SESSION['rol_id'];

	    	$query = "
	    		SELECT 
					(@row := @row + 1) as rownr,
					codigo, 
					alcance, 
					version,  
					td.tipo_de_documento AS tipo_documento,
					proceso_principal, 
					sd.nombre AS 'status'
				FROM documentos
				CROSS join (select @row := 0) r
				INNER JOIN tipo_de_documentos td
				ON documentos.id_tipo_documento = td.id
				INNER JOIN status_documentos sd
				ON documentos.`status` = sd.id;
	    	";
	   
	    
//error_log($query);
	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	        	$number      		= $row['rownr'];
	            $codigo  			= $row['codigo'];
	            $alcance  			= $row['alcance'];
	            $version 			= $row['version'];
	            $tipo_documento 	= $row['tipo_documento'];
	            $proceso_principal 	= $row['proceso_principal'];
	            $status 			= $row['status'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	            	'number'			=> $number,
	                'codigo' 			=> $codigo,
	                'alcance' 			=> $alcance,
	                'version' 			=> $version,
	                'tipo_documento' 	=> $tipo_documento,
	                'proceso_principal'	=> $proceso_principal,
	                'status' 			=> $status
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

	function r_pd_Function(){
		global $conn;
		$jsondata 		 = array();
		$error 	  		 = '';
		$message  		 = '';
		$id 			 = $_POST['id'];

		$query = "
				UPDATE documentos
				SET status = 11
				WHERE id = $id
				 ";

		//error_log($query);
		
		$execute_query = $conn->query($query);

		if($execute_query){
			$message = 'Documento procesado correctamente!';
		}else{
			$error = 'Error en la base de datos urgente revisar: '.$conn->error;
		}

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function mu_mu_Function(){
		global $conn;
		$jsondata 		 = array();
		$error 	  		 = '';
		$message  		 = '';
		$nombre 		 = $_POST['nombre'];
		$apellido 		 = $_POST['apellido'];
		$select_region 	 = $_POST['select_region'];
		$select_sucursal = $_POST['select_sucursal'];
		$select_rol		 = $_POST['select_rol'];
		$pass1 			 = $_POST['pass1'];
		$pass2 			 = $_POST['pass2'];
		$email 			 = $_POST['email'];

		if(($pass1 == $pass2) && ($pass1 != '')){
			
			$query = "
				UPDATE users
				SET nombre = '$nombre',
				apellido = '$apellido',
				region_id = $select_region,
				sucursal_id = $select_sucursal,
				rol_id = $select_rol,
				password = md5('$pass1')
				WHERE email = '$email'
				 ";
		}else{
			$query = "
				UPDATE users
				SET nombre = '$nombre',
				apellido = '$apellido',
				region_id = $select_region,
				sucursal_id = $select_sucursal,
				rol_id = $select_rol
				WHERE email = '$email'
				 ";
		}

		//error_log($query);
		
		$execute_query = $conn->query($query);

		if($execute_query){
			$message = 'Usuario modificado';
		}else{
			$error = 'Error cargando los roles de base de datos: '.$conn->error;
		}

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function mu_ds_Function(){
		global $conn;
		$jsondata 		= array();
		$error 	  		= '';
		$message  		= '';
		$search 		= $_POST['buscar'];
		$html_id 		= $_POST['html_id'];
		$table 			= $_POST['tabla'];
		$fill_search	= '';
		$clausula 		= '';
		$html 			= '';

		if ($table == 'region') {
			$fill_search = 'id_region';
			$clausula = 'status_region';
		}

		if ($table == 'sucursal') {
			$fill_search = 'id';
			$clausula = 'status';
		}

		if ($table == 'roles') {
			$fill_search = 'id_rol';
			$clausula = 'status_rol';
		}

		if($fill_search <> '' || $clausula <> ''){
			$query = "
				SELECT *
					FROM $table
					WHERE $clausula = 1
					ORDER BY CASE 
					    WHEN $fill_search = $search THEN 0
					    ELSE 1
					END;
					 ";
			$execute_query = $conn->query($query);
			//error_log($query);
			if($execute_query){
				//$data_rows = $execute_query->fetch_array();
				while($row = $execute_query->fetch_array()){
					foreach ($row as $key => $value) {
						if (!is_numeric($key)) {
							$data_rows[] = array(
								$key => $value
							);
						}
						
					}
				}
			}else{
				$error = 'Error cargando los roles de base de datos: '.$conn->error;
			}
		}
		

		if ($table == 'region') {
			$c = 1;
			foreach ($data_rows as $key => $value) {
				//error_log(print_r($value,true));
				
				if (isset($value['id_region'])) {
					if ($c == 1) {
						$html .= "<option value='".$value['id_region']."' selected>"; 
					}else{
						$html .= "<option value='".$value['id_region']."'>"; 
					}
					$c++;	
				}
				if (isset($value['nombre_region'])) {
					$html .= $value['nombre_region']."</option>"; 
				}
			}
		}

		if ($table == 'sucursal') {
			$c = 1;
			foreach ($data_rows as $key => $value) {
				//error_log(print_r($value,true));
				
				if (isset($value['id'])) {
					if ($c == 1) {
						$html .= "<option value='".$value['id']."' selected>"; 
					}else{
						$html .= "<option value='".$value['id']."'>"; 
					}
					$c++;	
				}
				if (isset($value['nombre'])) {
					$html .= $value['nombre']."</option>"; 
				}
			}
		}

		if ($table == 'roles') {
			$c = 1;
			foreach ($data_rows as $key => $value) {
				//error_log(print_r($value,true));
				
				if (isset($value['id_rol'])) {
					if ($c == 1) {
						$html .= "<option value='".$value['id_rol']."' selected>"; 
					}else{
						$html .= "<option value='".$value['id_rol']."'>"; 
					}
					$c++;	
				}
				if (isset($value['nombre_rol'])) {
					$html .= $value['nombre_rol']."</option>"; 
				}
			}
		}

		$jsondata['message'] = $html;
		$jsondata['error']   = $error;

		//error_log(print_r($jsondata,true));
		echo json_encode($jsondata);
	}

	function mu_od_Function(){
		global $conn;
		$jsondata 	= array();
		$error 	  	= '';
		$message  	= '';
		$selects 	= $_POST['selects'];
		$inputs 	= $_POST['inputs'];
		$tabla 		= $_POST['tabla'];
		$search 	= $_POST['id'];
		$campos_txt = '';

		if ($selects>0 || $inputs>0) {
			$campos = array_merge($inputs,$selects);
			//error_log(print_r($campos,true));
			foreach ($campos as $key => $value) {
				$campos_txt .= $value . ',';  
			}
			$campos_txt = substr($campos_txt, 0,-1);
		}

		$query = "SELECT $campos_txt 
				  FROM $tabla 
				  WHERE id = $search;
				 ";
		 
		$execute_query = $conn->query($query);

		if($execute_query){
			$rows = $execute_query->fetch_array();
			$keys = explode(',', $campos_txt);
			//error_log(print_r($keys,true));
			//error_log(print_r($row,true));
			//error_log(count($keys));
			for ($i=0; $i <= count($keys)-1; $i++) { 
				$key = $keys[$i];
				$value = $rows[$i];
				// Agrega los resultados al arreglo $rows
	            $data_rows[$key] = $value;
			}
		}else{
			$error = 'Error cargando los roles de base de datos: '.$conn->error;
		}
		
		//error_log(print_r($data_rows,true));
		$jsondata['message'] = $data_rows;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function o_lfo_Function() {
	    global $conn;
	    $html = [];
	    $error = '';
	    $origen = $_POST['origen'];

	    // Verificar si se proporciona el nombre de la carpeta
	    if (isset($_POST['folderName'])) {
	        $folderName = $_POST['folderName'];
	//error_log("FOLDER NAME: $folderName");
	        // Ajusta la ruta de la carpeta según tu estructura
			if ($folderName != 'start') {
				$folderPath = "../../../pages/$origen/$folderName";
			}else{
				$folderPath = "../../../pages/$origen/";
			}
	//error_log("FOLDER PATH: $folderPath");
	        // Obtener el contenido de la carpeta
	        $contenido = scandir($folderPath);
	//error_log(print_r($contenido,true));

	        // Filtrar archivos y carpetas ocultos
	        $contenido_visible = array_filter($contenido, function ($item) {
	            return !in_array($item, ['.', '..']);
	        });

	        // Extraer información sobre el tipo de elemento y generar vista previa
	        foreach ($contenido_visible as $item) {
	            $tipo = is_dir($folderPath .'/'. $item) ? 'folder' : 'file';
	            
	            //error_log("IS DIR: $folderPath / $item");
	            //error_log("TIPO: $tipo");

	            if ($tipo === 'file') {
	                $extension = strtolower(pathinfo($item, PATHINFO_EXTENSION));

	                if ($extension === 'docx') {
	                    $preview = generateWordPreview($folderPath . $item);
	                } elseif ($extension === 'pdf') {
	                    $preview = generatePdfPreview($folderPath . $item);
	                } else {
	                    $preview = null;
	                }

	                // Agregar el enlace de descarga
                	$downloadLink = "<a href='#' class='download-link' data-path='$item'>Descargar</a>";
	            } else {
	                $preview = null;
	                $downloadLink = null;
	            }

	            //$html[] = ['name' => $item, 'type' => $tipo, 'preview' => $preview, 'downloadLink' => $downloadLink];
	            $html[] = ['name' => $item, 'type' => $tipo, 'preview' => $preview, 'downloadLink' => $folderPath.'/'.$item];
	        }
	    } else {
	        $error = 'No se proporcionó el nombre de la carpeta.';
    	}

	    $jsondata['html'] = $html;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function moverArchivo($id,$solicitud) {
		global $conn;
	
		switch($solicitud){
			case 1:
				$carpetaDestino = "../../../pages/documents/";
				$txt = 'oficial';
				break;
			case 14:
				$carpetaDestino = "../../../pages/obsoletos/";
				$txt = 'obsoleto';
				break;
		}
		
		// Buscar ruta de origen en la base de datos
		$query_search_origen = "
			SELECT path_documento,proceso_principal,sub_proceso
			FROM documentos
			WHERE id = $id
		";

		$execute_query 	= $conn->query($query_search_origen);
		$row_query 		= $execute_query->fetch_array();
		$archivoOrigen 	= $row_query['path_documento'];
		$proceso 		= $row_query['proceso_principal'];
		$subproceso 	= $row_query['sub_proceso'];

		//error_log("Archivo Origen: ".$archivoOrigen);

		// Agrega a la ruta destino el proceso y subproceso donde se guardara el archivo revisado
		if($subproceso != 'No existen subprocesos creados...'){
			$carpetaDestino .= "$proceso/$subproceso/";
		}else{
			$carpetaDestino .= "$proceso/";
		}

		if (!file_exists($carpetaDestino)) {
		    mkdir($carpetaDestino, 0777, true);
		}

	    // Verificar si el archivo de origen existe
	    if (file_exists($archivoOrigen)) {
	        // Construir la ruta de destino
	        $rutaDestino = rtrim($carpetaDestino, '/') . '/';
	        //error_log("Destino: $rutaDestino");

	        // Si se proporciona un nuevo nombre, usarlo; de lo contrario, mantener el nombre original
	        $nombreArchivo = basename($archivoOrigen);

	        // Construir la ruta completa del archivo de destino
	        $rutaCompletaDestino = $rutaDestino . $nombreArchivo;

	        // Intentar mover el archivo
	        if (rename($archivoOrigen, $rutaCompletaDestino)) {
	        	$query = "
	        		UPDATE documentos
	        		SET path_documento = '$rutaCompletaDestino'
	        		WHERE id = $id
	        	";
	        	$execute_query = $conn->query($query);
	            return "El archivo ahora es un documento $txt!";
	        } else {
	            return "Error al intentar mover el archivo.";
	        }
	    } else {
	        return "El archivo de origen no existe.";
		}
	
		echo $resultado;
		
	}

	function o_cpo_Function(){
	    global $conn;
	    $html           = [];
	    $message        = '';
	    $error          = '';
	    $origen 		= $_POST['origen'];
	    $ruta_obsoletos = "../../../pages/$origen/";

	    // Obtener el contenido de la carpeta
	    $contenido = scandir($ruta_obsoletos);

	    // Filtrar archivos y carpetas ocultos
	    $contenido_visible = array_filter($contenido, function($item) {
	        return !in_array($item, ['.', '..']);
	    });

	    // Extraer información sobre el tipo de elemento y generar vista previa
	    foreach ($contenido_visible as $item) {
	        $tipo = is_dir($ruta_obsoletos . $item) ? 'folder' : 'file';

	        if ($tipo === 'file') {
	            $extension = strtolower(pathinfo($item, PATHINFO_EXTENSION));

	            if ($extension === 'docx') {
	                // Generar vista previa para Word
	                $preview = generateWordPreview($ruta_obsoletos . $item);
	            } elseif ($extension === 'pdf') {
	                // Generar vista previa para PDF
	                $preview = generatePdfPreview($ruta_obsoletos . $item);
	            } else {
	                // Otro tipo de archivo, no se genera vista previa
	                $preview = null;
	            }
	        } else {
	            $preview = null;
	        }

	        $html[] = ['name' => $item, 'type' => $tipo, 'preview' => $preview];
	    }

	    // Devolver JSON con la información
	    $jsondata['html']       = $html;
	    $jsondata['message']    = $message;
	    $jsondata['error']      = $error;
	    echo json_encode($jsondata);
	}

	function generateWordPreview($filePath) {
	    try {
	    	
			$imagePath = '../pages/tmp/word.png';
	        return $imagePath;
	        
	    } catch (\Exception $e) {
	        return null;
	    }
	}

	function generatePdfPreview($filePath) {
	    try {
	        $imagePath = '../pages/tmp/pdf.png';
	        return $imagePath;
	    } catch (\Exception $e) {
	        return null;
	    }
	}

	function cdc_clcc_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if (isset($_POST['busqueda'])) {
	    	$busqueda = $_POST['busqueda'];
	    	$query = "
	    		SELECT * FROM
				(
					SELECT 
						history.id_documento AS codigo,
						observacion,
						sd.nombre,
						history.date_time,
						CONCAT(us.nombre,' ',us.apellido) AS solicitante,
						CONCAT(ua.nombre,' ',ua.apellido) AS aprueba
					FROM history
					INNER JOIN status_documentos sd
					ON history.status = sd.id
					INNER JOIN users us 
					ON history.id_solicitante = us.id
					INNER JOIN users ua
					ON history.id_aprobar = ua.id
					WHERE status_history = 1
					UNION
					SELECT documentos.codigo,
						cr.comentario AS observacion,
						sd.nombre,
						cr.date_time,
						CONCAT(us.nombre,' ',us.apellido) AS solicitante,
						CONCAT(ua.nombre,' ',ua.apellido) AS aprueba
					FROM comentarios_rechazo cr
					INNER JOIN documentos
					ON cr.id_documento = documentos.id
					INNER JOIN status_documentos sd
					ON documentos.`status` = sd.id
					INNER JOIN users us
					ON documentos.quien_elabora = us.id
					INNER JOIN users ua
					ON documentos.quien_revisa = ua.id
				) base
				WHERE codigo LIKE '%$busqueda%'
				OR observacion LIKE '%$busqueda%'
				ORDER BY date_time
				
					    ";
	    }else{
	    	$query = "
	    		SELECT * FROM
				(
					SELECT 
						history.id_documento AS codigo,
						observacion,
						sd.nombre,
						history.date_time,
						CONCAT(us.nombre,' ',us.apellido) AS solicitante,
						CONCAT(ua.nombre,' ',ua.apellido) AS aprueba
					FROM history
					INNER JOIN status_documentos sd
					ON history.status = sd.id
					INNER JOIN users us 
					ON history.id_solicitante = us.id
					INNER JOIN users ua
					ON history.id_aprobar = ua.id
					WHERE status_history = 1
					UNION
					SELECT documentos.codigo,
						cr.comentario AS observacion,
						sd.nombre,
						cr.date_time,
						CONCAT(us.nombre,' ',us.apellido) AS solicitante,
						CONCAT(ua.nombre,' ',ua.apellido) AS aprueba
					FROM comentarios_rechazo cr
					INNER JOIN documentos
					ON cr.id_documento = documentos.id
					INNER JOIN status_documentos sd
					ON documentos.`status` = sd.id
					INNER JOIN users us
					ON documentos.quien_elabora = us.id
					INNER JOIN users ua
					ON documentos.quien_revisa = ua.id
				) base
				ORDER BY date_time
					    ";
	    }
	    

	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	        	$codigo      			= $row['codigo'];
	            $observacion 			= $row['observacion'];
	            $estado_solicitado  	= $row['nombre'];
	            $fecha_hora_solicitud 	= $row['date_time'];
	            $solicitante 			= $row['solicitante'];
	            $aprueba 				= $row['aprueba'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	            	'codigo'				=> $codigo,
	                'observacion' 			=> $observacion,
	                'estado_solicitado' 	=> $estado_solicitado,
	                'fecha_hora_solicitud' 	=> $fecha_hora_solicitud,
	                'solicitante' 			=> $solicitante,
	                'aprueba' 				=> $aprueba
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

	function sddi_ced_Function(){
		global $conn;
		$jsondata 	= array();
		$error 	  	= '';
		$message  	= '';
		$codigo 	= $_POST['codigo'];
		$status 	= $_POST['status'];

		$query = "UPDATE documentos
					SET status = $status, 
					status_revision = 0
					WHERE codigo = '$codigo';
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			$message = 'Cambio de estatus del documento exitoso!';
		}else{
			$error = 'No se pudo aprobar el documento: '.$conn->error;
		}

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function sddi_h_Function(){
		global $conn;
		$jsondata 	 = array();
		$error 	  	 = '';
		$message  	 = '';
		$nombre   	 = '';
		$solicitante = '';
		$u 		 	 = $_SESSION['id_u'];
		
		if(isset($_POST['observacion'])){
			$observacion = $_POST['observacion'];
		}else{
			$observacion = '';
			$error .= 'Observacion no ingresada correctamente.   ';
		}

		if(isset($_POST['codigo'])){
			$codigo = $_POST['codigo'];
		}else{
			$codigo = '';
			//$error .= 'Código no ingresado correctamente.   ';
			if(isset($_POST['id'])){
				$id = $_POST['id'];
				$query_datos = "SELECT nombre,codigo,quien_aprueba
					FROM documentos
					WHERE id = $id
				";
//error_log($query_datos);
				$execute_query = $conn->query($query_datos);
				while ($fila = $execute_query->fetch_array()){
					$nombre = $fila['nombre'];
					$codigo = $fila['codigo'];
					$q_a 	= $fila['quien_aprueba'];

				}
	
			}else{
				$error .= 'Código no ingresado correctamente.   ';
			}
		}

		if(isset($_POST['nombre'])){
			$nombre = $_POST['nombre'];
		}else{
			if ($nombre == ''){
				$error .= 'Nombre no ingresado correctamente.   ';
			}
			
		}

		if(isset($_POST['solicitante'])){
			if($_POST['solicitante'] > 0){
				$solicitante = $_POST['solicitante'];
			}else{
				$error .= 'Solicitante no ingresado correctamente.   ';
			}
			
		}else{
			if($solicitante == ''){
				$solicitante = $u;
			}else{
				$error .= 'Usuario de solicitante no ingresado correctamente.   ';
			}
			
		}

		if(isset($_POST['aprobacion'])){
			if($_POST['aprobacion'] > 0){
				$aprobacion = $_POST['aprobacion'];
			}else{
				$error .= 'Usuario de aprobación no ingresado correctamente.   ';	
			}
		}else{
			$aprobacion = $q_a;
		}

		if(isset($_POST['solicitud'])){
			$solicitud = $_POST['solicitud'];
		}else{
			$solicitud = '';
			$error .= 'Id de solicitud no ingresado correctamente.   ';
		}

		if(isset($_POST['status'])){
			$status = $_POST['status'];
		}else{
			$status = '';
			$error .= 'Status de solicitud no ingresado correctamente.   ';
		}

		$query = "INSERT INTO history (id_documento,observacion,status,status_history,date_time,id_solicitante,id_aprobar)
					VALUES ('$codigo','$observacion',$status,1,NOW(),$solicitante,$aprobacion);
				 ";
		if($error == ''){
			try{
				$execute_query = $conn->query($query);

				if($execute_query){
					$message = 'Solicitud guardada con éxito!';
				}
			} catch (Exception $e) {
				if(strpos($e,'FOREIGN KEY (`id_documento`)') !== false ){
					$error .= 'Solicitud rechazanda: No existe el código ingresado';
				}
				//$error .= 'Solicitud rechazanda: '.$conn->error .'/n';
				error_log($conn->error);
			}
		}
		

		//error_log("Mensaje: $message Error: $error");
		
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function sddi_cdn_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';
		$html 	  = '';
		$codigo   = $_POST['codigo'];

		$query = "SELECT nombre FROM documentos
					WHERE codigo LIKE '$codigo%'
				 ";
	//error_log($query);
		$execute_query = $conn->query($query);

		if($execute_query){
			
			while($row = $execute_query->fetch_array()){
				
				$nombre = $row['nombre'];

				$data_rows[] = array(
					'nombre'	=> $nombre
				);
			}
			
		}else{
			$error = 'Error cargando el nombre de base de datos: '.$conn->error;
		}

		$jsondata['data'] 		= $data_rows;
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function sd_ced_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';
		$html 	  = '';

		$query = "
			SELECT id,nombre 
			FROM status_documentos
			WHERE id NOT IN (1,10,13,12,11,5,9)
			ORDER BY id
		";
		$execute_query = $conn->query($query);

		if($execute_query){
			$html .= "<option value='0'>Selecciona un estatus...</option>";
			while($row = $execute_query->fetch_array()){
				$id 	= $row['id'];
				$nombre = $row['nombre'];
				$html .= "<option value='$id'>$nombre</option>";	

				$data_rows[] = array(
					'id' 		=> $id,
					'nombre'	=> $nombre
				);
			}
			
		}else{
			$error = 'Error cargando los estados de base de datos: '.$conn->error;
		}

		$jsondata['list'] 		= $data_rows;
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function r_ced_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';
		$id_revision = $_SESSION['id_u'];
		$rol = $_SESSION['rol_id'];

		if(isset($_POST['id'])){
			$id = $_POST['id'];
		}else{
			$id = '';
		}

		//verificar estatus del documento para saber su siguiente paso
		/*
			1) Si esta en Solicitud de algo pasar a En Revisión
			2) Si esta en Revisión pasar a En Aprobación
			3) Si esta en Aprobación pasarlo a Implementado y mover el archivo a Documentos implementados
		*/
		
		$query = "
			SELECT status 
			FROM documentos
			WHERE id = $id
		";

		$execute_query = $conn->query($query);
		$fila          = $execute_query->fetch_array();
		$status 	   = $fila['status'];
error_log($query);
		/*
		if($status == 2){
			$change_status = 12
		}
		*/
		
		switch ($status) {
			case 2:
				$change_status = 13;

				$query = "UPDATE documentos
					SET status = $change_status, 
					status_revision = 1
					WHERE id = $id;
				 ";
				break;
			case 4:
				$change_status = 12;

				$query = "UPDATE documentos
					SET status = $change_status, 
					status_revision = 1
					WHERE id = $id;
				";
				break;
			case 3:
				$change_status = 13;
				
				$query = "UPDATE documentos
					SET status = $change_status, 
					status_revision = 1
					WHERE id = $id;
				 ";
				break;
			case 13:
				$change_status = 12;

				$query = "UPDATE documentos
					SET status = $change_status, 
					status_revision = 1
					WHERE id = $id;
				";
				break;
			case 12:
				$change_status = 10;
				
				$query = "UPDATE documentos
					SET status = $change_status, 
					status_revision = 1,
					fecha_revision = NOW(),
					quien_revisa = $id_revision
					WHERE id = $id;
				 ";
				break;
			case 10:
				$change_status = 1;
				
				$query = "UPDATE documentos
					SET status = $change_status, 
					status_revision = 1,
					fecha_aprobacion = NOW(),
					quien_aprueba = $id_revision
					WHERE id = $id;
				 ";
				break;
		}
//error_log($query);
		$execute_query = $conn->query($query);

		if($execute_query){
			//error_log("ROL: $rol");
			if($change_status == 1){
				//$message = moverArchivo($id,$solicitud);
				$message = moverArchivo($id,$change_status);
			}else{
				$message = 'Cambio de estatus del documento exitoso!';
			}
			
			$query = "
				SELECT codigo, quien_elabora 
				FROM documentos d 
				WHERE id = $id
			";

			$execute_query = $conn->query($query);
			$fila 		   = $execute_query->fetch_array();
			$codigo 	   = $fila['codigo'];
			$quien_elabora = $fila['quien_elabora'];
			$observacion = "Documento, cambio de estado!";
            $query = "INSERT INTO history (id_documento,observacion,status,status_history,date_time,id_solicitante,id_aprobar) VALUES ('$codigo','$observacion',$change_status,1,NOW(),$quien_elabora,$id_revision);
			";

			$execute_query = $conn->query($query);
		}else{
			$error = 'No se pudo aprobar el documento: '.$conn->error;
		}

		/*
		if(isset($_POST['id'])){
			$id = $_POST['id'];
		}else{
			$id = '';
		}

		if(isset($_POST['solicitud'])){
			if($rol == 14){
				$solicitud = 10;
			}else{
				$solicitud = $_POST['solicitud'];	
			}
			
		}else{
			$solicitud = '';
		}

		$status = $_POST['status'];

		if ($rol == 14) {
			$query = "UPDATE documentos
					SET status = $status, 
					status_revision = 1,
					fecha_aprobacion = NOW(),
					quien_aprueba = $id_revision,
					status = 10
					WHERE id = $id;
				 ";
		}else{
			$query = "UPDATE documentos
					SET status = $status, 
					status_revision = 1,
					fecha_revision = NOW(),
					quien_revisa = $id_revision
					WHERE id = $id;
				 ";	
		}
		
		$execute_query = $conn->query($query);

		if($execute_query){
			//error_log("ROL: $rol");
			if($solicitud != '' && ($solicitud == 2 || $solicitud == 4 || $solicitud == 10 ) && $rol == 14){
				$message = moverArchivo($id,$solicitud);
			}else{
				$message = 'Cambio de estatus del documento exitoso!';
			}
			
		}else{
			$error = 'No se pudo aprobar el documento: '.$conn->error;
		}
		*/
		$jsondata['rol'] = $rol;
		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function r_gcr_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';
		
		if(isset($_POST['id'])){
			$id = $_POST['id'];
		}else{
			$id = '';
		}

		if(isset($_POST['comentario'])){
			$comentario = $_POST['comentario'];
		}else{
			$comentario = '';
		}

		$query = "INSERT INTO comentarios_rechazo (id_documento,comentario,date_time)
					VALUES ($id,'$comentario',NOW());
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			$message = 'El comentario de rechazo se guardo con éxito!';
		}else{
			$error = 'Error rechazando el documento: '.$conn->error;
		}

		$query = "UPDATE documentos
					SET status = 5, status_revision = 1
					WHERE id = $id;
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			$message = 'El comentario de rechazo se guardo con éxito!';
		}else{
			$error = 'No se pudo rechazar el documento: '.$conn->error;
		}

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function r_cdw_Function(){
		//error_log('Entrando');
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$call_document_path = "
				SELECT path_documento
				FROM documentos
				WHERE id = $id
			";
			$query_execute = $conn->query($call_document_path);
			$result = $query_execute->fetch_array();
			//$path = $result['path_documento'];
			$path = realpath($result['path_documento']);

			// Obtener la información de la ruta
			$info = pathinfo($path);
			// Obtener la extensión del archivo
			$extension = $info['extension'];
//error_log("PATH: $path, EXTENCION: $extension");
			if($extension != 'pdf'){
				//Crear un objeto de PHPWord
				$phpWord = \PhpOffice\PhpWord\IOFactory::load($path);

				 // Guardar el archivo como HTML temporal
		        $tempHtmlFile = 'temp.html';
		        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
		        $objWriter->save($tempHtmlFile);

		        // Leer el contenido del archivo HTML generado
		        $htmlContent = file_get_contents($tempHtmlFile);
		        unlink($tempHtmlFile); // Eliminar el archivo temporal

		        $message = $htmlContent;
			}else{
				$message = 'El archivo es PDF no se puede visualizar en el visor!';
			}
			

	        //error_log($path);
		}else {
	        $error = 'No se proporcionó un ID válido.';
	    }

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function r_cifd_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if(isset($_POST['id'])){

	    	$id = $_POST['id'];
	    //error_log("id que me enviaron: $id");
	    	$query = "
		    		SELECT 
						CONCAT(elabora.nombre,' ',elabora.apellido) AS quien_elabora,
						fecha,
						CONCAT(revisa.nombre,' ',revisa.apellido) AS quien_revisa,
						fecha_revision,
						CONCAT(aprueba.nombre,' ',aprueba.apellido) AS quien_aprueba,
						fecha_aprobacion
					FROM documentos
					LEFT JOIN users AS elabora
					ON documentos.quien_elabora = elabora.id
					LEFT JOIN users AS revisa
					ON documentos.quien_revisa = revisa.id
					LEFT JOIN users AS aprueba
					ON documentos.quien_aprueba = aprueba.id
					WHERE documentos.id = $id
		    ";

		    // Ejecuta la consulta y verifica si se ejecutó correctamente
		    $execute_query = $conn->query($query);

		    if ($execute_query) {
		        // Obtenemos los resultados
		        $rows = array();
		        while ($row = $execute_query->fetch_array()) {
		        
		            $quien_elabora  = $row['quien_elabora'];
		            $fecha_elabora  = $row['fecha'];
		            $quien_revisa  	= $row['quien_revisa'];
		            $fecha_revision = $row['fecha_revision'];
		            $quien_aprueba  = $row['quien_aprueba'];
					$fecha_aprueba  = $row['fecha_aprobacion'];	

					if($quien_elabora == null){
						$quien_elabora = '';
					}	            
		            
					if($fecha_elabora == null){
						$fecha_elabora = '';
					}	      

					if($quien_revisa == null){
						$quien_revisa = '';
					}	             

					if($fecha_revision == null){
						$fecha_revision = '';
					}	

					if($quien_aprueba == null){
						$quien_aprueba = '';
					}	              

					if($fecha_aprueba == null){
						$fecha_aprueba = '';
					}	                           
		            // Agrega los resultados al arreglo $rows
		            $data_rows[] = array(
		                'elabora' 			=> $quien_elabora,
		                'fecha_elabora' 	=> $fecha_elabora,
		                'revisa'		 	=> $quien_revisa,
		                'fecha_revisa'		=> $fecha_revision,
		                'aprueba'		 	=> $quien_aprueba,
		                'fecha_aprueba'	 	=> $fecha_aprueba
		            );
		        }

		        // Agrega los resultados al arreglo jsondata
		        $jsondata['data'] = $data_rows;
		        $message = 'Consulta ejecutada con éxito.';
		    } else {
		        // La consulta falló, establece un mensaje de error
		        $error = 'Error al ejecutar la consulta: ' . $conn->error;
		    }
	    }else{
	    	$error = "No se encontro ningun ID.";
	    	//error_log('No tengo ID');
	    }

	    

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function r_cibd_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    if(isset($_POST['id'])){

	    	$id = $_POST['id'];
	    //error_log("id que me enviaron: $id");
	    	$query = "
		    		SELECT 
					    d.nombre,
					    d.proceso_principal,
					    IFNULL(td.tipo_de_documento, 'SOLICITUD') AS tipo_de_documento,
					    d.version,
					    d.codigo,
					    d.alcance
					FROM 
					    documentos d
					LEFT JOIN 
					    tipo_de_documentos td ON td.id = d.id_tipo_documento
					WHERE 
					    d.id = $id
		    ";

		    // Ejecuta la consulta y verifica si se ejecutó correctamente
		    $execute_query = $conn->query($query);

		    if ($execute_query) {
		        // Obtenemos los resultados
		        $rows = array();
		        while ($row = $execute_query->fetch_array()) {
		        
		            $nombre_documento  = $row['nombre'];
		            $proceso_principal = $row['proceso_principal'];
		            $tipo_de_documento = $row['tipo_de_documento'];
		            $version           = $row['version'];
		            $codigo_documento  = $row['codigo'];
		            $alcance 		   = $row['alcance'];
		            
		            // Agrega los resultados al arreglo $rows
		            $data_rows[] = array(
		                'nombre' 			=> $nombre_documento,
		                'proceso_principal' => $proceso_principal,
		                'tipo_de_documento' => $tipo_de_documento,
		                'version' 			=> $version,
		                'codigo' 			=> $codigo_documento,
		                'alcance'			=> $alcance
		            );
		        }

		        // Agrega los resultados al arreglo jsondata
		        $jsondata['data'] = $data_rows;
		        $message = 'Consulta ejecutada con éxito.';
		    } else {
		        // La consulta falló, establece un mensaje de error
		        $error = 'Error al ejecutar la consulta: ' . $conn->error;
		    }
	    }else{
	    	$error = "No se encontro ningun ID.";
	    	//error_log('No tengo ID');
	    }

	    

	    // Agrega el mensaje y el error al arreglo jsondata
	    $jsondata['message'] = $message;
	    $jsondata['error'] = $error;
	    echo json_encode($jsondata);
	}

	function r_cld_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';
	    $u = $_SESSION['id_u'];
	    $rol = $_SESSION['rol_id'];

// LOGICA ANTERIOR
/*
	    if($rol != 14){
	    	$query = "
	    		SELECT d.id,d.nombre,d.codigo,sd.nombre AS tipo_de_solicitud,sd.id AS id_solicitud
				FROM documentos d
				INNER JOIN status_documentos sd
				ON sd.id = d.status
				WHERE status_revision = 0
				AND quien_revisa = $u
				AND status NOT IN (5,10,11) 
	    	";
	    	
	    }else{
	    	$query = "
	    		SELECT d.id,d.nombre,d.codigo,sd.nombre AS tipo_de_solicitud,sd.id AS id_solicitud
				FROM documentos d
				INNER JOIN status_documentos sd
				ON sd.id = d.status
				WHERE fecha_revision IS NOT NULL
				AND quien_aprueba = $u
				AND status NOT IN (5,10,11)  
	    	";
	    }
*/

	$query = "
		SELECT 
	    CASE 
	        WHEN EXISTS (
	            SELECT * 
	            FROM privilegios 
	            WHERE id_rol = $rol AND id_privilegio = 1
	        ) THEN 'Puede crear'
	        WHEN EXISTS (
	            SELECT * 
	            FROM privilegios 
	            WHERE id_rol = $rol AND id_privilegio = 20
	        ) THEN 'Puede aprobar'
	        ELSE 'No puede crear'
	    END AS mensaje
    ";
//error_log($query);
 	$execute_query = $conn->query($query);
 	$result = $execute_query->fetch_array();
 	$mensaje = $result['mensaje'];

 	if($mensaje == "Puede crear"){
 		$query = "
 			SELECT d.id,d.nombre,d.codigo,sd.nombre AS tipo_de_solicitud,sd.id AS id_solicitud
			FROM documentos d
			INNER JOIN status_documentos sd 
			ON d.status = sd.id 
			WHERE d.status IN (2,3,4)
 		";
 	}elseif($mensaje == "Puede aprobar"){
 		$query = "
 			SELECT d.id,d.nombre,d.codigo,sd.nombre AS tipo_de_solicitud,sd.id AS id_solicitud
			FROM documentos d
			INNER JOIN status_documentos sd 
			ON d.status = sd.id 
			WHERE d.status IN (10)
 		";
 	}else{
 		$query = "
 			SELECT d.id,d.nombre,d.codigo,sd.nombre AS tipo_de_solicitud,sd.id AS id_solicitud
			FROM documentos d
			INNER JOIN status_documentos sd 
			ON d.status = sd.id 
			WHERE d.status IN (12)
			AND d.quien_revisa = $u
 		";
 	}

//error_log($mensaje);
	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);
//error_log($query);
	    if ($execute_query) {
	        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	        	$id_documento      = $row['id'];
	            $nombre_documento  = $row['nombre'];
	            $codigo_documento  = $row['codigo'];
	            $tipo_de_solicitud = $row['tipo_de_solicitud'];
	            $id_solicitud 	   = $row['id_solicitud'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	            	'id'				=> $id_documento,
	                'nombre' 			=> $nombre_documento,
	                'codigo' 			=> $codigo_documento,
	                'tipo_de_solicitud' => $tipo_de_solicitud,
	                'id_solicitud' 		=> $id_solicitud
	            );
	        }

	        // Agrega los resultados al arreglo jsondata
	        if(isset($data_rows)){
	        	$jsondata['data'] = $data_rows;
	        }else{
	        	$jsondata['data'] = "";
	        }
	        
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

	function cd_cd_Function(){
		//FUNCION PARA CREAR DOCUMENTO DESDE SOLICITUD
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';
		$codigo = $_POST["codigo"];
		if(isset($_SESSION['id_u'])){
			$solicitante = $_SESSION['id_u'];	
		}
		
		$quien_elabora = $solicitante;
		if(isset($_POST['documento_pendiente'])){
			$documento_pendiente = $_POST['documento_pendiente'];
		}else{
			$documento_pendiente = 0;
		}
		
		if (isset($_POST['codigo_pendiente'])) {
			$codigo_pendiente = $_POST['codigo_pendiente'];

			$query = "
				SELECT codigo 
				FROM documentos d 
				WHERE id = $codigo_pendiente
			";

			$execute_query = $conn->query($query);
			$fila = $execute_query->fetch_array();
			$codigo_antiguo = $fila['codigo'];
		}else{
			$codigo_antiguo = "";
		}
		

		// Verifica si se ha subido un archivo y no hay errores en la carga
	    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == UPLOAD_ERR_OK) {
	        // Obtén los datos del formulario
	        $nombre = $_POST["nombre"];
	        $proceso_principal = $_POST["proceso_principal"];
	        
	        if(isset($_POST["otros_procesos"])){
	        	$otros_procesos = $_POST["otros_procesos"];
	        }else{
	        	$otros_procesos = "";
	        }

	        $subproceso = $_POST["subproceso"];
	        if (isset($_POST["tipo_documento"])) {
	        	$id_tipo_documento = $_POST["tipo_documento"];
	        }else{
	        	$id_tipo_documento = 0;
	        }
	        
			
			if(isset($_POST["version"])){
	        	$version = $_POST["version"];
	        }else{
	        	$version = '001';
	        }	   

	        if(isset($_POST["solicitud"])){
	        	$solicitud = $_POST["solicitud"];
	        }else{
	        	$solicitud = 2;
	        }     

	        if(isset($_POST["alcance"])){
	        	$alcance = $_POST["alcance"];
	        }else{
	        	$alcance = '';
	        }
	        
	        // INICIA BUSQUEDA PARA CREACION DE CODIGO SEGUN LAS SIGLAS RECIBIDAS
	        
	        $query_codigo = "
				SELECT IFNULL(
				(SELECT 
					RIGHT(CONCAT('$codigo', LPAD(SUBSTRING(codigo, LENGTH(codigo) - 2) + 1, 3, '0')), 3) 
					FROM documentos 
					WHERE codigo LIKE '$codigo%' 
					ORDER BY SUBSTRING(codigo, LENGTH(codigo) - 2) DESC 
					LIMIT 1),
					'001'
				) AS codigo;
	        ";
//error_log($query_codigo);
	        $execute_query_codigo = $conn->query($query_codigo);
	        $result = $execute_query_codigo->fetch_array();
	        $correlativo_txt = $result['codigo'];
	        $codigo .= $correlativo_txt;
//error_log("CODIGO: $codigo"); 
	        /*
	        if(isset($_POST["quien_elabora"])){
	        	$quien_elabora = $_POST["quien_elabora"];
	        }else{
	        	$quien_elabora = "";
	        }
			*/

	        if(isset($_POST["quien_revisa"])){
	        	$quien_revisa = $_POST["quien_revisa"];
	        }else{
	        	$quien_revisa = "";
	        }

	        if(isset($_POST["quien_aprueba"])){
	        	$quien_aprueba = $_POST["quien_aprueba"];
	        }else{
	        	$quien_aprueba = "";
	        }
	        
	        if(isset($_POST["quien_visualiza"])){
	        	$quien_visualiza = $_POST["quien_visualiza"];
	        }else{
	        	$quien_visualiza = "";
	        }
	        
	       
	        $quien_imprime = $_POST["quien_imprime"];

	        // Obtiene la información del archivo
	        $archivo_nombre = $_FILES["archivo"]["name"];
	        $archivo_tmp_name = $_FILES["archivo"]["tmp_name"];
	        $archivo_tamano = $_FILES["archivo"]["size"];
	        $archivo_tipo = $_FILES["archivo"]["type"];

	        
	        $ext 		= pathinfo($archivo_nombre, PATHINFO_EXTENSION);
			$new_name 	= $nombre .'.'. $ext;
			$valid_ext = array("pdf","docx","doc");

	        // Define la ruta de destino donde se guardará el archivo
	        //$ruta_destino = "../../../pages/newdocuments/" . $archivo_nombre;
	        $ruta_destino = "../../../pages/newdocuments/" . $new_name;
			
//error_log("Quien elabora: $quien_elabora, Quien revisa: $quien_revisa, Quien Aprueba: $quien_aprueba, Quien visualiza: $quien_visualiza");
	        // Dara un error al revisar que quien elabora no esta vacio
	        //if($quien_elabora !== "" && $quien_revisa !== "" && $quien_aprueba !== "" && $quien_visualiza !== ""){
			if($quien_elabora !== "" && $quien_revisa !== "" && $quien_visualiza !== "" && $nombre !==""){
	        	// Verifica si el archivo lleva la extención correcta.
				if (in_array($ext,$valid_ext)){
					// Mueve el archivo cargado a la ubicación de destino
			        if (move_uploaded_file($archivo_tmp_name, $ruta_destino)) {

			            // Prepara la consulta SQL para insertar en la tabla documentos
//error_log("Tipo de documento: $id_tipo_documento");
			            if ($id_tipo_documento != 0){
			            	$sql = "INSERT INTO documentos (nombre, proceso_principal, otros_procesos, sub_proceso, id_tipo_documento, version, codigo, alcance, quien_elabora, quien_revisa, quien_aprueba, path_documento, quien_visualiza, quien_imprime, status,status_revision,fecha) VALUES ('$nombre', '$proceso_principal', '$otros_procesos', '$subproceso', $id_tipo_documento, '$version', '$codigo', '$alcance', $quien_elabora, $quien_revisa, $quien_aprueba, '$ruta_destino', '$quien_visualiza', '$quien_imprime', $solicitud,0,NOW())";
			            }else{
			            	$sql = "INSERT INTO documentos (nombre, proceso_principal, otros_procesos, sub_proceso, version, codigo, alcance, quien_elabora, quien_revisa, path_documento, quien_visualiza, quien_imprime, status,status_revision,fecha) VALUES ('$nombre', '$proceso_principal', '$otros_procesos', '$subproceso','$version', '$codigo', '$alcance', $quien_elabora, $quien_revisa, '$ruta_destino', '$quien_visualiza', '$quien_imprime', $solicitud,0,NOW())";
			            }
			      			if($documento_pendiente>0){
			      				$query = "
				      				UPDATE documentos 
									SET status = 11
									WHERE id = $documento_pendiente
				      			"; 
				      			//error_log($query);
				      			$run = $conn->query($query);
			      			}
			      			     

						try {
							$execute_query = $conn->query($sql);
						} catch (Exception $e) {
							$error = "Error: $e";
						}
			            

			            if ($execute_query) {
			            	if (isset($_POST['documentacion'])) {
			            		if($codigo_antiguo != ""){
			            			$observacion = "El código: $codigo_antiguo se documento y paso a tener el código: $codigo";
			            		}else{
			            			$observacion = "El documento ahora tiene el código: $codigo";
			            		}
			            	   	
			            	   	// ESTE QUERY CAMBIA EL ESTATUS A CREADO PARA QUE YA NO APAREZCA EN EL SELECT DE PENDIENTES DEL MENU DE "CREACION DE DOCUMENTO"
			            	   	$query_estatus_antiguo = "
			            	   		UPDATE documentos 
									SET status = 15
									WHERE codigo = '$codigo_antiguo'
			            	   	";
			            	   	$execute_query = $conn->query($query_estatus_antiguo);
			            	   }else{
			            	   	$observacion = "El usuario con id: $quien_elabora crea una solicitud";
			            	   }   
			                $message = "Solicitud creada exitosamente.";
			                
			                $query = "INSERT INTO history (id_documento,observacion,status,status_history,date_time,id_solicitante,id_aprobar) VALUES ('$codigo','$observacion',$solicitud,1,NOW(),$quien_elabora,$quien_revisa);
							";

							try {
								$execute_query = $conn->query($query);
							} catch (Exception $e) {
								$error = "Error: $e";
							}
							
//error_log($query);
			               
			            } else {
			                // Error en la preparación de la consulta SQL
			                $error = "Error en la preparación de la consulta SQL: " . $conn->error;;
			            }

			        } else {
			            // Error al mover el archivo
			            $error = "Error al mover el archivo a la ubicación de destino.";
			        }
				}else{
					$error = "El archivo no es PDF ni Word";
				}
	        }else{
	        	$error = "Debes elegir un nombre, quien elabora, quien revisa, quien aprueba y quien visualiza!";
	        }
			
	    } else {
	        // No se ha subido ningún archivo o hubo un error en la carga
	        $error = "No se ha subido ningún archivo o hubo un error en la carga.";
	    }
	

		// Devuelve la respuesta en formato JSON
		header("Content-type: application/json");

		$jsondata['message'] = $message;
		$jsondata['codigo']  = $codigo;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
		
	}

	function cd_csu_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';
		$html 	  = '';

		$query = "SELECT id,nombre,apellido FROM users 
				  WHERE status = 1;
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			//$html .= "<option value='0'>Selecciona un usuario...</option>";
			while($row = $execute_query->fetch_array()){
				$id 	= $row['id'];
				$nombre = $row['nombre'] . ' ' . $row['apellido'];
				//$html .= "<option value='$id'>$nombre</option>";	
				$data_rows[] = array(
					'id' => $id,
					'nombre' => $nombre
				);
			}
			
		}else{
			$error = 'Error cargando los usuarios de base de datos: '.$conn->error;
		}

		//$jsondata['html'] 		= $html;
		$jsondata['html'] 		= $data_rows;
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function cd_cstdd_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		$query = "SELECT id,tipo_de_documento,siglas FROM tipo_de_documentos 
				  WHERE status = 1;
				 ";
		$execute_query = $conn->query($query);

		if($execute_query){
			while($row = $execute_query->fetch_array()){
				$id 	= $row['id'];
				$nombre = $row['tipo_de_documento'];
				$siglas = $row['siglas'];
				$data_rows[]=array(
					'id' => $id,
					'nombre' => $nombre,
					'siglas' => $siglas
				);
			}
			
		}else{
			$error = 'Error cargando los tipos de documentos de base de datos: '.$conn->error;
		}

		//error_log($html);

		$jsondata['html'] 		= $data_rows;
		$jsondata['message'] 	= $message;
		$jsondata['error']   	= $error;
		echo json_encode($jsondata);
	}

	function cd_cpps_Function() {
		$jsondata 	= array();
		$error 		= '';
		$html 		= '';
		$folder_count = '';

		$dir_var = isset($_POST['directory']) ? $_POST['directory'] : '';

		if ($dir_var == '') {
			$dir = '../../../pages/documents/';
			$html = "<option value='0'>Elige un proceso...</option>";
		} else {
			$dir = '../../../pages/documents/' . $dir_var;
			$html = "<option value='0'>Elige un subproceso...</option>";
		}

		$folders = scandir($dir);

		$principal = $_POST['principal']; 
//error_log("DIR: $dir");
		foreach ($folders as $folder) {
//error_log("folder: $folder Principal: $principal");
			$elementPath = $dir.'/'.$folder;
//error_log($elementPath);

			if (is_dir($elementPath) && $folder !== '.' && $folder !== '..' && $folder <> $principal) {
				$folder_count++;
				$subfolderPath = $dir_var . $folder . '/';
				$html .= '<option value="'.$folder.'">'.$folder.'</option>';
			}
		}

	  //error_log('Contador: '.$folder_count);
		if ($folder_count<1) {
			if ($dir_var == '') {
				$html = "<option>No existen procesos creados...</option>";
			}else{
				$html = "<option>No existen subprocesos creados...</option>";
			}
		}

		$jsondata['html'] = $html;
		$jsondata['error'] = $error;
		echo json_encode($jsondata);
	}

	function coreJS_cbi_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $data = array();

	   	if(isset($_SESSION['rol_id'])){
	   		$rol_id = $_SESSION['rol_id'];
	   		$nombre_usuario = $_SESSION['nombre_u'];

	   		$query = "
		   		SELECT nombre_opcion_privilegio, path, icon 
				FROM opciones_privilegios
				INNER JOIN privilegios p
				ON opciones_privilegios.id_opcion_privilegio = p.id_privilegio
				WHERE p.id_rol = $rol_id
				AND status = 1
				AND nombre_opcion_privilegio <> 'AprobaciÃ³n'
				AND nombre_opcion_privilegio <> 'Documentos externos'
	   		";
//error_log($query);
		    $result = $conn->query($query);

		    if ($result) {
		        while ($row = $result->fetch_assoc()) {
		            $data[] = array(
		                'nombre_opcion_privilegio' => $row['nombre_opcion_privilegio'],
		                'path' => $row['path'],
		                'icon' => $row['icon']
		            );
		        }
		 		$jsondata['un'] = $nombre_usuario;
		    } else {
		        $error = 'Error al cargar los privilegios: ' . $conn->error;
		    }
	   	}else{
	   		$error = 'Necesitas tener acceso, hablar con administración!';
	   	}
	    

	    $jsondata['error'] = $error;
	    $jsondata['data'] = $data;

	    //header('Content-type: application/json');
//error_log(print_r($jsondata,true));
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

	    	$query = "SELECT email,password,nombre,apellido,rol_id,id 
					FROM users
					WHERE email = '$email'
					AND MD5('$pass') = password
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
		            $id 		= $row['id'];

		            $_SESSION['nombre_u'] 	= $nombre . ' ' . $apellido;
		            $_SESSION['rol_id'] 	= $rol_id; 
		            $_SESSION['id_u']		= $id;
		            
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

	    //$query = "SELECT id, nombre, apellido, email, status FROM users";
	    $query = "
	    	SELECT id, nombre, apellido, email, r.nombre_rol, status 
			FROM users u
			INNER JOIN roles r
			ON u.rol_id = r.id_rol

	    ";

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
	            $nombre_rol = $row['nombre_rol'];
	            $status 	= $row['status'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	                'id' 		=> $id,
	                'nombre' 	=> $nombre,
	                'apellido'	=> $apellido,
	                'email'		=> $email,
	                'nombre_rol'=> $nombre_rol,
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

	// SE LEEN LOS DISTINTOS TIPOS DE DOCUMENTOS PARA EL MANTENIMIENTO DE TIPO DE DOCUMENTOS
	function mtdd_ltdl_Function(){
	    global $conn;
	    $jsondata = array();
	    $error = '';
	    $message = '';

	    $query = "SELECT id, tipo_de_documento, status, siglas FROM tipo_de_documentos";

	    // Ejecuta la consulta y verifica si se ejecutó correctamente
	    $execute_query = $conn->query($query);

	    if ($execute_query) {
	        // La consulta se ejecutó con éxito, ahora puedes obtener los resultados
	        $rows = array();
	        while ($row = $execute_query->fetch_array()) {
	            $id = $row['id'];
	            $nombre = $row['tipo_de_documento'];
	            $status = $row['status'];
	            $siglas = $row['siglas'];
	            
	            // Agrega los resultados al arreglo $rows
	            $data_rows[] = array(
	                'id' => $id,
	                'nombre' => $nombre,
	                'status' => $status,
	                'siglas' => $siglas
	            );
	        }

	        // Agrega los resultados al arreglo jsondata
	//error_log(print_r($data_rows,true));
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

	// SE CREA EL TIPO DE DOCUMENTO EN EL MANTENIMIENTO DE TIPO DE DOCUMENTOS
	function mtdd_ctdd_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		if (isset($_POST['nombre'])){
			$nombre = mb_convert_encoding($_POST['nombre'], 'UTF-8', 'auto');
			$siglas = $_POST['siglas'];
			$query = "INSERT INTO tipo_de_documentos (tipo_de_documento,siglas,status) VALUES ('$nombre','$siglas',1)";
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

	function mtdd_etd_Function(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['siglas'])){
			$id = $_POST['id'];
			$nombre = mb_convert_encoding($_POST['nombre'], 'UTF-8', 'auto');
			$siglas = $_POST['siglas'];
			
			$query = "UPDATE tipo_de_documentos SET tipo_de_documento='$nombre', siglas='$siglas' WHERE id='$id'";
			$execute_query = $conn->query($query);

			if ($execute_query) {
	            $message = 'Tipo de documento actualizado correctamente en la base de datos.';
	        } else {
	            $error = 'Error al actualizar el tipo de documento en la base de datos: ' . $conn->error;
	        }
		}else {
	        $error = 'Falta información requerida para la actualización del tipo de documento.';
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
					WHERE op.status = 1
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

	function sddi_bdpk_Function(){
		global $conn;
		$jsondata = array();
		$error = '';
		$data = array();

		if (isset($_POST['keyword'])){
			$keyword = $_POST['keyword'];
			$keyword = '%' . $keyword . '%';
			
			$query = "SELECT id, nombre, codigo FROM documentos 
					  WHERE nombre LIKE ? 
					  AND status = 1
					  ORDER BY nombre 
					  LIMIT 10";
			
			$stmt = $conn->prepare($query);
			$stmt->bind_param("s", $keyword);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$data[] = array(
						'id' => $row['id'],
						'nombre' => $row['nombre'],
						'codigo' => $row['codigo']
					);
				}
				$jsondata['data'] = $data;
			} else {
				$error = 'Error al buscar documentos: ' . $conn->error;
			}
		} else {
			$error = 'Keyword requerido para la búsqueda.';
		}

		$jsondata['error'] = $error;
		echo json_encode($jsondata);
	}

	
  
?>

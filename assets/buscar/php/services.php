
<?php
	session_start();
	date_default_timezone_set('America/Guatemala');
	//require_once('connect.php');


	if(isset($_POST['option'])){
		$option = $_POST['option'];
	
		switch ($option) {
			case 'load_explorer':
				loadExplorerFunction();
				break;
			case 'interactive_search':
				interactiveSearchFunction();
				break;

		}
		
	}

	function nueva(){
		global $conn;
		$jsondata = array();
		$error 	  = '';
		$message  = '';

		#codigo................;

		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

	function interactiveSearchFunction(){
		global $conn;
		$jsondata 		= array();
		$error 	  		= '';
		$message  		= '';
		$search 		= utf8_decode($_POST['b']);
		$files_matrix 	= array();
		$html 			=	'';
//error_log($search);
		$query = "
				SELECT file_name
					,file_path
				FROM documentation
				WHERE file_name LIKE '%$search%'
				LIMIT 18;
			";
//error_log($query);
		/* NO EXISTE BASE DE DATOS AUN
		$execute_query = $conn->query($query);
		while($row = $execute_query->fetch_array()){
			$file_name 		= $row['file_name'];
			$file_path 		= $row['file_path'];
			$download_link = $file_path.$file_name;
			$files_matrix[$file_name] = $download_link;
		}
		*/


/*---------------- START DISPLAY EXPLORER--------------------------*/
		/*
		$html .= "
					<div class=\"row\">
		        <div class=\"col-sm-3 nav-item\">
								<a class=\"nav-link\" href='#' onclick=\"load_explorer('$retorno',1)\">
		           <i class=\"mdi mdi-step-backward menu-icon\"><span class=\"menu-title\">Regresar</span></i>
		            </a>
		        </div>
		      </div>
					";
		*/
				$count = 0;

				foreach ($files_matrix as $key => $value) {
					if($value !== '.' && $value !== '..'){

						if($count ==0){
							$html .= '<div class="row mt-2">';
						}

						if($count <=3){
							/*
							if(file_exists(filename))
							 <img src="..." alt="..." class="img-thumbnail">
							 
							 */
							if (strpos($key, '.png') !== false) {
								   
							}else{
								if (strpos($key, '.') !== false) {
									$file = substr($key, 0,-3);
									$file .= 'png';
									//$file = $value.$file;
									$file = substr($value,1);
									$file = '../../htmls/'.$file;
									$img  = substr($file, 0,-3).'png'; 
									$file = utf8_encode($file);
									$file = substr($file, 0,-3);
									$file .= 'png';
//error_log($file);
	//$img_file = str_replace('../../htmls/', '', $file);
	//$image_line = "<img src=\"$img_file\" alt=\"NO IMAGE\" class=\"img-thumbnail\"><span class=\"menu-title\">$key</span>";
//error_log($image_line);
									if(file_exists($file)){
										$img_file = str_replace('../../htmls/', '', $img);
										$image_line = "<img src=\"$img_file\" alt=\"NO IMAGE\" class=\"img-thumbnail\"><span class=\"menu-title\">$key</span>";
									}else{
										$image_line = "<i class=\" mdi mdi-file-document menu-icon\"><span class=\"menu-title\">$key</span></i>";
									}
								}else{
									$image_line = "<i class=\"mdi mdi-folder-outline menu-icon\"><span class=\"menu-title\">$key</span></i>";
								}
//error_log($image_line);
								if(strpos($value, '.xls') !== false || strpos($value, '.xlsx') !== false || strpos($value, '.doc') !== false || strpos($value, '.docx') !== false || strpos($value, '.pdf') !== false){
									//$download_file = $dir.$value;
									//$download_file = utf8_encode($value);

									//$download_file = str_replace('../../htmls/', '', $download_file);
									//$download_file = str_replace('../../', '', $value);
									$download_file = substr($value, 1);
									$pandora = $download_file;
			//error_log($download_file);
									//$key = utf8_encode($key);
									$html .= "
										<div class=\"col-sm-3 nav-item\">
										<a class=\"nav-link\" href=\"$download_file\" target=\"_blank\" onclick=\"insert_download('$download_file','$key','$value','$pandora');\">
				              <div class=\"card\">
				                <div class=\"card-body\">
				                  $image_line
				                </div>
				              </div>
				            </a>
				             </div>
									";
								}else{
									$html .= "
										<div class=\"col-sm-3 nav-item\">
										<a class=\"nav-link\" onclick=\"load_explorer('$key')\" href='#'>
				              <div class=\"card\">
				                <div class=\"card-body\">
				                  $image_line
				                </div>
				              </div>
				            </a>
				             </div>
									";
								}
								
								$count++;
							}
						}else{
							$count = 0;
							$html .= '</div>';
						}
						
					}
				}
/*---------------- FINISH DISPLAY EXPLORER-------------------------*/

//error_log(print_r($files_matrix,true));
//error_log($html);

		$jsondata['html_eplorer'] 	= utf8_encode($html);
		$jsondata['message'] 		= $message;
		$jsondata['error']   		= $error;
		echo json_encode($jsondata);
	}

	function loadExplorerFunction(){
		global $conn;
		$jsondata 			= array();
		$dir_check 			= array();
		$files_matrix 	= array();
		$dir_sub 				= array();
		$error 	  			= '';
		$message  			= '';
		$html 					= '';
		$retorno 				= '';
		$count 					= 0;
		$flag 					= $_POST['flag'];
		$flag_jpg 			= 'f';
		$img_flag 			= 'f';
		//$rol_id 				= $_SESSION['rol_id'];
		$line_editar 		= '';
		$line_eliminar 	= '';

		
		//unset($_SESSION['exp_path']);
		$dir_var = $_POST['directory'];
		if($dir_var == ''){
			unset($_SESSION['exp_path']);
		}
		if(isset($_SESSION['exp_path'])){
			$dir = $_SESSION['exp_path'];
		}else{
			$dir = "../../htmls/documents/"; 
		}

		if($dir_var != ''){
			if($flag==0){
				$dir .= "$dir_var/";	
			}else{
				if($dir_var!='#'){
					$dir = str_replace($dir_var.'/', '', $dir);
				}
			}
			
		}
//error_log("directory: $dir");
		$retorno_partes = explode('/', $dir);
//error_log(print_r($retorno_partes,TRUE));
		array_pop($retorno_partes); 
//error_log(print_r($retorno_partes,TRUE));

		//$r = $retorno_partes[count($retorno_partes)-1];
//error_log("result: $r");

			$r = $retorno_partes[count($retorno_partes)-1];
			if($r == 'documents'){
				$dir = "../../../pages/documents/"; 
				$retorno = "#";
			}else{
				$retorno = $r;
			}

		$_SESSION['exp_path'] = $dir;

//error_log("RETORNO: $retorno");
		$data = scandir($dir);
//error_log(print_r($data,true));
		$count = 0;

		$html .= "
			<div class=\"row\">
        <div class=\"col-sm-3 nav-item\">
						<a class=\"nav-link\" href='#' onclick=\"load_explorer('$retorno',1)\">
           <i class=\"mdi mdi-step-backward menu-icon\"><span class=\"menu-title\">Regresar</span></i>
            </a>
        </div>
      </div>
			";
		
		foreach ($data as $key => $value) {

			if($value !== '.' && $value !== '..' && $value !== '1234' && $value !== '12345' && $value !== 'Thumbs.db'){

				if($count == 0){
					$html .= '<div class="row mt-2">';
				}
				
				if($count < 10000){
//error_log($count);
				$count++;

					/*
					if(file_exists(filename))
					 <img src="..." alt="..." class="img-thumbnail">
					 
					 */
					if (strpos($value, '.png') !== false ) {

					}else{
						$evaluar = strpos($value, '.jpg');
//error_log('evaluar'.$evaluar.'valor: '.$value);
							
						if (strpos($value, '.') !== false) {
							$file = substr($value, 0,-3);
							$file .= 'png';
							$file = $dir.$file;
							//$file = substr($file, 0,12);
							//$file = str_replace('../../htmls/', '', $file);
//error_log("FILE EXPLORER: $file");
							if(file_exists($file)){
								$img_file = str_replace('../../htmls/', '', $file);
								$image_line = "<img src=\"$img_file\" alt=\"NO IMAGE\" class=\"img-thumbnail\"><span class=\"menu-title\">$value</span>";
								$img_flag = 't';
							}else{
								$image_line = "<i class=\" mdi mdi-file-document menu-icon\"><span class=\"menu-title\">$value</span></i>";
								$img_flag = 't';
							}
						}else{
							/*error_log("FLAG: $flag_jpg");
							if($flag_jpg=='f'){*/
								$image_line = "<i class=\"far fa-folder\"><span class=\"menu-title\">$value</span></i>";
							/*}*/

							
						}

						if(strpos($value, '.jpg') == true){
//error_log('valor'.$value);
								$src = $dir.$value;
								$src = str_replace('../../htmls/', '', $src);
								$label = "Unicamente en versión física $value";
						   	$image_line = "<img src=\"$src\" alt=\"NO IMAGE\" class=\"img-thumbnail\"><span class=\"menu-title\">$label</span>";
						   	$flag_jpg = 't';
						   }
//error_log("bandera $flag_jpg");

						//error_log($image_line);





						if(strpos($value, '.xls') !== false || strpos($value, '.xlsx') !== false || strpos($value, '.doc') !== false || strpos($value, '.docx') !== false || strpos($value, '.pdf') !== false || strpos($value, '.PDF') !== false){
							$download_file = $dir.$value;
//error_log($download_file);
							$download_file = str_replace('../../htmls/', '', $download_file);
//error_log($download_file);
							#$pandora = $download_file;
							$pandora = str_replace('../', '', $download_file);
							$pandora = str_replace('pages/', '', $pandora);
//error_log($pandora);
							/*if($img_flag=='t' && $rol_id ==1){
								$img_flag='f';
								$line_editar = "<a href=\"\" onclick=\"load_editar('$download_file','$value')\">EDITAR<a>";
								$line_eliminar = "<a href=\"\" onclick=\"load_eliminar('$download_file','$value')\">ELIMINAR<a>";
							}*/
							$html .= "
								<div class=\"col-sm-3 nav-item\">
								<div class=\"row\">
									<div class=\"col\">
										$line_editar 
									</div>
									<div class=\"col\">
										$line_eliminar
									</div>
								</div>
								
								<!--<a class=\"nav-link\" href=\"$download_file\" target=\"_blank\" onclick=\"insert_download('$download_file','$value','$dir','$pandora');\">-->
								<a class=\"nav-link\" href=\"$pandora\" target=\"_blank\" onclick=\"insert_download('$download_file','$value','$dir','$pandora');\">
		              <div class=\"card\">
		                <div class=\"card-body\">
		                  $image_line
		                </div>
		              </div>
		            </a>
		            	
		             </div>

							";
						}else{
							$html .= "
								<div class=\"col-sm-3 nav-item\">
								<a class=\"nav-link\" onclick=\"load_explorer('$value')\" href='#'>
		              <div class=\"card\">
		                <div class=\"card-body\">
		                  $image_line
		                </div>
		              </div>
		            </a>
		             </div>
							";
						}
						
						
					}
					
				}else{
					$count = 0;
					$html .= '</div>';
				}
				
			}
		}

//error_log($html);

/*
		foreach ($dir_sub as $key => $value) {
				$data_sub = scandir($value);
				//error_log(print_r($data_sub,true));
			}
*/
//error_log(print_r($dir_sub,true));
//error_log(print_r($files_matrix,true));
//error_log($html);
		$jsondata['retorno'] = $retorno;
		$jsondata['html']		= $html;
		$jsondata['message'] = $message;
		$jsondata['error']   = $error;
		echo json_encode($jsondata);
	}

  
?>

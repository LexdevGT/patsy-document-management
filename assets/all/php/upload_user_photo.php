<?php
	session_start();
//error_log('INICIANDO....');
	date_default_timezone_set('America/Guatemala');
	require_once('connect.php');
if (isset($_FILES['foto']) || isset($_FILES['firma'])) {

	if (isset($_FILES['foto'])){
		$flag = 'foto';
	}else{
		$flag = 'firma';
	}


	$countfiles = count($_FILES[$flag]['name']);
//error_log('count: '.$countfiles);
	$upload_location = '../images/users/';
//error_log($_SESSION['rol_id']);
	$u 	= $_SESSION['nombre_u'];
	$id = $_SESSION['rol_id'];
	if(isset($_POST['email'])){
		$e = $_POST['email'];
		$o = $_POST['option'];
	}
//error_log($e);
	
//error_log("EL ID: $id USER: $u");
//error_log(print_r($_POST,true));

	// To store uploaded files path
	$files_arr = array();

	// Loop all files
	for($index = 0;$index < $countfiles;$index++){
//error_log('Entramos al FOR');
	   // File name
	  $filename = $_FILES[$flag]['name'][$index];
//error_log($filename);
	   // Get extension
	   $ext = pathinfo($filename, PATHINFO_EXTENSION);
	   $new_name = str_replace('.com', '_', $e).'_'.$o.time().'.'.$ext;
	   // Valid image extension
	   $valid_ext = array("png","jpg","gif","jpeg");

	   // Check extension
	   if(in_array($ext,$valid_ext)){
//error_log('Pasamos el validador de extencion');
	     // File path
	     //$path = $upload_location.$filename;
	   	$path = $upload_location.$new_name;
//error_log($path);
	     // Upload file
		     if(move_uploaded_file($_FILES[$flag]['tmp_name'][$index],$path)){
		        $files_arr[] = $path;
		        $query = "
							UPDATE users
							SET $flag = '$new_name'
							WHERE email = '$e'
					   ";
					   error_log($query);
		        $conn->query($query);
				echo "Foto guardada!";
		     }
		}
	}
}else{
	//error_log('No entro en el IF');
	echo "No files";

}
?>

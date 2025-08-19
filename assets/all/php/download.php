<?php

	if (isset($_POST['fileName'])) {
	    $fileName = $_POST['fileName'];
	    $folder = $_POST['folderName'];
	    $filePath = "../../../pages/$folder/";

	    $nuevaCadena = str_replace($filePath,'',$fileName);
	
	   	error_log("FilePath: $fileName");

	    if (file_exists($fileName)) {
	        // Establecer las cabeceras para forzar la descarga
	        header('Content-Description: File Transfer');
	        header('Content-Type: application/octet-stream');
	        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
	        header('Expires: 0');
	        header('Cache-Control: must-revalidate');
	        header('Pragma: public');
	        header('Content-Length: ' . filesize($fileName));
	        readfile($fileName);
	        exit;
	    } else {
	        $jsondata['error'] = 'El archivo no existe.';
	    }
	} else {
	    $jsondata['error'] = 'No se proporcionó el nombre del archivo.';
	}

	echo json_encode($jsondata);
?>

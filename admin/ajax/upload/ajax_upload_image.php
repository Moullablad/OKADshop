<?php
    $img_name = substr(time(), 0,10).".jpg";
 	$dst = '../../../files/blog/';
 	if (isset($_POST['dir'])) {
 		$dst = $_POST['dir'];
 	}
 

 	if (strpos( $dst,"cover")){
 		$resultat = move_uploaded_file($_FILES['image']['tmp_name'],$dst.$img_name);
 	}
 	else{
 		$resultat = move_uploaded_file($_FILES['image']['tmp_name'][0],$dst.$img_name);
 	}
	if ($resultat) echo json_encode($img_name);
	else echo json_encode("0");
?>
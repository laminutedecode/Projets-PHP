<?php


require_once('cnx.php');


if(isset($_POST['create'])) {


$name = mysqli_real_escape_string($cnx, $_POST['nameUser']);
$email = mysqli_real_escape_string($cnx, $_POST['mailUser']);
$password = mysqli_real_escape_string($cnx, $_POST['passwordUser']);
$cpassword = mysqli_real_escape_string($cnx, $_POST['comfirmPasswordUser']);
$image = $_FILES['imageUser']['name'];
$image_size = $_FILES['imageUser']['size'];
$image_tmp_name = $_FILES['imageUser']['tmp_name'];
$image_folder = 'uploaded_img/'.$image;

$select = mysqli_query($cnx, "SELECT * FROM `user_form` WHERE mailUser = '$email' AND  passwordUser = '$password' ") or die('query failed');

if(mysqli_num_rows($select) > 0){
    $message[] = "L'utilisateur existe deja";
}else {
    if($password != $cpassword){
        $message[] = 'Les mots de passe de sont pas identique';
    }elseif ($image_size > 2000000){
        $message[] = "L'image est trop large";
    }else {
        $insert = mysqli_query($cnx, "INSERT INTO `user_form`(nameUser, mailUser, passwordUser, imageUser) VALUES ('$name','$email','$password', '$image') ") or die ('query failed');

        if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = "Inscription confirmé avec succès";
            header('location:profil.php');
        }else {
            
            $message[] = "Echec de l'inscription";
        }
}

}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>

<div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Inscription</h3>
        <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
        <input type="text" placeholder="Indiquez votre login" name="nameUser" class="box" required>
        <input type="mail" placeholder="Indiquez votre mail" name="mailUser" class="box" required>
        <input type="password" placeholder="Indiquez un mot de passe" name="passwordUser" class="box" required>
        <input type="password" placeholder="Comfirmer le mot de passe" name="comfirmPasswordUser" class="box" required>
        <input type="file" name="imageUser"  class="box" accept="image/jpg, image/jpeg, image/png">
        <input type="submit" name="create" value="S'inscrire" class="btn">
        <p>Vous avez deja un compte ? <a href="connexion.php">Connectez vous</a></p>


    </form>
</div>
    
</body>
</html>
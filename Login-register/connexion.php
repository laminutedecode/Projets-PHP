<?php


require_once('cnx.php');



session_start();

if(isset($_POST['connexion'])) {


$email = mysqli_real_escape_string($cnx, $_POST['mailUser']);
$password = mysqli_real_escape_string($cnx, $_POST['passwordUser']);


$select = mysqli_query($cnx, "SELECT * FROM `user_form` WHERE mailUser = '$email' AND  passwordUser = '$password' ") or die('query failed');

if(mysqli_num_rows($select) > 0){
    $row = mysqli_fetch_assoc($select);
    $_SESSION['userId'] = $row['userId'];
    header('location:profil.php');
}else {
    $message[] = "Email ou mot de passe incorrect";
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body>

<div class="form-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Connexion</h3>
        <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
        <input type="mail" placeholder="Indiquez votre mail" name="mailUser" class="box" required>
        <input type="password" placeholder="Indiquez un mot de passe" name="passwordUser" class="box" required>
        <input type="submit" name="connexion" value="Connexion" class="btn">
        <p>Vous n'avez pas de compte ? <a href="inscription.php">Inscrivez-vous</a></p>


    </form>
</div>
    
</body>
</html>
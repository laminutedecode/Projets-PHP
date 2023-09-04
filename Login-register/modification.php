<?php

include 'cnx.php';
session_start();
$user_id =  $_SESSION['userId'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($cnx, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($cnx, $_POST['update_email']);

   mysqli_query($cnx, "UPDATE `user_form` SET nameUser = '$update_name', mailUser = '$update_email' WHERE userId = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($cnx, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($cnx, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($cnx, md5($_POST['confirm_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         // $message[] = 'Les mots de passe ne correspond pas';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'Les mots de passe ne correspond pas';
      }else{
         mysqli_query($cnx, "UPDATE `user_form` SET passwordUser = '$confirm_pass' WHERE userId = '$user_id'") or die('query failed');
         $message[] = 'Modification(s) réussit!';
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'Image trop large';
      }else{
         $image_update_query = mysqli_query($cnx, "UPDATE `user_form` SET imageUser = '$update_image' WHERE userId = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image télégargé avec succès!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">

   <?php
      $select = mysqli_query($cnx, "SELECT * FROM `user_form` WHERE userId = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

  <div class="content modif">
    
  <form class="formPro" action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['imageUser'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['imageUser'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
     

            <span>Modifier le login :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['nameUser']; ?>" class="box">
            <span>Modifier l'email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['mailUser']; ?>" class="box">
            <span>Modifier l'image :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['passwordUser']; ?>">
            <span>Ancien mot de passe :</span>
            <input type="password" name="update_pass" placeholder="Entrez le mot de passe actuel" class="box">
            <span>Nouveau mot de passe :</span>
            <input type="password" name="new_pass" placeholder="Entrez votre nouveau mot de passe" class="box">
            <span>Comfirmer le nouveau mot de passe :</span>
            <input type="password" name="confirm_pass" placeholder="Comfirmer le nouveau mot de passe" class="box">

      <div class="btns">
      <input type="submit" value="Modifier le profil" name="update_profile" class="btn">
      <a href="profil.php" class="delete-btn">Retour</a>
      </div>
   </form>
  </div>


         

</div>

</body>
</html>
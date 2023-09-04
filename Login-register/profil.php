<?php

require_once('cnx.php');

session_start();


$user_id =  $_SESSION['userId'];

if(!isset($user_id)){
    header('location:connexion.php');
}

if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header('location:connexion.php');
 }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Profil</title>
</head>
<body>

<div class="container">
    <div class="content">
        <?php

        $select = mysqli_query($cnx, "SELECT * FROM `user_form` WHERE userId = '$user_id'") or die('query failed');

        if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['imageUser'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['imageUser'].'">';
         }
        ?>
        <h3> <?= $fetch['nameUser']?></h3>

         <div class="btns">
         <a href="modification.php" class="btn">Modifier profil</a>
         <a href="connexion.php?logout=<?php echo $user_id; ?>" class="delete-btn">Deconnexion</a>
         </div>

    </div>
</div>
    
</body>
</html>
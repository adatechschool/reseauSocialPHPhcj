<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Flux</title>         
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
      
        <?php 

        include('header.php');
       
        //session_destroy sert à detruire la session  
        session_destroy(); ?> 
        <div id="wrapper">
        <?php
         header("Location: admin.php");   
     
        include('fonctions.php');
       ?>
        </div>

    </body>
</html>





<?php
function echecRequete(){
    $lesInformations = $mysqli->query($laQuestionEnSql);
    // Vérification
    if ( ! $lesInformations)
    {
        echo("Échec de la requete : " . $mysqli->error);
        exit();
    }
}
?>
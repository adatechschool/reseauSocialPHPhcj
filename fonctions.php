<?php
function echecRequete($mysqli,$laQuestionEnSql){
    global $lesInformations;
    $lesInformations = $mysqli->query($laQuestionEnSql);
    // Vérification
    if ( ! $lesInformations)
    {
        echo("Échec de la requete : " . $mysqli->error);
        exit();
    }
    return $lesInformations;
}
?>
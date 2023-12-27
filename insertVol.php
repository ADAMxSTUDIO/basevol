<?php
require_once("connexion.ini.php");
if(isset($_REQUEST["submit"])){
    if(isset($_REQUEST["depart"]) && isset($_REQUEST["arrive"]) && isset($_REQUEST["Datedepart"]) && isset($_REQUEST["Heuredepart"])){
        extract($_REQUEST);
        // $connexion->prepare("ALTER TABLE vols NOCHECK CONSTRAINT FK_AeroportAv;")->execute();
        // $connexion->prepare("ALTER TABLE vols NOCHECK CONSTRAINT FK_AeroportDT;")->execute();
        // $connexion->prepare("ALTER TABLE vols NOCHECK CONSTRAINT FK_Avions;")->execute();
        // $connexion->prepare("ALTER TABLE vols NOCHECK CONSTRAINT ALL")->execute();
        $reqInsertVol = $connexion->prepare("INSERT INTO vols (aeroportDepart, aeroportArrive, dateDepart, heureDepart,idavion) VALUES (?, ?, ?, ?,?)");
        if($reqInsertVol->execute([$depart, $arrive, $Datedepart, $Heuredepart,1])){
        // $reqVolDepart = "INSERT INTO aeroport (nomAeroport) VALUES (?)";
        // $reqVolArrive = "INSERT INTO aeroport (nomAeroport) VALUES (?)";
        // $reqDate = "INSERT INTO vols (dateDepart) VALUES (?)";
        // $reqHeure = "INSERT INTO vols (heureDepart) VALUES (?)";
        // if($connexion->prepare($reqVolDepart)){
            echo '<script> alert("Nouveau Vol entre avec succes !"); </script>';
        }
        else{
            echo '<script> alert("Erreur, re-entrer le vol a nouveau !"); </script>';
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
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.css">
    <title>Add Flight</title>
</head>
<body>
    <div class="container-fluid">
        <h1 class="text-warning">Veuillez saisir un nouveau vol </h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="depart" class="form-label text-primary">Aeroport de Depart :</label>
                <input type="text" name="depart" id="depart" class="form-control" placeholer="Rabat" required value="<?php @$depart ?>"/>
            </div>
            <div class="form-group">
                <label for="arrive" class="form-label text-primary">Aeroport de Arrive :</label>
                <input type="text" name="arrive" id="arrive" class="form-control" placeholer="Fez" required value="<?php @$arrive ?>"/>
            </div>
            <div class="form-group">
                <label for="Datedepart" class="form-label text-primary">Date de Depart :</label>
                <input type="date" name="Datedepart" id="Datedepart" class="form-control" required value="<?php @$Datedepart ?>"/>
            </div>
            <div class="form-group">
                <label for="Heuredepart" class="form-label text-primary">Heure de Depart :</label>
                <input type="int" name="Heuredepart" id="Heuredepart" class="form-control" required value="<?php @$Heuredepart ?>"/>
            </div>
            <button class="btn btn-primary mt-2" type="submit" name="submit">Valider</button>
            <button class="btn btn-danger mt-2" type="reset">Ressayer</button>
        </form>
        <a href="DetailsPlane.php?id=<?php echo $_GET["id"]?>" class="link-danger"><< Revoire les vols accomplis</a>
    </div>      
</body>
</html>
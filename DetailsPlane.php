<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airplanes Details</title>
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.css">
</head>
<body>
    <?php require_once("connexion.ini.php"); 
    extract($_GET)?>
    <div class="container-fluid">
        <?php $req = $connexion->prepare("SELECT * FROM avions WHERE idAvion =" . $_GET["id"]);
              $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $req->execute();
              $tabAvion = $req->fetchAll()  ?>
        <h1 class="justify-content-center">Avion <strong class="text-success"><?php echo $tabAvion[0]["nomAvion"]; ?></strong></h1>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Numero vol</th>
                    <th>Aeroport Depart</th>
                    <th>Aeroport Arrive</th>
                    <th>Escale(s)</th>
                </tr>
            </thead>
            <tbody class="tbody-ligth">
                <?php 
                $reqAvionstDepart = $connexion->prepare("SELECT * FROM avions INNER JOIN vols ON avions.idAvion = vols.idAvion INNER JOIN aeroport ON vols.aeroportDepart = aeroport.idAeroport WHERE avions.idAvion =" . $_GET["id"]);
                $reqAvionstArrive = $connexion->prepare("SELECT * FROM avions INNER JOIN vols ON avions.idAvion = vols.idAvion INNER JOIN aeroport ON vols.aeroportArrive = aeroport.idAeroport WHERE avions.idAvion =" . $_GET["id"]);
               
            
                $reqAvionstDepart->execute();
                $reqAvionstArrive->execute();
                
                $AvionstDepart = $reqAvionstDepart->fetchAll();
                $AvionstArrive = $reqAvionstArrive->fetchAll();
                ?>
                
                <?php
                    for($i=0;$i<count($AvionstDepart);$i++){
                        $reqAvionsEscales = $connexion->prepare("SELECT * FROM avions INNER JOIN vols ON avions.idAvion = vols.idAvion and vols.idvol=".$AvionstDepart[$i]["idVol"]." INNER JOIN escales ON vols.idVol = escales.idVol INNER JOIN aeroport ON escales.idAeroport = aeroport.idAeroport WHERE avions.idAvion =" . $_GET["id"]);
                        $reqAvionsEscales->execute();
                        $AvionsEscales = $reqAvionsEscales->fetchAll();
        
                ?>
                <tr>
                    <td><?= @$AvionstDepart[$i]["idVol"]; ?></td>
                    <td><?= @$AvionstDepart[$i]["nomAeroport"]; ?></td>
                    <td><?= @$AvionstArrive[$i]["nomAeroport"]; ?></td>
                    <?php
                    $escalesTab = [];
                    for($e=0;$e<count($AvionsEscales);$e++){
                        $escalesTab[] = $AvionsEscales[$e]["nomAeroport"];} ?>
                    <td><?= @implode(",", $escalesTab);?></td>
                </tr> 
                <?php }?>
            </tbody>
        </table>
        <a class="link-danger" href="viewPlane.php"><< Revoir les avions</a><br>
        <a href="insertVol.php?id=<?= $id?>" class="link-primary">>> Saisir des nouvaux vols</a>
    </div>
</body>
</html>
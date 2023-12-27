<?php
require_once("connexion.ini.php");

if(isset($_REQUEST["submit"])){
    $erreur = "";
    extract($_REQUEST);
    if(isset($_FILES["pic"])){
        $photo = $_FILES["pic"];
        $info = pathinfo($photo["name"]);
        if(!$photo["error"]&$photo["size"]<2000000){
            $ExtensionAutorisee = ["jpg", "png", "jpeg", "gif"];
            if(in_array(strtolower($info["extension"]),$ExtensionAutorisee)){
                if(!file_exists("AvionImg")){
                    mkdir("AvionImg");
                }
                $path = "AvionImg/".$info["basename"];
                move_uploaded_file($photo["tmp_name"],$path);
                $verify = $connexion->prepare("SELECT * FROM avions WHERE categorieAvion = ? AND nomAvion = ? AND nombrePlace = ? AND photo = ?");
                $result = $verify->execute([$cat, $nom, $num, $path]);
                $tab = $verify->fetchAll() ; 
                // for($i=0;$i<count($tab);$i++){  
                if(count($tab)>0){
                    // $tab[$i]["categorieAvion"] == $cat & $tab[$i]["nomAvion"] == $nom & $tab[$i]["nombrePlace"] == $num & $tab[$i]["photo"] == $path
                    $erreur.= "Erreur, les infos d'avion entrees existent deja !";
                }
                else{
                    $insert = $connexion->prepare("INSERT INTO avions(categorieAvion,nomAvion,nombrePlace,photo) VALUES(?,?,?,?)");
                    $insert->execute([$cat,$nom,$num,$path]);
                    $verify = $connexion->prepare("SELECT * FROM avions WHERE categorieAvion = ? AND nomAvion = ? AND nombrePlace = ? AND photo = ?");
                    $result = $verify->execute([$cat, $nom, $num, $path]);
                    $tab = $verify->fetchAll() ; 
                    ?>
                    <script>
                        alert("Avion <?=$tab[0]["idAvion"]  ?> ajoutee avec succes !");
                    </script>
                    <?php
                }
            }
            else{
                $erreur.= "Erreur, le type photo d'avion choisie n'est pas autorisee !";
            }
        }
        else{
            $erreur.= "Erreur, la photo d'avion choisie depasse 2Mo !";
        }
    }
    if(!empty($erreur))
        ?>
        <script>
            alert("<?php echo $erreur; ?>");
        </script>
        <?php 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de vols</title>
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.css">
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="script.js"></script>
    <style>
        form{
            padding:8em;
        }
        input{
            margin: 0.4em 0;
        }
        button{
            margin-top: 0.2em;
        }
    </style>
</head>
<body class="bg-warning">
    <div class="container-fluid">
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
            <h1 class="text-light">Bienvenue a l'aeroport de <span class="text-success">Marrackech</span></h1>
            <fieldset>
                <legend>Entrer les informations d'avion !</legend>
                <div class="form-group">
                    <label for="nom" class="text-danger">Nom d'avion :</label>
                    <input type="text" class="form-control" name="nom" id="nom" placeholder="boeing 737-800" autofocus maxlength="15" onblur="BluredzoneSelection(this)" onfocus="zoneSelection(this)" value="<?=@$nom; ?>"/>
                </div>
                <div class="form-group">
                    <label for="cat" class="text-danger">Categorie d'avion :</label>
                    <input type="text" class="form-control" name="cat" id="cat" placeholder="Classe Affaire" maxlength="15" onblur="BluredzoneSelection(this)" onfocus="zoneSelection(this)" value="<?=@$cat; ?>"/>
                </div>
                <div class="form-group">
                    <label for="num" class="text-danger">Nombre de place :</label>
                    <input type="number" class="form-control" name="num" id="num" placeholder="220" maxlength="15" onblur="BluredzoneSelection(this)" onfocus="zoneSelection(this)" value="<?=@$num; ?>"/>
                </div>
                <div class="form-group">
                    <label for="pic" class="text-danger">Photo d'avion :</label>
                    <input type="file" class="form-control" name="pic" id="pic" accept="image/*" value="<?=@$_FILES["pic"]; ?>"/>
                </div>
                <input type="submit" class="btn btn-primary"  name="submit" value="Valider" onclick="return nbPlace()"/> 
                <!-- onsubmit="nbPlace()" !-->
                <button type="reset" class="btn btn-danger">Effacer Tout</button>
            </fieldset>
            <a href="viewPlane.php" class="link-primary">>> Voir les avions disponibles !</a>
        </form>
</body>
</html>
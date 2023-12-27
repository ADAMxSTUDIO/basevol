<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airpalnes Overview</title>
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.css">
    <style>
        form,table{
            padding:8em;
        }
        input{
            margin: 0.4em 0;
        }
        button{
            margin-top: 0.2em;
        }
        img{
            width: 350px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <form action="#">
            <div class="form-group">
                <label for="entery">Filtrer les avions par :</label>
                <input type="text" name="entery" id="entery" class="form-control" />
                <input type="submit" name="num" value="Nombre place min" class="btn btn-primary" />
                <input type="submit" name="asc" value="ordre id asc" class="btn btn-warning" />
                <input type="submit" name="desc" value="ordre id desc" class="btn btn-danger" />
                <input type="submit" name="nom" value="nom d'avion" class="btn btn-success" />
                <input type="submit" name="all" value="voir tous" class="btn btn-secondary" />
            </div>
        </form>
        <table class="table"> 
            <thead class="thead-dark bg-dark text-light">
                <tr>
                    <th scope="col">Photo d'avion</th>
                    <th scope="col">Nom d'avion</th>
                    <th scope="col">Numero d'avion</th>
                    <th scope="col">Numero de place</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require_once("connexion.ini.php");
                    if(isset($_REQUEST["num"])){
                        $entery = $_REQUEST["entery"]; // extract($_REQUEST);
                        $filtre = $connexion->prepare("SELECT * FROM avions WHERE nombrePlace <= " . $entery);
                    }
                    else if(isset($_REQUEST["asc"])){
                        $filtre = $connexion->prepare("SELECT * FROM avions ORDER BY idAvion");
                    }
                    else if(isset($_REQUEST["desc"])){
                        $filtre = $connexion->prepare("SELECT * FROM avions ORDER BY idAvion DESC");
                    }
                    else if(isset($_REQUEST["nom"])){
                        $entery = $_REQUEST["entery"];
                        $filtre = $connexion->prepare("SELECT * FROM avions WHERE nomAvion LIKE '%" . $entery . "%'");
                    }
                    else{
                        $filtre = $query;
                    }
                    $filtre->execute();
                    $tab = $filtre->fetchAll();
                    
                    for($i=0;$i<count($tab);$i++){
                        echo "<tr>
                                <td scope=\"row\"><a href=\"DetailsPlane.php?id=".$tab[$i]["idAvion"]."\"><img src=\"" . $tab[$i]["photo"] . "\" alt=\"airplane photo\" class=\"img-fluid rounded\"></a></td>
                                <td scope=\"row\">" . $tab[$i]["nomAvion"] . "</td>
                                <td scope=\"row\">" . $tab[$i]["idAvion"] . "</td>
                                <td scope=\"row\">" . $tab[$i]["nombrePlace"] . "</td>
                            </tr>";
                    }
                ?>
            </tbody>
        </table>
        <a href="index.php" class="link-danger"><< Re-entrer une nouvelle avion !</a>
    </div>
</body>
</html>
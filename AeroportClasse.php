<?php
class Aeroport{
    private $NomAeroport ;
    private $Latitude ;
    private $Longitude ;
    public function __construct($NomAeroport,$Latitude,$Longitude){
        $this->NomAeroport = $NomAeroport;
        $this->Latitude = $Latitude;
        $this->Longitude = $Longitude;
    }
    public function getlatitude(){
        return $this->Latitude;
    }
    public function getLongitude(){
        return $this->Longitude;
    }
    public function setLatitude($L){
        $this->Latitude = $L;
    }
    public function setLongitude($l){
        $this->Longitude = $l;
    }
    public function distance(Aeroport $obj ){
        $d = acos(sin($this->Latitude)*sin($obj->Latitude)+cos($this->Latitude)*cos($obj->Latitude)*cos($this->Longitude-$obj->Longitude));
        $d = $d*6371;
        return round($d,4);
    }
}
$Rabat = new Aeroport("Rabat", 34.036182, -6.748793);
$Casablanca = new Aeroport("Casablanca", 34.076182, -7.248793);

echo "La distance entre Rabat et Casablanca : " . $Rabat->distance($Casablanca);
?>
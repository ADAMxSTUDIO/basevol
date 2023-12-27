function nbPlace(){
    var FiltredInput = parseFloat(document.getElementById("num").value);
    if(FiltredInput<=200 || FiltredInput>=300){
        alert("Nombre de place doit etre entre 200 et 300 !");
        return false;
    }
}
function zoneSelection(input){
    input.style = "color:#eee;"
}
function BluredzoneSelection(input){
    input.style = "color:blue;"
}

<?php
//kapcsolódás a db-hez.
function getDb(){
    $link=mysqli_connect("localhost","root","")
            or die("Connnection error: ". mysqli_error());
    mysqli_select_db($link,"webshop");
    mysqli_query($link,"set character_set_results='utf8'");
    mysqli_query($link,"set character_set_clients='utf8'");
    mysqli_query($link,"set character_set_clients='utf8_general_ci'");
    
    return $link;
}
function closeDb($link){
    mysqli_close($link);
}
?>
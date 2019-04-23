<?php
include 'webshop.php';
$link=getDb();
//módosítás:
//mysqli_real_escape_stringel-- az SQL injection-ellen védekezünk
$successful_delete=false;
$successful_update=false;
if(isset($_POST['update'])){
    $id=mysqli_real_escape_string($link,$_POST['id']);
    $vezeteknev=mysqli_real_escape_string($link,$_POST['vezeteknev']);
    $keresztnev=mysqli_real_escape_string($link,$_POST['keresztnev']);
    $lakcim=mysqli_real_escape_string($link,$_POST['lakcim']);
    $kartyaszam=mysqli_real_escape_string($link,$_POST['kartyaszam']);

    $query=sprintf("UPDATE vevo 
                    SET vezeteknev='%s', keresztnev='%s', lakcim='%s', kartyaszam='%s'
                    WHERE id=%s",
                    $vezeteknev,$keresztnev,$lakcim,$kartyaszam,$id);
    
    mysqli_query($link,$query) or die(mysqli_error($link));
    $successful_update=true;
   // header("Location: termek.php");
    //return;
}
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="webshop.css">
    <title>Webshop</title>
</head>
<body>
    <?php include 'navbar.html'; ?>
    <div class="container main-content">
    <?php
            if (!isset($_GET['vevoid'])) {
                header("Location: vevo.php");
                return;
            } 
            $vevoid = $_GET['vevoid'];
            $query = sprintf("SELECT id, vezeteknev, keresztnev, lakcim, kartyaszam FROM vevo where id = %s", 
                mysqli_real_escape_string($link, $vevoid)) or die(mysqli_error($link));
            $eredmeny = mysqli_query($link, $query);
            $row = mysqli_fetch_array($eredmeny);
            if (!$row) {
                header("Location: vevo.php");
                return;
            }
        ?>
     <h1>Vevő adatainak módósítása</h1>
        <?php if ($successful_update): ?>
        <p>
            <span class="badge badge-success">Vásárló adatai sikeresen módosítva</span>
            <a class="btn btn-success btn-sm" href="vevo.php">
                                <i class="fa fa-edit"></i> Vissza a vevőkhöz
                            </a>
        </p>
        <?php endif; ?>
        
     

        <form method="post" action="">
            <input type="hidden" name="id" id="id" value="<?=$vevoid?>" />
            <div class="form-group">
                <label for="vezeteknev">Vezetéknév</label>
                <input class="form-control" name="vezeteknev" id="vezeteknev" type="text" value="<?=$row['vezeteknev']?>" />
            </div>
            <div class="form-group">
                <label for="keresztnev">Keresztnév</label>
                <input required class="form-control" name="keresztnev" id="keresztnev" type="text" value="<?=$row['keresztnev']?>" />
            </div>
            <div class="form-group">
                <label for="lakcim">Lakcím</label>
                <input class="form-control" name="lakcim" id="lakcim" type="text" value="<?=$row['lakcim']?>" />
            </div>
             <div class="form-group">
                <label for="kartyaszam">Kártyaszám</label>
                <input class="form-control" data-bind="value:replyNumber" min='1000000000000000' max='9999999999999999'name="kartyaszam" id="kartyaszam" type="text" value="<?=$row['kartyaszam']?>" />
            </div>
            <input class="btn btn-success" name="update" type="submit" value="Mentés" />
        </form>

        <?php
            closeDb($link);
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</body>
</html>
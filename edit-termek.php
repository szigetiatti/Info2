<?php
include 'webshop.php';
$link=getDb();
//módosítás:
//mysqli_real_escape_stringel-- az SQL injection-ellen védekezünk

$successful_update=false;
if(isset($_POST['update'])){
    $id=mysqli_real_escape_string($link,$_POST['id']);
    $nev=mysqli_real_escape_string($link,$_POST['nev']);
    $ar=mysqli_real_escape_string($link,$_POST['ar']);
    $darabszam=mysqli_real_escape_string($link,$_POST['darabszam']);
    $gyarto=mysqli_real_escape_string($link,$_POST['gyarto']);
    $leiras=mysqli_real_escape_string($link,$_POST['leiras']);

    $query=sprintf("UPDATE termek 
                    SET nev='%s', ar='%s', darabszam='%s', gyarto='%s', leiras='%s'
                    WHERE id='%s",
                    $nev,$ar,$darabszam,$gyarto,$leiras,$id);
    
    mysqli_query($link,$query) or die(mysqli_error($link));
    $successful_update=true;
}
else if(isset($_POST['delete'])){
    $query1=sprintf('DELETE FROM megvasarolt WHERE termekid=%s',
                mysqli_real_escape_string($link,$_POST['id']));    
    $query2=sprintf('DELETE FROM termek WHERE id=%s',
                mysqli_real_escape_string($link,$_POST['id']));
    $ret1=mysqli_query($link,$query1) or die(mysqli_error($link));
    $ret2=mysqli_query($link,$query2) or die(mysqli_error($link));
    
    //visszatérünk az oldalra ahonnan eljöttünk- termek.php
    header("Location: termek.php");
    return;
}
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="webshop.css">
    <title>Webshop</title>
</head>
<body>
    <?php include 'navbar.html'; ?>
    <div class="container main-content">
    <?php
            if (!isset($_GET['termekid'])) {
                header("Location: termek.php");
                return;
            } 
            $termekid = $_GET['termekid'];
            $query = sprintf("SELECT id, nev, ar, darabszam, gyarto, leiras FROM termek where id = %s", 
                mysqli_real_escape_string($link, $termekid)) or die(mysqli_error($link));
            $eredmeny = mysqli_query($link, $query);
            $row = mysqli_fetch_array($eredmeny);
            if (!$row) {
                header("Location: termek.php");
                return;
            }
        ?>
     <h1>Termék adatainak módosítása</h1>
        <?php if ($successful_update): ?>
        <p>
            <span class="badge badge-success">Termék sikeresen módosítva</span>
        </p>
        <?php endif; ?>
        <form method="post" action="">
            <input type="hidden" name="id" id="id" value="<?=$termekid?>" />
            <div class="form-group">
                <label for="isbn">Név</label>
                <input class="form-control" name="nev" id="nev" type="text" value="<?=$row['nev']?>" />
            </div>
            <div class="form-group">
                <label for="cim">Ár</label>
                <input required class="form-control" name="ar" id="ar" type="number" value="<?=$row['ar']?>" />
            </div>
            <div class="form-group">
                <label for="szerzo">Gyártó</label>
                <input class="form-control" name="gyarto" id="gyarto" type="text" value="<?=$row['gyarto']?>" />
            </div>
             <div class="form-group">
                <label for="kiado">Darabszám</label>
                <input class="form-control" name="darabszam" id="darabszam" type="nubmer" value="<?=$row['darabszam']?>" />
            </div>
            <div class="form-group">
                <label for="megjelenesev">Leírás</label>
                <input class="form-control" name="leiras" id="leiras" type="text" value="<?=$row['leiras']?>" />
            </div>
            <input class="btn btn-success" name="update" type="submit" value="Mentés" />
            <input class="btn btn-danger" name="delete" type="submit" value="Törlés" />
        </form>

        <?php
            closeDb($link);
        ?>
    </div>
  </body>
</body>
</html>
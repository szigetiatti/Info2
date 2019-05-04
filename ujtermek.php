<?php
include 'webshop.php';
$link=getDb();

$succesfull_created = false;


if (isset($_POST['create'])) {
    $nev = mysqli_real_escape_string($link, $_POST['nev']);
    $ar = mysqli_real_escape_string($link, $_POST['ar']);
    $gyarto = mysqli_real_escape_string($link, $_POST['gyarto']);
    $darabszam = mysqli_real_escape_string($link, $_POST['darabszam']);
    $leiras = mysqli_real_escape_string($link, $_POST['leiras']);
    $createQuery = sprintf("INSERT INTO termek(nev, ar, gyarto, darabszam, leiras) VALUES ('%s', '%i', '%s', '%i', '%s')",
        $nev,
        $ar,
        $gyarto,
        $darabszam,
        $leiras
    );
    mysqli_query($link, $createQuery) or die(mysqli_error($link));
    $succesfull_created = true;
}
?>


<html>
<head>
<meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="library.css">
    <title>Webshop</title>
</head>
<body>
    <?php include 'navbar.html'; ?>

    <div class="container main-content">

        
        <?php if ($succesfull_created): ?>
        <p>
            <span class="badge badge-success">Új termék létrehozva</span>
        </p>
        <?php endif; ?>

        <?php
            $search = null;
             if (isset($_POST['search'])) {
                 $search = $_POST['search'];
            }
        ?>
        <?php
        /*<form class="form-inline" method="post">
            <div class="card">
                <div class="card-body">
                    Keresés: 
                    <input style="width:600px;margin-left:1em;" class="form-control" type="search" name="search" value="<?=$search?>">
                    <button class="btn btn-success" style="margin-left:1em;" type="submit" >Search</button>
                </div>
            </div>
        </form>
        */?>


        <?php
           /* $querySelect = "SELECT id, nev, ar, gyarto, darabszam, leiras FROM termek";
            if ($search) {
               // $querySelect = $querySelect . sprintf(" WHERE LOWER(cim) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($search)));
            }
            $eredmeny = mysqli_query($link, $querySelect) or die(mysqli_error($link));
            */
            ?>
            
            
            <form method="post" action="" >
                <div class="card">
                    <div class="card-header">
                        Új termék hozzáadása
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nev">Név</label>
                            <input class="form-control" name="nev" id="nev" type="text" />
                        </div>
                        <div class="form-group">
                            <label for="ar">Ár</label>
                            <input required class="form-control" name="ar" id="ar" type="number" min='1' />
                        </div>
                        <div class="form-group">
                            <label for="gyarto">Gyártó</label>
                            <input class="form-control" name="gyarto" id="gyarto" type="text" />
                        </div>
                        <div class="form-group">
                            <label for="darabszam">Darabszám</label>
                            <input class="form-control" name="darabszam" id="darabszam" type="number" min='1' />
                        </div>
                        <div class="form-group">
                            <label for="leiras">Leírás</label>
                            <input class="form-control" name="leiras" id="leiras" type="text" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <input class="btn btn-success" name="create" type="submit" value="Létrehozás" />
                    </div>
                </div>

            </form>

            <?php
                closeDb($link);
            ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
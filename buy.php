<?php

include 'webshop.php';
$link = getDb();
$ujvasarlobuy=false;
$retvasarlobuy=false;
$db_stock_check=false;

//if the user pushed the "buy" button:
if(isset($_POST['buy']))
{
  $vezeteknev = mysqli_real_escape_string($link, $_POST['vezeteknev']);
  $keresztnev = mysqli_real_escape_string($link, $_POST['keresztnev']);
  $lakcim = mysqli_real_escape_string($link, $_POST['lakcim']);
  $kartyaszam = mysqli_real_escape_string($link, $_POST['kartyaszam']);
  $idbuy=$_GET['termekid'];

  $querytemp= sprintf("SELECT darabszam FROM termek where id=%s", $idbuy);
  $queryfetch=mysqli_query($link,$querytemp) or die (mysqli_error($link));

  $db_stock_check = mysqli_fetch_array($queryfetch);
  //use as associative array--> check the stock
  if($db_stock_check['darabszam']==0) 
  { 
    $db_stock_check=true;
  }
  if($db_stock_check['darabszam']!=0) 
  { 
    $db_stock_check=false;
  }

  $querytemp= sprintf("SELECT id FROM vevo 
                      WHERE vezeteknev='%s' and keresztnev='%s' and lakcim='%s' and kartyaszam='%s'",
                      $vezeteknev, $keresztnev, $lakcim, $kartyaszam);

  $queryfetch=mysqli_query($link,$querytemp) or die (mysqli_error($link));

  // no buyer in DB && stock>0 
  // insert the buyer
  if(mysqli_num_rows($queryfetch)==0 and !$db_stock_check)
  {
    $ujvevo=sprintf("INSERT INTO vevo(vezeteknev, keresztnev, lakcim, kartyaszam) VALUES ('%s', '%s', '%s', '%s')",
                     $vezeteknev, $keresztnev, $lakcim, $kartyaszam);
    mysqli_query($link, $ujvevo) or die(mysqli_error($link));

    //save the buyers id into a temporary variable
    $querytemp= sprintf("SELECT id FROM vevo 
                         WHERE vezeteknev='%s' and keresztnev='%s' and lakcim='%s' and kartyaszam='%s'",
                         $vezeteknev, $keresztnev, $lakcim, $kartyaszam);                 
    $queryfetch=mysqli_query($link,$querytemp) or die (mysqli_error($link));
    $idtemp = mysqli_fetch_array($queryfetch);

    //add a PURCHASE to the megvasarolt table with current date and set ujvasarlo to true
    $ujvasarlas=sprintf("INSERT INTO megvasarolt (termekid, vevoid, vasarlasidatum) VALUES (%s, %s, curdate())", $idbuy, $idtemp['id']);
    mysqli_query($link, $ujvasarlas) or die(mysqli_error($link));
    $ujvasarlobuy=true;
  }
  //if the buyers table not null, and stock>0
  elseif(!$db_stock_check)
  { 
    $querytemp= sprintf("SELECT id FROM vevo 
                        WHERE vezeteknev='%s' and keresztnev='%s' and lakcim='%s' and kartyaszam='%s'",
                        $vezeteknev, $keresztnev, $lakcim, $kartyaszam);
    $queryfetch=mysqli_query($link,$querytemp) or die (mysqli_error($link));
    $idtemp = mysqli_fetch_array($queryfetch);
    //add a new purchase
    $ujvasarlas=sprintf("INSERT INTO megvasarolt (termekid, vevoid, vasarlasidatum) VALUES (%s, %s, curdate())", $idbuy, $idtemp['id']);
    mysqli_query($link, $ujvasarlas) or die(mysqli_error($link));
    $retvasarlobuy=true;
  }
  //decrease the stock amount of the item by one /each purchase
  if(!$db_stock_check)
  {
  $updatetermek=sprintf("UPDATE termek SET darabszam=darabszam-1 WHERE id=%s", $idbuy);
  mysqli_query($link, $updatetermek) or die(mysqli_error($link));
  }
}

?>

<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="webshop.css">
    <title>Webshop - Vásárlás</title>
  </head>
  <body>
      <?php include 'navbar.html'; ?>

      <div class="container main-content">
      <div class="jumbotron">
        <h1>Vásárlás</h1>
        <?php if ($db_stock_check): ?>
        <h2><span class="badge badge-danger">Sajnos, a termékből jelenleg nincs készleten!
        </span>
        <?php endif; ?>
        <?php if ($ujvasarlobuy): ?>
        <h2><span class="badge badge-success">Sikeres Vásárlás! Köszöntjük vásárlóink körében, köszönjük, hogy minket választott!</span></h2>
        <?php endif; ?>
        <?php if ($retvasarlobuy): ?>
        <h2><span class="badge badge-success">Köszönjük, hogy megint nálunk vásárolt!</span></h2>
        <?php endif; ?>
    <?php
    
    if (!isset($_GET['termekid'])) {
          header("Location: termek.php");
          return;
      } 
      $idbuy=$_GET['termekid'];
  $query = sprintf("SELECT id, nev, gyarto, leiras, ar, darabszam FROM termek where id = %s", mysqli_real_escape_string($link, $idbuy)) 
  or die(mysqli_error($link));
  $result=mysqli_query($link, $query)
  or die(mysqli_error($link));

    ?>
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Név</th>
              <th scope="col">Márka</th>
              <th scope="col">Leírás</th>
              <th scope="col">Ár</th>
              <th scope="col">Darabszám</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
          <?php while ($termek_row = mysqli_fetch_array($result)): ?>
            <tr>
              <td><?=$termek_row['nev']?></td>
              <td><?=$termek_row['gyarto']?></td>
              <td>
                  <p>
                      <a class="btn btn-secondary active" data-toggle="collapse" href="#<?=$termek_row['id']?>" role="button" aria-expanded="false" aria-controls="['id']">Leírás</a>
                  </p>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id=<?=$termek_row['id']?>>
                        <div class="card card-body">
                            <?=$termek_row['leiras']?>
                        </div>
                      </div>
                    </div>
                  </div>





              </td>
              <td><?=$termek_row['ar']?> Ft</td>
              <td><?=$termek_row['darabszam']?>db</td>


            </tr>
          <?php endwhile; ?>
          <form method="post">
            <div class="form-group">
                <label for="vezeteknev">Vezetéknév</label>
                <input name="vezeteknev" class="form-control" id="vezeteknev" placeholder="Írja be a vezetéknevét..." required>
            </div>
            <div class="form-group">
                <label for="keresztnev">Keresztnév</label>
                <input name="keresztnev" class="form-control" id="keresztnev" placeholder="Írja be a keresztnevét..." required>
            </div>
            <div class="form-group">
                <label for="lakcim">Lakcím</label>
                <input name="lakcim" class="form-control" id="lakcim" placeholder="Írja be a Lakcímét..." required>
            </div>
            <div class="form-group">
                <label for="kartyaszam">Kártyaszám</label>
                <input type="number" data-bind="value:replyNumber" data-bind="value:replyNumber" min='1000000000000000' max='9999999999999999' name="kartyaszam" class="form-control" id="kartyaszam" placeholder="Írja be a kártyaszámát..." required>
                <small class="form-text">Kártya adatait bizalmasan kezeljük.</small>
            </div>
            <button name="buy" type="submit" class="btn btn-success">Vásárlás</button>
          </form>
          </tbody>
        </table>
      </div>  
      </div>


   


      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
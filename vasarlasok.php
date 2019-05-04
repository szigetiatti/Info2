<?php

include 'webshop.php';
$link = getDb();
?>




<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="webshop.css">
    <title>Webshop - Vásárlások</title>
  </head>
  <body>
      <?php include 'navbar.html'; ?>

      <div class="container main-content">
      <div class="jumbotron">
        <h1>Vásárlások</h1>
        <?php 
        $query="SELECT id, vezeteknev, keresztnev, lakcim, kartyaszam from vevo";
        $result=mysqli_query($link, $query)
        or die(mysqli_error($link));
        ?>
        <table class="table table-striped">
          <thead class="thead-light">
            <tr>
              <th scope="col">Vezetéknév</th>
              <th scope="col">Keresztnév</th>
              <th scope="col">Lakcím</th>
              <th scope="col">Kartyaszám</th>
              <th scope="col">Megvásárolt termékek</th>

            </tr>
          </thead>
          <tbody>
          <?php while ($vevo_row = mysqli_fetch_array($result)): ?>
            <tr>
              <td><?=$vevo_row['vezeteknev']?></td>
              <td><?=$vevo_row['keresztnev']?></td>
              <td><?=$vevo_row['lakcim']?></td>
              <td><?=$vevo_row['kartyaszam']?></td>
              <td>
          
                  
                            <?php     
                            $query2=sprintf("SELECT DISTINCT vasarlasidatum, m.id, nev, gyarto, leiras, ar 
                                            FROM termek t 
                                                INNER JOIN megvasarolt m on t.id=m.termekid 
                                                INNER JOIN vevo v on m.vevoid=%s",
                                                 $vevo_row['id']);
                            $result2=mysqli_query($link, $query2)
                            or die(mysqli_error($link));
                            ?>
                            <?php if (mysqli_num_rows($result2)==0): ?>
                            <table class="table table-sm">
                              <thead class="thead-light">
                                <tr>
                                  <th scope="col">A vásárló által vásárolt összes termék törölve lett az adatbázisból!</th>
                                  </tr>
                  
                              </thead>
                            </table>       
                            <?php endif; ?>
                            <?php if (mysqli_num_rows($result2)!=0): ?>
                              <table class="table table-sm">
                              <thead class="thead-light">
                                <tr>
                                  <th scope="col">Név</th>
                                  <th scope="col">Gyártó</th>
                                  <th scope="col">Leírás</th>
                                  <th scope="col">Ár</th>
                                  <th scope="col">Vásárlás dátuma</th>
                                </tr>
                              </thead>
                              <?php while ($termek_row = mysqli_fetch_array($result2)): ?>
                              <tbody>
                                <tr>
                                  <td><?=$termek_row['nev']?></td>
                                  <td><?=$termek_row['gyarto']?></td>
                                  <td>
                                  <p>
                                    <a class="btn btn-secondary active" data-toggle="collapse" href="#<?=$termek_row['id']?>" role="button" aria-expanded="false" aria-controls="['idmegvasarolta']">Leírás</a>
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
                                  <td><?=$termek_row['vasarlasidatum']?></td>
                                </tr>
                              </tbody>
                              <?php endwhile; ?>
                            </table>
                          <?php endif; ?>

                            
              </td>
              


            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>  
      </div>


      <?php
        closeDb($link);
      ?>


      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
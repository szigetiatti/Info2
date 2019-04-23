<?php

include 'webshop.php';
$link = getDb();
?>

<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="webshop.css">
    <title>Webshop - Keresés</title>
  </head>
  <body>
      <?php include 'navbar.html'; ?>
    
      <?php
			// $keres=NULL;
			// if(isset($_POST['keres']))
			// {
			// $keres=$_POST['keres'];
			// }
        ?>
        

      <div class="container main-content">
      <div class="jumbotron">
      	<h1>Keresés eredménye:</h1>
      <?php	
      if(isset($_GET['keresref']))
			{
			$keres=$_GET['keresref'];
			}
	  ?>
    

		<?php 
			$querySearch="SELECT id, nev, gyarto, leiras, ar, darabszam from termek";
			if ($keres)
			{
                $querySearch=$querySearch . sprintf(" WHERE LOWER(nev) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($keres)));
                
			}
            $result=mysqli_query($link, $querySearch)
        	or die(mysqli_error($link));
         ?>

        <?php if (mysqli_num_rows($result)==0): ?>
            <h2>Nincs találat!</h2>
            <?php return; ?>
        <?php endif; ?>

        <table class="table table-striped">
          <thead class="thead-light">
            <tr>
              <th scope="col">Név</th>
              <th scope="col">Ár</th>
              <th scope="col">Gyártó</th>
              <th scope="col">Darabszám</th>
              <th scope="col">Leírás</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
          <?php while ($termek_row = mysqli_fetch_array($result)): ?>
            <tr>
              <td><?=$termek_row['nev']?></td>
              <td><?=$termek_row['ar']?></td>
              <td><?=$termek_row['gyarto']?></td>
              <!-- <td>
                  <p>
                      <a class="btn btn-secondary active" data-toggle="collapse" href="#<?//=$termek_row['id']?>" role="button" aria-expanded="false" aria-controls="['id']">Leírás</a>
                  </p>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id=<?//=$termek_row['id']?>>
                        <div class="card card-body">
                            <?//=$termek_row['leiras']?>
                        </div>
                      </div>
                    </div>
                  </div>
          




              </td> -->
              <td><?=$termek_row['darabszam']?> Ft</td>
              <td><?=$termek_row['leiras']?>db</td>
              <td>
                <a method="submit" href="buy.php?termekid=<?=$termek_row['id']?>" class="btn btn-primary">Vásárlás</a>
                <a method="submit" href="edit-termek.php?termekid=<?=$termek_row['id']?>" class="btn btn-success btn-sm">Szerkesztés</a>
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
<?php
include 'webshop.php';
$link=getDb();
?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="webshop.css">
    <title>Webshop</title>
</head>
<body>
    <?php include 'navbar.html'; ?>
    <div class="container main-content">
        <div class="jumbotron">
            <h1>Vásárlók</h1>
            
            <?php
            $querySelectAll="SELECT id, vezeteknev, keresztnev, lakcim, kartyaszam FROM vevo";
            $eredmeny=mysqli_query($link,$querySelectAll) or die(mysqli_error($link));
            ?>

            <table class="table table-striped">
            <caption>Termékek listája</caption>
                <thead class="thead-light">
                    <tr>
                        <th>Vezetéknév</th>
                        <th>Keresztnév</th>      
                        <th>Lakcím</th>      
                        <th>Kártyaszám</th>
                        
                        <th></th>
                    </tr> 
                </thead>
                <tbody class="light">
                <?php while ($row = mysqli_fetch_array($eredmeny)): ?>
                    <tr>
                        <td><?=$row['vezeteknev']?></td>
                        <td><?=$row['keresztnev']?></td>
                        <td><?=$row['lakcim']?></td>
                        <td><?=$row['kartyaszam']?></td>
                     
                        <td>
                            <a class="btn btn-success btn-sm" href="edit-vevo.php?vevoid=<?=$row['id']?>">
                                <i class="fa fa-edit"></i> Szerkesztés
                            </a>
                        </td>
                        
                    </tr>                
                <?php endwhile; ?> 
                </tbody>
            </table>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</body>
</html>
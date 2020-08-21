<?php 
require_once 'db.php';
$result=mysqli_query($con, "SELECT * FROM theaters_list");
?>

<html>
<head>
<title>home</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>
  <body bgcolor="gray">
  <form id="form" action="HomePage.php" method="post">
  <h1 id="h1">Theaters</h1>
    	<?php while($row=mysqli_fetch_array($result)){ ?>
		<input type="submit" name="cinema_name" value="<?= $row['theaters_name'];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php }?>  <br><br> 

    	<?php if(isset($_POST['cinema_name'])){
    	    echo "<h2>please select movie</h2>";
            $all_movie=$_POST['cinema_name'];
            $id=3;
            $sql="UPDATE selected SET selected='$all_movie' WHERE id='$id'";
            mysqli_query($con, $sql);
            $result=mysqli_query($con, "SELECT * FROM $all_movie");
            while ($row=mysqli_fetch_array($result)) {?>
            <input type="submit" name="movie_list" value="<?=$row["movie_name"];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php }}?>  
       <br><br>
         <br><br>
    	<?php if(isset($_POST['movie_list'])){
    	    echo "<h3>please select seats</h3>";
    	    $result=mysqli_query($con, "SELECT * FROM selected");
    	    $cinemaName="";
    	    while ($row=mysqli_fetch_array($result)) 
    	        $cinemaName=$row['selected'];
            $movie_selected=$_POST['movie_list'];
            $movie_name=$movie_selected;
            for ($i = 0; $i < strlen($movie_selected); $i++) {
                if($movie_selected[$i]==" ")
                    $movie_name[$i]="_";
                    else
                        $movie_name[$i] =$movie_selected[$i];
            }
            $cinemaAndMovieName=$cinemaName."_".$movie_name; 
            $sql="UPDATE select_seat  SET seat_selected='$cinemaAndMovieName' WHERE id='1'";
            mysqli_query($con, $sql);
            $index=1;
            $result=mysqli_query($con, "SELECT * FROM $cinemaAndMovieName");
             echo "<table border='1'><tr>";
            while ($row=mysqli_fetch_array($result)) {
                echo "<td>";
                if($row['status_seat']=="empty"){?>
                   <input type="checkbox" name="seat[]" value="<?=$index;?>" style="width:9em;height:5em;"><br>
                   <input type="text" name="seatname[]" style="width:9em;height:4em;">
                   
              <?php   }
              else{?>
              <p style="width:100%;height:4.5em; background-color: aqua; font-size: 1.5em; text-align: center;">save to: <br><?=$row['seat_name'];?></p>
              <?php 
              }
              if($index%5==0) {
                  echo "</tr><tr>";}
              echo "</td>"; $index++;
            }	
              echo '<br><br><input type="submit" name="seat_selec">';}
              $local="";
              $result=mysqli_query($con, "SELECT * FROM select_seat");
              while ($row=mysqli_fetch_array($result))
                  $cinemaandmovie=$row['seat_selected'];
              if(isset($_POST['seat_selec'])){
                  if(!empty($_POST['seat'])&&!empty($_POST['seatname'])){
                      foreach($_POST['seat'] as $seatSelected){
                          if($seatSelected !='#000000')
                              $local.=$seatSelected."/";
                          $sql="UPDATE $cinemaandmovie SET status_seat='save'  WHERE id='$seatSelected'";
                          mysqli_query($con, $sql);
                      }   
                      $i = 0;
                      echo $local.'<br>';
                      $inde="";
                      foreach ($_POST['seatname'] as $seatname){
                          $valid=false;
                          if($seatname!=null){
                          for (; $i < strlen($local)&& !$valid; $i++) {
                              if($local[$i] == "/") {
                                 $sql="UPDATE $cinemaandmovie SET seat_name='$seatname' WHERE id='$inde'";
                                 mysqli_query($con, $sql);     
                                 $inde="";
                                 $valid=true;
                              }
                                else $inde.=$local[$i];
                          }
                          }
                      }
                      }
              }
              ?>  
</form>
 </body>
</html>
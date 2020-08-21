<?php 
require_once 'db.php'; //database connectss

if(!(mysqli_query($con, "SELECT * FROM theaters_list"))){
    $sql="CREATE TABLE theaters_list
    (id INT(11) AUTO_INCREMENT PRIMARY KEY,
    theaters_name VARCHAR(250))";
    mysqli_query($con, $sql);    
}

if(isset($_POST['add_theaters'])){
    $theaters_list=mysqli_real_escape_string($con,$_POST['theaters_list']);
    $theaters_list_true=$theaters_list;
    //change space value to '_' value
    for ($i = 0; $i < strlen($theaters_list); $i++) {
        if($theaters_list[$i]==" ")
        $theaters_list_true[$i]="_";
        else 
        $theaters_list_true[$i] =$theaters_list[$i];
    }
    //adding new cinema name to table theaters_list
    $sql="INSERT INTO theaters_list(theaters_name) VALUES('$theaters_list_true')";//add user
    mysqli_query($con, $sql);
    $sql="CREATE TABLE $theaters_list_true
    (id INT(11) AUTO_INCREMENT PRIMARY KEY,
    movie_name VARCHAR(100),seat_number INT(100))";
    mysqli_query($con, $sql);
}
$result=mysqli_query($con, "SELECT * FROM theaters_list");
//mysqli_close($con);
if(isset($_POST['add_movie'])){
    /*when add movie is submit:
        is check that cinema name and number of seat and movie name text not empti
        and check evry cinema name that marked and added movie name list. 
        and craete new table with number of seat
    */
    if(!empty($_POST['cinema_name']) && !empty($_POST['movie_name_added']) && !empty($_POST['number_of_seats'])){
        foreach($_POST['cinema_name'] as $movieCinemaAdded){
            $movieAdded=$_POST['movie_name_added'];
            $seatNum=$_POST['number_of_seats'];
            $movie_table=$movieAdded;
            for ($i = 0; $i < strlen($movieAdded); $i++) {
                if($movieAdded[$i]==" ")
                    $movie_table[$i]="_";
                    else
                        $movie_table[$i] =$movieAdded[$i];
            }
            $sql="INSERT INTO $movieCinemaAdded(movie_name,seat_number) VALUES('$movieAdded','$seatNum')";
            mysqli_query($con,$sql);
            $newTable=$movieCinemaAdded."_".$movie_table;
            $sql="CREATE TABLE $newTable(
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                status_seat VARCHAR(100),seat_name VARCHAR(100))";
             mysqli_query($con,$sql);
             for ($index = 0; $index < $seatNum; $index++) {
             $sql="INSERT INTO $newTable(status_seat) VALUES('empty')";
             mysqli_query($con,$sql);            
             }
        }        
    }
}

?>
<html>
<head>
<title>sratim</title>
<link rel="stylesheet" type="text/css" href="main.css">
</head>
  <body bgcolor="gray">
  <script type="text/javascript">
  </script>
  <form id="form" action="UpdateHomePage.php" method="post">
  <h1 id="h1">Theaters</h1>
  <table class="theatersandmovie_list">
  <tr><td>
  	Enter Cinema Name:<input type="text" name="theaters_list"><br><br>
    <input type="submit" value="Add Cinema Name" name="add_theaters"><br><br>
   </td></tr> 
  
  <tr><td> 
     
    	<?php while($row=mysqli_fetch_array($result)){ ?>
    	<label><?= $row['theaters_name'];?></label>
		<input type="checkbox" name="cinema_name[]" value="<?= $row['theaters_name'];?>">
		<?php } mysqli_close($con);?>
   
    </td></tr>
    
    <tr><td>
    	Enter Movie Name:<input type="text" name="movie_name_added"><br>
    	Enter Number Of Seats:<input type="number" name="number_of_seats"><br><br>
    	<input type="submit" value="Add Movie Name" name="add_movie">
   	</td></tr>
  </table>        
</form>
 </body>
</html>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Add a Print</title>
	</head>
	<body>
		<?php #Script - add_print.php
            require 'config.php';
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $errors = array();
                if(!empty($_POST['print_name']))
                {
                    $pn = trim($_POST['print_name']);
                }
                else 
                {
                    $errors[] = 'Please enter the print \'s name!';
                }
                if(is_uploaded_file($_FILES['image']['name']))
                {
                    $temp = '../../uploads/' . md5($_FILES['name']['name']);
                    if(move_uploaded_file($_FILES['image']['name'], $temp))
                    {
                        echo '<p>The file has been uploaded!</p>';
                        $i = $_FILES['image']['name'];
                    }
                    else 
                    {
                        $errors[] = 'The file could not be moved.';
                        $temp = $_FILES['image']['name'];
                    }
                }
                else 
                {
                    $errors[] = 'No file was uploaded!';
                    $temp = NULL;
                }
                $s = (!empty($_POST['size'])) ? trim($_POST['size']) : NULL;
                if(is_numeric($_POST['price']) && ($_POST['size'] > 0))
                {
                    $p = (float)$_POST['price'];
                }
                else 
                {
                    $errors[] = 'Please enter a print\'s price!';
                }
                $d = (!empty($_POST['description'])) ? trim($_POST['description']) : NULL;
                if(isset($_POST['artist']) && filter_var($_POST['artist'], FILTER_VALIDATE_INT, array('min_range' => 1)))
                {
                      $a = $_POST['artist'];
                }
                else 
                {
                    $errors[] = 'Please select the print\'s artist!';
                }
                if(empty($errors))
                {
                    $q = 'INSERT INTO prints(artist_id, print_name, price, size, description, image_name)
                          VALUES (?, ?, ?, ?, ?, ?)';
                    $stmt = mysqli_prepare($connect, $q);
                    mysqli_stmt_bind_param($stmt, 'isdsss', $a, $pn, $p, $s, $d, $i);
                    mysqli_stmt_execute($stmt);
                    if(mysqli_stmt_affected_rows($stmt) == 1)
                    {
                        echo '<p>The print has been added.</p>';
                        $id = mysqli_stmt_insert_id($stmt);
                        rename($temp, "../../uploads/$id");
                        $_POST = array();
                    }
                    else 
                    {
                        echo '<p style="font-wight: bold; color: #C00">Your submissions could not be processed due to a system error.
                              </p>';
                    }
                    mysqli_stmt_close($stmt);
                }
                if(isset($temp) && file_exists($temp) && is_file($temp))
                {
                    unlink($temp);
                }
            }
            if(!empty($errors) && is_array($errors))
            {
                echo '<h1>Error</h1>
                      <p style ="font-wight: bold; color: #C00">The following(s) occured: <br>';
                foreach($errors as $msg)
                {
                    echo " -$msg<br>\n";
                }
                echo 'Please reselect the print image and try again.</p>';
            }
		?>
		<h1>Add a Print</h1>
		<form enctype="multipart/form-data" action="add_print.php" method="post">
			<input type="hidden" name="MAX__FILE_SIZE" value="524288">
			<fieldset><legend>Fill out the form to add print to the catalog:</legend>
			<p><b>Print Name:</b><input type="text" name="print_name" size="30"
			maxlength="60" value="<?php if(isset($_POST['print_name'])) 
			    echo htmlspecialchars($_POST['print_name']); ?>"></p>
			<p><b>Image:</b><input type="file" name="image"></p>
			<p><b>Artist:</b>
			<select name="artist"><option>Select One</option>
			<?php
			 $q = "SELECT artist_id, CONCAT_WS(' ', first_name, middle_name, last_name) FROM artists ORDER
                   BY last_name, first_name ASC";
			 $r = mysqli_query($connect, $q);
			 if(mysqli_num_rows($r) > 0)
			 {
			     while($row = mysqli_fetch_array($r, MYSQLI_NUM))
			     {
			         echo "<option value=\"$row[0]\"";
			                 if(isset($_POST['existing']) && ($_POST['existing'] == $row[0])) echo '
                             selected="selected"';
			                 echo ">$row[1]</option>\n";        
			     }
			 }
			 else 
			 {
			     echo '<option>Please add a new artist first.</option>';
			 }
			 mysqli_close($connect);
			?>
			</select></p>
			<p><b>Price:</b><input type="text" name="price" size="10" maxlength="10
			value="<?php if(isset($_POST['price'])) echo $_POST['price']; ?>" /><small>
			Do not include the dollar sign or comas.</small></p>
			<p><b>Size:</b><input type="text" name="size" size="30" maxlength="10"
			value="<?php if(isset($_POST['size'])) echo htmlspecialchars($_POST['size']);?>"/> </p>
			<p><b>Description:</b><textarea name="description" rows="5" cols="40">
			<?php if(isset($_POST['description'])) echo $_POST['description']; ?></textarea></p>   
		</fieldset>
		<div align="center"><input type="submit" value="Submit"></div>	 
		</form>
		
	</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ad An Artist</title>
	</head>
	<body>
		<?php 
            #Script - add_artist.php
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $fn = (!empty($_POST['first_name'])) ? trim($_POST['first_name']) : NULL;
                $mn = (!empty($_POST['middle_name'])) ? trim($_POST['middle_name']) : NULL;
                if(!empty($_POST['last_name']))
                {
                    $ln = trim($_POST['last_name']);
                    require 'config.php';
                    $q = 'INSERT INTO artists (first_name, middle_name, last_name) 
                        VALUES (?, ?, ?)';
                    $stmt = mysqli_prepare($connect, $q);
                    mysqli_stmt_bind_param($stmt, 'sss', $fn, $mn, $ln);
                    mysqli_stmt_execute($stmt);
                    if(mysqli_stmt_affected_rows($stmt) == 1)
                    {
                        echo '<p>The artist has been added.</p>';
                        $_POST = array();
                    }
                    else
                    {
                        $error = 'The new artist could not be added to the database!';
                    }
                    mysqli_stmt_close($stmt);
                    mysqli_close($connect);
                }
                else 
                {
                    $error = 'Please enter the artist\'s name!';
                }
            }
            if(isset($error))
            {
                echo '<h1>Error!</h1>
                       <p style="font-wight: bold; color:#C00">' . $error
                       . 'Please try again!';
            }
        ?>
        <h1>Add a Print</h1>
        <form action="add_artist.php" method="post">
        	<fieldset><legend>Fill out for to add artist:</legend>
        		<p><b>First Name:</b><input type="text" name="first_name" size="10"
        		maxlength="20" value="<?php if(isset($_POST['first_name']))
        		    echo $_POST['first_name'];?>" /></p>
        		<p><b>Middle Name:</b><input type="text" name="middle_name" size="10"
        		maxlength="20" value="<?php if(isset($_POST['middle_name']))
        		    echo $_POST['middle_name'];?>" /></p>
        		<p><b>Last Name:</b><input type="text" name="last_name" size="10"
        		maxlength="20" value="<?php if(isset($_POST['last_name']))
        		    echo $_POST['last_name'];?>" /></p>        
        	</fieldset>
        	<div align="center"><input type="submit" value="Submit" /></div>
        </form>
	</body>
</html>
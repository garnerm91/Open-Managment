
<!doctype html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?=  isset($PageTitle) ? $PageTitle : "Default Title"?></title>
    <!-- Additional tags here -->
    	<?php 
    	if (function_exists('customPageHeader')){
      	customPageHeader();
    	}
    	?>
     <link rel="stylesheet" href="styles/main.css" />
  </head>
  <body>
  <div class="header"><h1><a href="index.php">Open Manager</a></h1>
<?php if ($login->isUserLoggedIn() == true) { echo $_SESSION['user_name'], ' Would you like to: <a href="index.php?logout">Logout</a>';
  }?>
  </div>
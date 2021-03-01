<?php

error_reporting(E_ALL);
require_once (dirname(__FILE__) . '/config.inc.php');
require_once (dirname(__FILE__) . '/data.php');


// for dev environment we do the job of .htaccess 
if(preg_match('/^\/api.php/', $_SERVER["REQUEST_URI"])) return false;
if(preg_match('/^\/api_utils.php/', $_SERVER["REQUEST_URI"])) return false;
if(preg_match('/^\/images/', $_SERVER["REQUEST_URI"])) return false;


//----------------------------------------------------------------------------------------
function display_entity_details($entity)
{
	echo '<h1>' . $entity->title . '</h1>';
	echo '<div>Stuff goes here!</div>';
}

//----------------------------------------------------------------------------------------
function display_entity($id)
{
	global $config;
		
	$ok = false;	
	$ok = true;
	
	$entity = get_entity($id);
			
	if (!$ok)
	{
		// bounce
		header('Location: /?error=Record not found' . "\n\n");
		exit(0);
	}
	
	$title = $entity->title;
	
	$meta = entity_to_metatags($entity);
	$script = '';
	
 	display_html_start($title, $meta, $script, '');
	
	display_search_bar('');	
	
	display_entity_details($entity);
	
	display_footer();
	
	display_html_end();	
}

//----------------------------------------------------------------------------------------
// Start of HTML document
function display_html_start($title = '', $meta = '', $script = '', $onload = '')
{
	global $config;
	
	echo '<!DOCTYPE html>
<html lang="en">
<head>';

	echo '<meta charset="utf-8">';
	echo '<title>' . htmlentities($title, ENT_HTML5). '</title>';

	echo '<base href="/" /><!--[if IE]></base><![endif]-->';
	
	if ($meta != '')
	{
		echo $meta;
	}
	
	echo '
	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.css"> 
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/ejs@2.6.1/ejs.min.js" integrity="sha256-ZS2YSpipWLkQ1/no+uTJmGexwpda/op53QxO/UBJw4I=" crossorigin="anonymous"></script>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
	';

    echo '<script src=""></script>';
    
	if ($script != '')
	{
		echo $script;
	}
		
	echo '<style type="text/css">
			/* body and main styles to give us a fixed footer, see https://materializecss.com/footer.html */	
			body {
			    display: flex;
			    min-height: 100vh;
			    flex-direction: column;
			    background: white; 
			  }	
			main {
    			flex: 1 0 auto;
  			}
	</style>';
	
	echo '</head>';
	
	if ($onload == '')
	{
		echo '<body>';
	}
	else
	{
		echo '<body onload="' . $onload . '">';
	}

}

//----------------------------------------------------------------------------------------
// Footer
function display_footer()
{

	echo'
		<footer class="page-footer white black-text" >
			<div class="container">
            	<div class="row">
  					[<a href=".">Home</a>] About this project...
            	</div>
  			</div>
		
		</footer>';	
}

//----------------------------------------------------------------------------------------
// End of HTML document
function display_html_end()
{
	global $config;
	
	echo 
'<script>
<!-- any end of document script goes here -->
</script>';

	echo '</body>';
	echo '</html>';
}

//----------------------------------------------------------------------------------------
function display_search_bar($q)
{
	global $config;

	echo '
<div class="navbar-fixed">

	<nav>
		<div class="nav-wrapper white black-text">
			<form action="' . $config['web_root'] . '">
				<div class="input-field">
					<input type="search" id="query" name="q" placeholder="Enter search term" value="' . $q . '">
					<label class="label-icon" for="search"><i class="material-icons">search</i></label> <i class="material-icons">close</i> 
				</div>
			</form>
		</div>
	</nav>
</div>';

}

//----------------------------------------------------------------------------------------
function display_main_start()
{
	echo '
	<main>
		<div class="row">';	
	
}

//----------------------------------------------------------------------------------------
function display_main_end()
{
	echo '</div>
	</main>';
}

//----------------------------------------------------------------------------------------
function display_search($q)
{
	global $config;
	
	$title = $q;
	
	$meta = '';
	$script = '';
	
	display_html_start($title, $meta, $script, '');
				
	display_search_bar($q);
	
	display_main_start();
	
	echo '<h2>Search results</h2>';
	echo '<ol><li>One</li><li>Two</li></ol>';
	
	display_main_end();
	
	display_footer();

	display_html_end();	
}


//----------------------------------------------------------------------------------------
// Home page, or badness happened
function default_display($error_msg = '')
{
	global $config;
	
	$title = $config['site_name'];
	$meta = '';
	$script = '';
	
	display_html_start($title, $meta, $script, '');
	
	display_search_bar('');
	
	
	if ($error_msg != '')
	{
		echo '<div><strong>Error!</strong> ' . $error_msg . '</div>';
	}
	else
	{
		// main content		
		echo '<div>Default display</div>';
	}

	display_footer();	

	display_html_end();
}

//----------------------------------------------------------------------------------------
function main()
{
	$query = '';
		
	// If no query parameters 
	if (count($_GET) == 0)
	{
		default_display();
		exit(0);
	}
		
	// Error message
	if (isset($_GET['error']))
	{	
		$error_msg = $_GET['error'];
		
		default_display($error_msg);
		exit(0);			
	}
	
	// Show entity
	if (isset($_GET['id']))
	{	
		$id = $_GET['id'];
						
		display_entity($id);
		exit(0);
	}
		
	// Show search
	if (isset($_GET['q']))
	{	
		$query = $_GET['q'];
		display_search($query);
		exit(0);
	}				
	
}


main();

?>
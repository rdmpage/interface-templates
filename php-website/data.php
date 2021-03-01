<?php

//----------------------------------------------------------------------------------------
function entity_to_twitter($entity)
{
	$twitter = '';
	$twitter .= '<meta name="twitter:card" content="summary"/>' . "\n";
	$twitter .= '<meta name="twitter:title" content="' . htmlentities($entity->title, ENT_HTML5) . '" />' . "\n";
	$twitter .= '<meta name="twitter:site" content="x"/>' . "\n";
	
	if (isset($entity->thumbnail))
	{
		$twitter .= '<meta name="twitter:image" content="' . $entity->thumbnail . '"/>' . "\n";
	}

	if (isset($entity->description))
	{
		$twitter .= '<meta name="twitter:description" content="' . $entity->description . '"/>' . "\n";
	}
	
	return $twitter;
}


//----------------------------------------------------------------------------------------
function entity_to_metatags($entity)
{
	$meta = '';
	
	$meta .= entity_to_twitter($entity);
	
	return $meta;
}

//----------------------------------------------------------------------------------------
function get_entity($id)
{	
	$obj = new stdclass;
	$obj->title 		= "Thing <one>";
	$obj->description 	= "Details about the thing";
	$obj->url 			= "http://xxx";
	$obj->thumbnail 	= 'https://via.placeholder.com/100x100';
	
	return $obj;
}

//----------------------------------------------------------------------------------------
function search($text)
{	
	$obj = new stdclass;
	$obj->title = "Search for " . $text;
	
	return $obj;
}



?>

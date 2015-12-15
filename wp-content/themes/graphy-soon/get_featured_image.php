<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Graphy
 */
 

 include '../../../wp-load.php';

$postID = url_to_postid($_POST['url']);

 
$imageID  = get_post_meta($postID, 'imagemenu', true);
$textMenu = get_post_meta($postID, "textmenu", true);

$array = array(
  "file" => wp_get_attachment_metadata($imageID, true)["file"],
  "text" => $textMenu
  
);

if ($imageID!=0) {
    $out = array_values($array);
    echo json_encode($out);
}


?>
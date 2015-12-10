<?php
require( ABSPATH . WPINC . '/post.php' );

$model     = $_POST['model'];
$name      = $_POST['name'];
$city 	   = $_POST['city'];
$bikeImage = $_POST['bikeimage'];
$color     = $_POST['color'];


$my_post = array(
  'post_title'    => $name,
  'post_content'  => 'This is my post.',
  'post_status'   => 'publish',
  'comment_status' => 'closed',
  'post_author'   => 1,
  'post_category' => array(8,39),
  'post_type' => 'communitydnv'
);

// Insert the post into the database
wp_insert_post( $my_post );

?>
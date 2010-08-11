<?php
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Sidebar',
'before_widget' => '<div id="%1$s" class="%2$s">', // Removes <li>
'after_widget' => '</div>', // Removes </li>
'before_title' => '<h2>',
'after_title' => '</h2>',
));
?>
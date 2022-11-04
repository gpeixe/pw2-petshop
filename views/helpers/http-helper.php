<?php 

function isPostRequest()
{
    return isset($_POST) && !empty($_POST);
}
?>


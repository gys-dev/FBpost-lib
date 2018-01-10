<?php
require_once("post.php");
$access_token = "Enter Access Token Here";
// Create New Object
$post = new PostInfo();
// Config
$post->_getToken($access_token);
$post->_getMyProfileId();
$post->_getPostId('ID Post');
// Action :))
$post->UpdatePost("Hello World! ^^");
<?php

$filename = htmlspecialchars($_GET['filename'], ENT_QUOTES);
if (strpos($filename, '..') !== FALSE)
{
	exit();
}
header('Content-type: image');
readfile("../../mondai_data/{$filename}");

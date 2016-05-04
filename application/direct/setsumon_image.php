<?php

$filename = htmlspecialchars($_GET['filename'], ENT_QUOTES);
header('Content-type: image');
readfile("../../mondai_data/{$filename}");

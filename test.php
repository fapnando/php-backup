<?php

require 'src/Backup/Autoload.php';
\Backup\Autoload::register();

$adapter = new \Backup\Source\Database\Mysql(new Mysqli('localhost', 'root', ''), 'jobsacuk_customer');
$source = new \Backup\Source\Database($adapter);

$destination = new \Backup\Destination\FileSystem('/Users/adam/Desktop/');

$archive = new \Backup\Archive\Zip('mysql.zip');

$backup = new \Backup\Backup($source, $destination, $archive);
$backup->run('/');
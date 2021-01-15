<?php
if($file =="index.php")
  spl_autoload_register('my_auto_loader');
else
  spl_autoload_register('my_auto_loader2');


function my_auto_loader2 ($className)
{
    $path ="classes/";
    $extension = ".class.php";
    $filename = "../".$path.$className.$extension;

    if(!file_exists($filename))
    {
      return false;
    }
    include_once $filename;
}

function my_auto_loader ($className)
{
    $path ="classes/";
    $extension = ".class.php";
    $filename = $path.$className.$extension;

    if(!file_exists($filename))
    {
      return false;
    }
    include_once $filename;
}
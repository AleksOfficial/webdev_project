<?php

spl_autoload_register('my_auto_loader');

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
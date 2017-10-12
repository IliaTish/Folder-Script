<?php
function recursive($dir)
{
   static $deep = 0;
 
   $odir = opendir($dir);
 
   while (($file = readdir($odir)) !== FALSE)
   {
      if ($file == '.' || $file == '..')
      {
         continue;
      }
      else
      {
         echo str_repeat('---', $deep).$file.'<br>';
      }
 
      if (is_dir($dir.DIRECTORY_SEPARATOR.$file))
      {
         $deep ++;
         recursive($dir.DIRECTORY_SEPARATOR.$file);
         $deep --;
      }
   }
      closedir($odir);
}
recursive(getcwd());
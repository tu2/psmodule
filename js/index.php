<?php

/*
 * Module Version 1.0.0
 *
 * TODO:
 * ADD .htaccess file,
 * REMOVE this coment.
   <IfModule mod_rewrite.c>
         RewriteEngine on
         RewriteCond %{REQUEST_FILENAME} !-f
         RewriteRule "([^/]*)\.js$" retro-compat.js.php?file=$1.js [QSA,L]
         RewriteCond %{REQUEST_FILENAME} !-f
         RewriteRule "([^/]*)\.css$" ../css/retro-compat.css.php?file=$1.css [QSA,L]
   </IfModule>
*/

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Location: ../');
exit;


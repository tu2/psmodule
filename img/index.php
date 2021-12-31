<?php

/*
 * Module Version 1.0.0
 *
 * TODO:
 * Add .htaccess file
 * # Apache 2.2

<IfModule !mod_authz_core.c>
    Order deny,allow
    Deny from all
    <Files ~ "(?i)^.*\.(jpg|jpeg|gif|png|bmp|tiff|svg|pdf|mov|mpeg|mp4|avi|mpg|wma|flv|webm|ico|webp)$">
        Allow from all
    </Files>
</IfModule>

# Apache 2.4
<IfModule mod_authz_core.c>
    Require all denied
    <Files ~ "(?i)^.*\.(jpg|jpeg|gif|png|bmp|tiff|svg|pdf|mov|mpeg|mp4|avi|mpg|wma|flv|webm|ico|webp)$">
        Require all granted
    </Files>
</IfModule>

*/


header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Location: ../');
exit;



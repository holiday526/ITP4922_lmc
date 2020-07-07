<?php
session_start();
if (isset($_GET['action'])){
    switch ($_GET['action']){
        case 'destroy': session_destroy(); break;
        case 'get': echo ("<pre>"); var_dump($_SESSION[$_GET['key']]); echo("</pre>"); break;
        case 'set': $_SESSION[$_GET['key']] = $_GET['value']; echo ("<pre>"); var_dump($_SESSION); echo("</pre>"); break;
        case 'unset': unset($_SESSION[$_GET['key']]); echo ("<pre>"); var_dump($_SESSION); echo("</pre>"); break;
        case 'dd': echo ("<pre>"); var_dump($_SESSION); echo("</pre>"); break;
    }
}

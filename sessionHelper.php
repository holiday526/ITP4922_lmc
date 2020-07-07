<?php
session_start();
if (isset($_GET['action'])){
    switch ($_GET['action']){
        case 'destroy': session_destroy(); break;
        case 'get': echo ("<pre>"); var_dump($_SESSION[$_GET['key']]); echo("</pre>"); break;
        case 'set': $_SESSION[$_GET['key']] = $_GET['value']; break;
        case 'unset': unset($_SESSION[$_GET['key']]); break;
        case 'login': $_SESSION['customer']['id'] = 'C000001'; break;
    }
    echo ("<pre>"); var_dump($_SESSION); echo("</pre>");
}

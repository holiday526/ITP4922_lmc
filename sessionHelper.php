<?php
session_start();
if (isset($_GET['action'])){
    switch ($_GET['action']){
        case 'destroy': session_destroy(); break;
        case 'dd': echo ("<pre>"); var_dump($_SESSION); echo("</pre>"); break;
    }
}

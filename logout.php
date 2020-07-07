<?php
session_start();

session_unset();
?>
<script>
    alert('Logout success.');
    window.location.replace(window.location.origin + '/');
</script>

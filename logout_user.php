<?php
session_start();
session_unset();
session_destroy();
header("Location: pilih_role.php");
exit;

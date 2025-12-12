<?php
session_start();
session_destroy();
header('Location: reciboIndex.php');
exit();
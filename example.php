<?php

include "OBDIIHelper.php";
use OBDIIHelper\OBDIIHelper;

$o = new OBDIIHelper();
$code = $o->get_code_data("P1448");

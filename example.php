<?php

include "OBDIIHelper.php";
use OBDIIHelper\OBDIIHelper;

$o = new OBDIIHelper();

$code = $o->get_code_data("P1448");

/* OUTPUT for P1448

      stdClass Object
      (
          [code] => P1448
          [code_type] => Manufacturer defined
          [system_group] => Powetrain
          [system_area] => Emission control
      )
      
*/

$code = $o->get_code_data("P2248-12");

/* OUTPUT for P2248

    stdClass Object
    (
        [code] => P2248-12
        [code_type] => SAE defined (EOBD)
        [system_group] => Powetrain
        [system_area] => Fuel, air or emission control
  )

*/

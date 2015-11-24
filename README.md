# OBDII-Helper
OBDII Helper breaks down a parsed OBDII code to tell you what it falls under with regards to system information.

# Information returned
* **Code** - Formatted Code - p1349 => P1349
* **Code Type** - SAE defined (EOBD), Manufacturer defined
* **System Group** - Body (B), Chassis (C), Powertrain (P), Network communications (UART) (U)
* **System Area** - Fuel, air or emission control, Transmission, Ignition system or misfire, Auxiliary inputs, Hybrid propulsion

# Example
```php
include "OBDIIHelper.php";
use OBDIIHelper\OBDIIHelper;
$o = new OBDIIHelper();
$code = $o->get_code_data("P1448");
```

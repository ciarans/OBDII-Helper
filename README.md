# OBDII-Helper
OBDII Helper breaks down a parsed OBDII code to tell you what it falls under with regards to system information.

# Information returned
* Code
* Code Type
* System Group
**Body (B)
* System Area

# Example
```php
include "OBDIIHelper.php";
use OBDIIHelper\OBDIIHelper;
$o = new OBDIIHelper();
$code = $o->get_code_data("P1448");
```

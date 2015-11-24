<?php

/**
 * OBDII Helper - Helps define a OBDII code.
 * @author Ciaran Synnott <hello@synnott.co.uk>
 * @copyright (c) 2015 - Ciaran Synnott
 * @license 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.  IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class OBDIIHelper {
    
     /**
     * Code Types
     * @access protected
     * @var array
     */
    protected $code_types = array(
        "B" => array(0 => "SAE defined (EOBD)", 1 => "Manufacturer defined", 2 => "Manufacturer defined", 3 => "For future allocation"),
        "C" => array(0 => "SAE defined (EOBD)", 1 => "Manufacturer defined", 2 => "Manufacturer defined", 3 => "For future allocation"),
        "U" => array(0 => "SAE defined (EOBD)", 1 => "Manufacturer defined", 2 => "Manufacturer defined", 3 => "SAE defined (EOBD)"),
        "P" => array(0 => "SAE defined (EOBD)", 1 => "Manufacturer defined", 2 => "SAE defined (EOBD)")
    );

     /**
     * System Groups
     * @access protected
     * @var array
     */
    protected $system_groups = array(
        "B" => "Body", "C" => "Chassis",
        "P" => "Powetrain", "U" => "Network communications (UART)"
    );
    
     /**
     * System Areas for P0 codes
     * @access protected
     * @var array
     */
    protected $system_areas_p0 = array(
        0 => "Fuel, air or emission control", 1 => "Fuel or air",
        2 => "Fuel or air", 3 => "Ignition system or misfire",
        4 => "Emission control", 5 => "Vehicle speed, idle speed control or auxiliary inputs",
        6 => "Computer or auxiliary outputs", 7 => "Transmission",
        8 => "Transmission", 9 => "Transmission",
        "A" => "Hybrid propulsion", "B" => "Hybrid propulsion",
        "C" => "Hybrid propulsion", "D" => "Hybrid propulsion",
        "E" => "For future allocation", "F" => "For future allocation"
    );
    
     /**
     * System Areas for P1 codes
     * @access protected
     * @var array
     */
    protected $system_areas_p1 = array(
        0 => "Fuel, air or emission control", 1 => "Fuel or air",
        2 => "Fuel or air", 3 => "Ignition system or misfire",
        4 => "Emission control", 5 => "Vehicle speed, idle speed control or auxiliary inputs",
        6 => "Computer or auxiliary outputs", 7 => "Transmission",
        8 => "Transmission", 9 => "Transmission",
        "A" => "Hybrid propulsion", "B" => "Hybrid propulsion",
        "C" => "Hybrid propulsion", "D" => "Hybrid propulsion",
        "E" => "For future allocation", "F" => "For future allocation"
    );
    
     /**
     * System Areas for P2 codes
     * @access protected
     * @var array
     */
    protected $system_areas_p2 = array(
        0 => "Fuel, air or emission control", 1 => "Fuel, air or emission control",
        2 => "Fuel, air or emission control", 3 => "Ignition system or misfire",
        4 => "Emission control", 5 => "Auxiliary inputs",
        6 => "Computer or auxiliary outputs", 7 => "Transmission",
        8 => "For future allocation",
        "A" => "Fuel, air or emission control", "B" => "Fuel, air or emission control",
        "C" => "For future allocation", "D" => "For future allocation",
        "E" => "For future allocation", "F" => "For future allocation"
    );
    
     /**
     * System Areas for P3 codes
     * @access protected
     * @var array
     */
    protected $system_areas_p3 = array(
        0 => "Fuel, air or emission control", 1 => "Fuel, air or emission control",
        2 => "Fuel, air or emission control", 3 => "Ignition system or misfire",
        4 => "Cylinder deactivation", 5 => "For future allocation",
        6 => "For future allocation", 7 => "For future allocation",
        8 => "For future allocation", 9 => "For future allocation",
        "A" => "For future allocation", "B" => "For future allocation",
        "C" => "For future allocation", "D" => "For future allocation",
        "E" => "For future allocation", "F" => "For future allocation"
    );
    
     /**
     * System Areas for U codes
     * @access protected
     * @var array
     */
    protected $system_areas_u = array(
        0 => "Network electrical", 1 => "Network communications",
        2 => "Network communications", 3 => "Network software",
        4 => "Network data", 5 => "Network data",
        6 => "For future allocation", 7 => "For future allocation",
        8 => "For future allocation", 9 => "For future allocation",
        "A" => "For future allocation", "B" => "For future allocation",
        "C" => "For future allocation", "D" => "For future allocation",
        "E" => "For future allocation", "F" => "For future allocation"
    );

    /*  END - System Areas */

    
    /**
     * Returns OBDII code breakdown
     * @access public 
     * @param string $code
     * @return object
     */
    public function get_code_data($code) {
        $cleaned_code = strtoupper(preg_replace('/\s+/', '', $code));
        
        $ex = explode("-", $cleaned_code);
        
        $prefix = null;
        $suffix = null;
                
        if(count($ex) == 1){
            $prefix = $ex[0];
        }else{
            $prefix = $ex[0];
            $suffix = $ex[1];
        }        
             
        $this->validate_length($prefix);
        
        $breakdown = new stdClass();
        $breakdown->code = $prefix."-".$suffix;
        $breakdown->code_type = $this->get_code_type($prefix);
        $breakdown->system_group = $this->get_system_group($prefix);
        $breakdown->system_area = $this->get_system_area($prefix);
        
        return $breakdown;
        
    }
    
    /**
     * Validates the length of the code
     * @access private 
     * @param string $code
     * @return boolean
     */
    private function validate_length($code) {
        if (strlen($code) != 5) {
            exit("Code " . $code . " is not a valid OBDII Code Length.");
        } else {
            return true;
        }
    }
    
    /**
     * Gets the system type
     * @access private 
     * @param string $code
     * @return string
     */
    private function get_system_group($code) {
        // Validate system groups
        if (!isset($this->system_groups[$code[0]])) {
            exit("Code " . $code . " is not a valid System Group.");
        } else {
            return $this->system_groups[$code[0]];
        }
    }
    
    /**
     * Gets the code type
     * @access private 
     * @param string $code
     * @return string
     */
    private function get_code_type($code) {
        if ($code[0] == "P" && $code[1] == "3") { // P codes are not as straight forward as usual
            $number = substr($code, 1); // remove letter - the first char
            if (strlen($number) != 4) {
                exit("Powetrain Code " . $code . " is not correct length.");
            }

            if ($number >= 3000 and $number <= 3399) {
                return "Manufacturer defined";
            } elseif ($number >= 3400 and $number <= 3999) {
                return "SAE defined (EOBD)";
            }
        } else {
            if (isset($this->code_types[$code[0]][$code[1]])) {
                return $this->code_types[$code[0]][$code[1]];
            }
        }
    }
    
    /**
     * Gets the system area
     * @access private 
     * @param string $code
     * @return mixed
     */
    private function get_system_area($code) {
        $system_group = $code[0];

        switch ($system_group) {
            case "P":
                switch ($code[1]) {
                    case "0":
                        if (isset($this->system_areas_p0[$code[2]])) {
                            return $this->system_areas_p0[$code[2]];
                        } else {
                            return null;
                        }
                        break;
                    case "1":
                        if (isset($this->system_areas_p1[$code[2]])) {
                            return $this->system_areas_p1[$code[2]];
                        } else {
                            return null;
                        }       
                        break;
                    case "2":
                        if (isset($this->system_areas_p2[$code[2]])) {
                            return $this->system_areas_p2[$code[2]];
                        } else {
                            return null;
                        }  
                        break;
                    case "3":
                        if (isset($this->system_areas_p3[$code[2]])) {
                            return $this->system_areas_p3[$code[2]];
                        } else {
                            return null;
                        }                
                        break;
                }
                break;
            case "B":
                // To revist
                return null;
                break;
            case "C":
                // To revist
                return null;
                break;
            case "U":
                if (isset($this->system_areas_u[$code[2]])) {
                    return $this->system_areas_u[$code[2]];
                } else {
                    return null;
                }
            default:
                return null;
        }
    }

}

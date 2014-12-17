<?php

/**
 * Clément Habinshuti
 * AERC MIS project
 * Started: 01.11.2013
 * Abstract class to use create Enums that allow for easily accessing of the string representation of the enums
 * the child enums should be declared final
 */

?>
<?php

/**
 * parent class of custom constant Enums
 */
abstract class Enum {
    
    protected function __construct(){}
    
    //child class should declare a static $values property
    

    /**
     * get a mapping of the enum values to their string representations
     * @return array
     */
    public static function getValues(){
        return static::$values;
    }
    
    /**
     * get the string representation of the given enum value
     * @param int $values
     * @return string
     */
    public static function getString($value){
        return static::$values[$value];
    }
	
	/**
	 * checks whether the given value belongs to this enum
	 * @param int $value
	 * @return boolean
	 */
	public static function isValue($value){
		return array_key_exists($value, static::$values);
	}
}

?>
<?php

namespace App\Model\Entities;

abstract class Entity
{
	CONST READ_ONLY = 'read_only',
		PRIMARY = 'primary',
		REQUIRED = 'required',
		DATETIME = 'datetime',
		STRING = 'string',
		SOUND = 'sound',
		IMAGE = 'image',				
		INT = 'int',
		INT_UNSIGNED = 'int_unsigned',
		DOUBLE = 'double',
		DOUBLE_UNSIGNED = 'double_unsigned',
		TINYINT = 'tinyint',
		TINYINT_UNSIGNED = 'tinyint_unsigned',
		BOOL = 'bool',
		TRIM = 'trim',	
		VALIDATOR_CALLBACK = 'validator_callback',
		PREPARE_CALLBACK = 'prepare_callback';
	
	protected static $FIELDS_DEFINITION = [];
			
	/** @var array Values to save */
	protected $values;
	
	/** @var \App\Model\Tables\Table */
	protected $table;
	
	/**
	* Actual row
	* @var \Nette\Database\Table\ActiveRow|NULL
	*/
	protected $row;
	
	/** @var string Cached primary key */
	private $primaryKey;
	
	public function getPrimaryKey()
	{
		if (isset($this->primaryKey)) {
			return $this->primaryKey;
		}
		
		foreach (static::$FIELDS_DEFINITION as $fieldName => $fieldDefinition) {
			if (in_array(self::PRIMARY, $fieldDefinition)) {
				return $this->primaryKey = $fieldName;
			}
		}
		
		return $this->primaryKey = false;
	}
	
	protected function load() 
	{
		$primaryKey = $this->getPrimaryKey();
		if ($primaryKey && $this->$primaryKey) {
			$this->row = $this->table->getActiveRow($this->$primaryKey);
		}
	}
	
	/**
	* Set all values at once 
	* @param array
	*/
	public function setValues($values)
	{
		foreach ($values as $key => $value) {
			if (!isset(static::$FIELDS_DEFINITION[$key])) {
				continue;
			}
			
			$this->$key = $value;
		}
	}	
	
	/**
	 * Return word values as array suitable for DB
	 * @return array
	 */
	public function _toArray(){
		return isset($this->row) ? iterator_to_array($this->row) : [];
	}
	
	/**
	* Validate and set field if field is not read only
	* @param string Field name
	* @param string Value
	* @throws \Exception on validation error
	*/
	public function __set($name, $value)
	{
		if (isset(static::$FIELDS_DEFINITION[$name]) && !in_array(self::READ_ONLY, static::$FIELDS_DEFINITION[$name])) {
			if (in_array(self::TRIM, static::$FIELDS_DEFINITION[$name])) {
				$value = trim( $value );
			}

			if (isset(static::$FIELDS_DEFINITION[$name][self::PREPARE_CALLBACK])) {	
				$callback = static::$FIELDS_DEFINITION[$name][self::PREPARE_CALLBACK];
				//Allow define 'this' keyword in outer scope of class for validators
				if( isset( $callback[0] ) && $callback[0] == 'this' )
					$callback[0] = $this;

				$value = call_user_func( $callback, $value );
			}

			if (isset(static::$FIELDS_DEFINITION[$name][self::VALIDATOR_CALLBACK])) {	
				$callback = static::$FIELDS_DEFINITION[$name][self::VALIDATOR_CALLBACK];
				//Allow define 'this' keyword in outer scope of class for validators
				if(isset($callback[0]) && $callback[0] == 'this') {
					$callback[0] = $this;
				}

				call_user_func($callback, $value);
			}
			
			//TODO: Throw exception on wrong value(different from field definition)
			return $this->values[$name] = $value;
		}
	}

	public function __get($name)
	{
		if (isset(static::$FIELDS_DEFINITION[$name])) {
			if (isset($this->row)) {
				return $this->row[$name];
			} else {
				return $this->values[$name];
			}
		}			
	}

	public function __isset($name)
	{
		if (isset($this->row)) {
			return isset($this->row[$name]);
		} else {
			return isset($this->values[$name]);
		}
	}
}

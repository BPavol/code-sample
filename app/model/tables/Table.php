<?php

namespace App\Model\Tables;

abstract class Table
{
	/** @var \Nette\Database\Context */
	private $database;

	/** @var \Nette\Database\Connection */
	protected $connection;

	/** @var string Table name in database. This must be overriden in child classes. */
	protected $tableName;

	/**
	 * @param \Nette\Database\Context $database
	 * @param \Nette\Database\Connection $connection
	 * @throws \Nette\InvalidStateException
	 */
	public function __construct(
		\Nette\Database\Context $database, 
		\Nette\Database\Connection $connection
	)
	{
		if (!isset($this->tableName)) {
			throw new \Nette\InvalidStateException('Table name must be defined in ' . __CLASS__ . '::$tableName.');
		}

		$this->database = $database;
		$this->connection = $connection;
		
		$columns = $this->database->getStructure()->getColumns($this->tableName);
		foreach ($columns as $column) {
			$this->columnNames[$column['name']] = $column['nativetype'];
		}
	}

	/**
	 * @return \Nette\Database\Table\Selection
	 */
	public function getTable()
	{
		return $this->database->table($this->tableName);
	}

	/**
	 * Required for atomic updates
	 * @param int $id
	 * @return \Nette\Database\Table\ActiveRow|FALSE
	 */
	public function getActiveRow($id)
	{
		return $this->getTable()->get($id);
	}
	
	/**
	 * Prepare value for special column types e.g. DATE, DATETIME, ...
	 * Do nothing if value is in wrong format.
	 * 
	 * @param string $value
	 * @param string $nativetype Sql column type
	 * @return \DateTime|string Prepared value
	 */
	protected function prepareStringValueForColumn(string $value, $nativetype)
	{
		//Ignore null and false values
		if ($value === NULL || $value === false) {
			return $value;
		}
		
		$preparedValue = $value;
		if ($nativetype == 'DATE' || $nativetype == 'DATETIME') {
			if ($value == '') {
				$preparedValue = null;
			} else {
				try {
					$preparedValue = new \Nette\Utils\DateTime($value); //Nette provides __toString() addition for \DateTime
				} catch(\Exception $e) {
					trigger_error("Wrong {$nativetype} format! DATE and DATETIME native types can be only valid dates(parsable by new \DateTime). Value can be null or false either.");
				}
			}
		}
		
		return $preparedValue;
	}
	
	/**
	 * Intersect data keys against table column list.
	 * 
	 * @param  array|\Traversable|Selection array($column => $value)|\Traversable|Selection for INSERT ... SELECT
	 * @return array Data only with existing columns
	 */
	protected function intersectColumnData($data)
	{
		$intersectedData = [];
		foreach ($data as $column => $value) {
			if (is_array($value)) {
				if ($childIntersectedData = $this->intersectColumnData($value)) {					
					$intersectedData[$column] = $childIntersectedData;
				}
				continue;
			}
			
			if (isset($this->columnNames[$column])) {
				//Auto date conversion if value is string(SqlLiteral an DateTime is valid)
				if (is_string($value)) {
					$intersectedData[$column] = $this->prepareStringValueForColumn($value, $this->columnNames[$column]);
				} else {
					$intersectedData[$column] = $value;
				}
			}
		}
		
		return $intersectedData;
	}
	
	/**
	 * Inserts row in a table.
	 * @param  array|\Traversable|Selection array($column => $value)|\Traversable|Selection for INSERT ... SELECT
	 * @return IRow|int|bool Returns IRow or number of affected rows for Selection or table without primary key
	 */
	public function insert($data)
	{
		// Allow only valid column names!
		return $this->getTable()->insert($this->intersectColumnData($data));
	}

	/**
	 * Updates row.
	 * 
	 * @param int|string $id
	 * @param  iterable $data (column => value)
	 * @return bool
	 */
	public function update($id, $data)
	{
		// Allow only valid column names!
		return $this->getActiveRow($id)->update($this->intersectColumnData($data));
	}

	/**
	 * Escape wildcard should be other character than backslash. Don`t forget to add ESCAPE '=' after LIKE
	 */
	public static function escape_wildcards($string, $e = '=')
	{
		return str_replace(array($e, '_', '%'), array($e . $e, $e . '_', $e . '%'), $string);
	}
}

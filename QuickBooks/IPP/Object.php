<?php

class QuickBooks_IPP_Object
{
	protected $_data;
	
	public function __construct()
	{
		$this->_data = array();
	}
	
	public function __call($name, $args)
	{
		if (substr($name, 0, 3) == 'set')
		{
			//print('called: ' . $name . ' with args: ' . print_r($args, true) . "\n");
			
			$field = substr($name, 3);
			
			if (count($args) == 1)
			{
				$this->_data[$field] = current($args);
			}
			else
			{
				
			}
		}
		else if (substr($name, 0, 3) == 'get')
		{
			$field = substr($name, 3);
			
			//print('getting field: [' . $field . ']' . "\n");
			//print_r($this->_data);
			
			
			if (isset($this->_data[$field]))
			{
				if (isset($args[0]) and 
					is_numeric($args[0]))
				{
					// Trying to fetch a repeating element
					if (isset($this->_data[$field][$args[0]]))
					{
						return $this->_data[$field][$args[0]];
					}
					
					return null;
				}
				else
				{
					// Normal data
					return $this->_data[$field];
				}
			}
			
			return null;
		}
		else if (substr($name, 0, 3) == 'add')
		{
			$field = substr($name, 3);
			
			if (!isset($this->_data[$field]))
			{
				$this->_data[$field] = array();
			}
			
			$this->_data[$field][] = current($args);
		}
	}
}
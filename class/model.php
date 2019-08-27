<?php

class Model
{
	protected $_name, $_primaryKey, $_properties;

	public function __construct($name, $properties)
	{
		$this->_name = $name;
		$this->_properties = array_keys($properties);
		$this->_primaryKey = $this->_properties[0];
	}

	protected function _render()
	{
		$template = new Template('model.php');

		$template->name = $this->_name;
		$template->properties = $this->_properties;
		$template->primaryKey = $this->_primaryKey;

		return $template->render();
	}

	public function output($directory = '.')
	{
		$directory = $directory . '/model/';
		
		if( ! is_dir($directory))
		{
			mkdir($directory);
		}

		$name = $directory . strtolower($this->_name) . '.php';
		file_put_contents($name, $this->_render());
	}
}
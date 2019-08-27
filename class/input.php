<?php

class Input
{
	protected $_name, $_properties;

	public function __construct($name, $properties)
	{
		$this->_name = $name;
		$this->_properties = array_keys($properties);
	}

	protected function _render()
	{
		$template = new Template('input.php');

		$template->name = $this->_name;
		$template->properties = $this->_properties;

		return $template->render();
	}

	public function output($directory = '.')
	{
		$directory = $directory . '/input/';
		
		if( ! is_dir($directory))
		{
			mkdir($directory);
		}

		$name = $directory . strtolower($this->_name) . '.php';
		file_put_contents($name, $this->_render());
	}
}
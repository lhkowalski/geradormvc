<?php

class View
{
	protected $_name, $_module;

	public function __construct($name, $module = false)
	{
		$this->_name = $name;
		$this->_module = $module;
	}

	protected function _render()
	{
		$template = new Template('view.php');
		$template->name = $this->_name;
		$template->module = $this->_module;

		return $template->render();
	}

	public function output($directory = '.')
	{
		$directory = $directory . '/view/';
		
		if( ! is_dir($directory))
		{
			mkdir($directory);
		}

		if($this->_module)
		{
			$directory = $directory . '/' . $this->_module . '/';

			if( ! is_dir($directory))
			{
				mkdir($directory);
			}
		}

		$name = $directory . strtolower($this->_name) . '.php';
		file_put_contents($name, $this->_render());
	}
}
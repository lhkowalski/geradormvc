<?php

class Controller
{
	protected $_name, $_actions;

	public function __construct($name, $actions)
	{
		$this->_name = $name;
		$this->_actions = $actions;
	}

	protected function _render()
	{
		$template = new Template('controller.php');

		$template->name = $this->_name;
		$template->actions = $this->_actions;

		return $template->render();
	}

	public function output($directory = '.')
	{
		$directory = $directory . '/controller/';
		
		if( ! is_dir($directory))
		{
			mkdir($directory);
		}

		$name = $directory . strtolower($this->_name) . '.php';
		file_put_contents($name, $this->_render());
	}
}
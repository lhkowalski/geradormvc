<?php

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Gerador
{
	protected $_arquivoYAML, $_diretorioSaida, $_elements;
	protected $_conteudoYAML;
	protected $_defaultActions = ['index', 'new', 'create', 'show', 'edit', 'update', 'destroy'];

	public function __construct($arquivoYAML, $diretorioSaida)
	{
		$this->_elements = [];
		$this->_arquivoYAML = $arquivoYAML;
		$this->_diretorioSaida = $diretorioSaida;

		$this->_run();
	}

	protected function _run()
	{
		$this->_carregarArquivo();
		$this->_gerarElementos();
	}

	protected function _carregarArquivo()
	{
		if( ! file_exists($this->_arquivoYAML))
			throw new Exception("Este arquivo YAML não existe: {$this->_arquivoYAML}");

		$conteudoArquivo = file_get_contents($this->_arquivoYAML);

		if( ! $conteudoArquivo)
			throw new Exception("Não há nada para ler nesse arquivo YAML");
		
		try
		{
			$this->_conteudoYAML = Yaml::parse($conteudoArquivo);
		}
		catch(ParseException $e)
		{
			throw new Exception("Não foi possível interpretar o conteúdo do arquivo YAML. " . $e->getMessage());
		}
	}

	protected function _gerarElementos()
	{
		foreach ($this->_conteudoYAML as $key => $value)
		{
			switch($key)
			{
				case 'controller':
					$this->_gerarElementosController($value);
					break;
				case 'model':
					$this->_gerarElementosModel($value);
					break;
				case 'view':
					$this->_gerarElementosView($value);
					break;
			}
		}
	}

	protected function _gerarElementosController($listaItens)
	{
		foreach($listaItens as $nome => $actions)
		{
			if($actions === 'all')
				$actions = $this->_defaultActions;

			if( ! is_array($actions))
				$actions = array_map('trim', explode(',', $actions));

			$controller = new Controller($nome, $actions);
			$this->_elements[] = $controller;
 		}
	}

	protected function _gerarElementosModel($listaItens)
	{
		foreach($listaItens as $nome => $properties)
		{
			$model = new Model($nome, $properties);
			$this->_elements[] = $model;
		}
	}

	protected function _gerarElementosView($listaItens)
	{
		foreach($listaItens as $module => $nomes)
		{
			if($nomes === 'all')
				$nomes = $this->_defaultActions;

			if( ! is_array($nomes))
				$nomes = array_map('trim', explode(',', $nomes));

			foreach($nomes as $nome)
			{
				$view = new View($nome, $module);
				$this->_elements[] = $view;
			}
		}
	}

	public function output()
	{
		if( ! is_dir($this->_diretorioSaida))
		{
			mkdir($this->_diretorioSaida);
		}

		foreach ($this->_elements as $element)
		{
			$element->output($this->_diretorioSaida);
		}
	}
}
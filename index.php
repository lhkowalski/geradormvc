<?php


define('ROOT_DIR', realpath(dirname(__FILE__)));

require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/class/template.php';
require ROOT_DIR . '/class/controller.php';
require ROOT_DIR . '/class/model.php';
require ROOT_DIR . '/class/view.php';
require ROOT_DIR . '/class/gerador.php';

try
{
	if( ! isset($argv[1]))
		throw new Exception("É obrigatório informar o arquivo YAML de entrada");
	
	$entradaYAML = $argv[1];
	$diretorioSaida = '.';

	if(isset($argv[2]))
		$diretorioSaida = $argv[2];

	$gerador = new Gerador($entradaYAML, $diretorioSaida);
	$gerador->output();
}
catch(Exception $e)
{
	echo "ERRO: " . $e->getMessage();
}
<?php echo "<?php\n"; ?>

class Input_<?php echo ucfirst($name); ?> extends Input
{
	public static function post()
	{
		$data = POST::raw('<?php echo strtolower($name); ?>');
		$v = new Input_<?php echo ucfirst($name); ?>($data);
		$v->validate();

		return $v;
	}

	public function validate()
	{
		$v = new Validador();
		
		// validate
<?php foreach($properties as $p): ?>
		if( ! $v->isNaoVazio($this->inputData['<?php echo strtolower($p); ?>']))
			$this->errors[] = '<?php echo strtolower($p); ?> não pode ser vazio';
		
<?php endforeach; ?>

		// clear data
<?php foreach($properties as $p): ?>
		$this->data['<?php echo strtolower($p); ?>'] = trim(filter_var($this->inputData['<?php echo strtolower($p); ?>'], FILTER_SANITIZE_STRING));
<?php endforeach; ?>
	}
}
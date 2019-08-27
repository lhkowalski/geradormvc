<?php echo "<?php\n"; ?>

class Controller_<?php echo ucfirst($name); ?> extends Controller
{

<?php foreach($actions as $a): ?>
	/**
	 * 
	 */
	public function <?php echo $a; ?>()
	{
		$template = new Template('views/<?php echo strtolower($name); ?>/<?php echo strtolower($a); ?>.php');
		return $template;
	}

<?php endforeach; ?>
}
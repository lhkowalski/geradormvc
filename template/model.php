<?php echo "<?php\n"; ?>

class Model_<?php echo ucfirst($name); ?> extends ActiveRecord
{
	public static $_tableName = '<?php echo $table; ?>';
	public static $_tableFields = [
<?php foreach($properties as $p): ?>
												'<?php echo $p; ?>',
<?php endforeach; ?>
											];

	public static $_tablePrimaryKey = '<?php echo $primaryKey; ?>';
}
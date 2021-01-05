<?php
defined('_JEXEC') or die;
class jtt_tpl_index extends JoomlaTuneTemplate
{
	function render() 
	{
		$object_id = $this->getVar('comment-object_id');
		$object_group = $this->getVar('comment-object_group');
		$comments = $this->getVar('comments-list', '');
		$form = $this->getVar('comments-form');

		if ($comments != '' || $form != '' || $this->getVar('comments-anticache')) {
			// include comments css (only if we are in administor's panel)
			if ($this->getVar('comments-css', 0) == 1) {
				include_once (JCOMMENTS_HELPERS.'/system.php');
?>
<link href="<?php echo JCommentsSystemPluginHelper::getCSS(); ?>" rel="stylesheet" type="text/css" />
<?php
				if ($this->getVar('direction') == 'rtl') {
					$rtlCSS = JCommentsSystemPluginHelper::getCSS(true);
					if ($rtlCSS != '') {
?>
<link href="<?php echo $rtlCSS; ?>" rel="stylesheet" type="text/css" />
<?php
					}
				}
			}

			// include JComments JavaScript initialization
?>
<script type="text/javascript">
<!--
var jcomments=new JComments(<?php echo $object_id;?>, '<?php echo $object_group; ?>','<?php echo $this->getVar('ajaxurl'); ?>');
jcomments.setList('comments-list');
//-->
</script>

<div id="jc">
<?php
			if ($this->getVar('comments-form-position', 0) == 1) {
				// Display comments form (or link to show form)
				if (isset($form)) {
					echo $form;
				}
			}
?>
<div id="comments"><?php echo $comments; ?></div>
<?php
			if ($this->getVar('comments-form-position', 0) == 0) {
				// Display comments form (or link to show form)
				if (isset($form)) {
					echo $form;
				}
			}
?>

<?php
			// Some magic like dynamic comments list loader (anticache) and auto go to anchor script
			$aca = (int) ($this->getVar('comments-gotocomment') == 1);
			$acp = (int) ($this->getVar('comments-anticache') == 1);
			$acf = (int) (($this->getVar('comments-form-link') == 1) && ($this->getVar('comments-form-locked', 0) == 0));

			if ($aca || $acp || $acf) {
?>
<script type="text/javascript">
<!--
jcomments.setAntiCache(<?php echo $aca;?>,<?php echo $acp;?>,<?php echo $acf;?>);
//-->
</script> 
<?php
			}
?>
</div>
<?php
		}
	}
}
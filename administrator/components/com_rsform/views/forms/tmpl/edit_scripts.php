<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2014 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');
?>
<h3 class="rsfp-legend"><?php echo JText::_('RSFP_SCRIPTS_DISPLAY'); ?></h3>
<p class="alert alert-info"><?php echo JText::_('RSFP_SCRIPTS_DISPLAY_DESC'); ?></p>
<?php echo RSFormProHelper::showEditor('ScriptDisplay', $this->form->ScriptDisplay, array('classes' => 'rs_100', 'syntax' => 'php')); ?>

<h3 class="rsfp-legend"><?php echo JText::_('RSFP_SCRIPTS_PROCESS'); ?></h3>
<p class="alert alert-info"><?php echo JText::_('RSFP_SCRIPTS_PROCESS_DESC'); ?></p>
<?php echo RSFormProHelper::showEditor('ScriptProcess', $this->form->ScriptProcess, array('classes' => 'rs_100', 'syntax' => 'php')); ?>

<h3 class="rsfp-legend">Скрипт, вызываемый во время обработки формы (только для файлов)</h3>
<p class="alert alert-info">Только для файлов! Вызывается каждый раз при успешной обработке файла (Удаление, загрузка)
<p><b> Основные переменные:</b></p>
<ul>
    <li><strong>$dfilename</strong> Новое имя загруженного файла</li>
    <li><strong>$isdel</strong> Указывает для удаления ли файл (bool)</li>
    <li><strong>$newname</strong>Имя файла после обработки без формата (для удаления имя файла не поменяется)</li>
    <li><strong>$ofile</strong> Файл из POST (используется например для удаления) array($ofile['name'] ,$ofile['size'] и тд)</li>



</ul>

</p>
<?php echo RSFormProHelper::showEditor('ScriptProcessFile', $this->form->ScriptProcessFile, array('classes' => 'rs_100', 'syntax' => 'php')); ?>


<h3 class="rsfp-legend"><?php echo JText::_('RSFP_SCRIPTS_PROCESS2'); ?></h3>
<p class="alert alert-info"><?php echo JText::_('RSFP_SCRIPTS_PROCESS2_DESC'); ?></p>
<?php echo RSFormProHelper::showEditor('ScriptProcess2', $this->form->ScriptProcess2, array('classes' => 'rs_100', 'syntax' => 'php')); ?>



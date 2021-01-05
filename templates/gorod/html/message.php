<?php
defined('_JEXEC') or die;
$doc = JFactory::getDocument();
$session = JFactory::getSession();
$msgList = $displayData['msgList'];

$ismobile=$session->get('ismobile', 0);

$msgclass='system-message-container';
if($ismobile==1)
    $msgclass='system-message-container-m';
$mesgtrue=false;

?>
    <div class="new_all_portal">
        <div id="system-message-container" >

        <?php if (is_array($msgList) && !empty($msgList)) : ?>

            <div id="system-message"  class="">
                <?php foreach ($msgList as $type => $msgs) : ?>


                    <div class="<?php echo $msgclass; $mesgtrue=true; ?> alert alert-<?php echo $type; ?> alert-dismissible" role="<?php echo $type; ?>">
                        <a href="#close-alert" class="close" data-dismiss="alert"></a>
                        <?php foreach ($msgs as $msg) : ?>
                            <p>
                                <?php /* <strong class="alert-heading"><?php echo JText::_($type); ?>:</strong> */ ?>
                                <?php echo $msg; ?>
                            </p>
                        <?php endforeach; ?>
                    </div>


                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div> </div>
<?php

$displayData['msgList'] = array(); // hack for double messages

if ($mesgtrue==true){
    $doc->addScriptDeclaration("
if (typeof jQuery != 'undefined') jQuery(function ($) {
    var tmritrani;
        
   var hidesysm = function () {
        var fgh=$('#system-message .close');
        if( fgh.length===0) {
        clearInterval(tmritrani);
            return false;
        }
        fgh.closest('.alert').animate({
            height: 0,
            opacity: 0,
            MarginBottom: 0
        }, 'slow', function () {
            $('#system-message .alert').remove();
        });
        return false;
    };
    $('#system-message .close').click(hidesysm);
    tmritrani=  setInterval(hidesysm, 6000);
    
        });");
}


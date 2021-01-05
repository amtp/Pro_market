<?php
defined('_JEXEC') or die;
require dirname(__FILE__) . '/php/pro-portal.php';

?><?php echo $tpl->renderHTML(); ?>
<head>
    <jdoc:include type="head"/>
</head>
<body class="<?php echo $tpl->getBodyClasses(); ?>" id="page-print">

    <div class="component">
        
        <jdoc:include type="component" />
    </div>

    <?php if ($tpl->request('print')): ?>
        <script type="text/javascript">window.print();</script>
    <?php endif; ?>

</body></html>

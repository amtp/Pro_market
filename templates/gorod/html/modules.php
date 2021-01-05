<?php
defined('_JEXEC') or die;
function modChrome_top($module, &$params, &$attribs)
{
    if (!$module->content) {
        return;
    }
    echo "<div class=\"gruz_top" . htmlspecialchars($params->get('moduleclass_sfx')) . "\">";

    if ($module->showtitle) {
        echo "<h3><span class='". json_decode($module->params)->header_class . "'></span> <span>". $module->title . "</span></h3>";
    }

    echo $module->content;
    echo "</div>";
}

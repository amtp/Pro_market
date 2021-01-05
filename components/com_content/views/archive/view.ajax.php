
<?php

defined('_JEXEC') or die;


class ContentViewArticle extends JViewLegacy
{

    function display($tpl = null)
    {

        $app		= JFactory::getApplication();
        $user		= JFactory::getUser();
        $userId		= $user->get('id');

        $task = JRequest::getString('task');

        switch( $task ){

            case "getArticles":

                $this->_getArticles();

                break;

        }
        $app = &JFactory::getApplication();
        $app->close();
        jexit();

    }

    public function _getArticles(){

        $query = "SELECT title FROM #__content WHERE catid = 11 ORDER BY id DESC";

      //  $articlesList = JFactory::getDBO()->setQuery($query)->loadObjectList();

        $html = "";

        //foreach( $articlesList as $article ){

            $html .= '<div class="uk-margin">'. "dfadsa" .'</div>';

       // }

        echo '<div id="articles-container" class="articles-container">'.$html.'</div>';
        $app = &JFactory::getApplication();
        $app->close();
        jexit();

    }

}
?>
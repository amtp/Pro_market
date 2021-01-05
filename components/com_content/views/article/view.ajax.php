<?php
//E6D830DB-FA47-4D7C-8D6E-5BD09E037E98 Владивосток
defined('_JEXEC') or die;
require_once($_SERVER['DOCUMENT_ROOT'] . '/modules/medoo/cityes_model.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/modules/medoo/catalog_models.php');

class ContentViewArticle extends JViewLegacy
{
    protected $user;

    public function __construct()
    {
        $this->user = JFactory::getUser();
    }

    function display($tpl = null)
    {

        $userId = $this->user->get('id');
        $task = JRequest::getString('task');

        switch ($task) {

            case "getCityes":
                $this->_getCityes();
            case "CityesInRegion":
                $this->_CityesInRegion();
                break;
            case "findCityes":
                $this->_findCityes();
                break;
            case "SetCity":
                $this->_SetCity();
                break;
            case "findCompanys":
                $this->_findCompanys();
                break;
            case "getorgftr":
                $this->_Companyslist();
                break;

        }

        jexit();

    }

    public function _Companyslist()
    {
        $session = JFactory::getSession();
        $input = JFactory::getApplication()->input;
        $rresulrlist = array();
        $restxt = "";
        $citysclass = new cityclass();
        $f1 = $input->get('f1', 0, 'int');
        $f2 = $input->get('f2', 0, 'int');
        $is_new = $input->get('isnew', 0, 'int');
        $pgstart = $input->get('pstrt', 0, 'int');
        $catguid = $input->get('sgd', "", 'string');

        $cityid = $session->get('cityid', '00000000-0000-0000-0000-000000000000');
        $dlisttofile=array();
        $firmcat = new newcatalog();
        $cntr = 0;
        $firmlist = $firmcat->GetAllIn_cat($catguid, $cityid, $cntr, $pgstart, $f1, $f2);
        $domen = JUri::base();
        if (substr($domen, -1) == DIRECTORY_SEPARATOR)$domen = substr($domen,0,strlen($domen)-1);

        if ($firmlist != null) {
            foreach ($firmlist as $i => &$item) {

                $restxt .= '<div class="kat_item"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">';


                $objectField = new stdClass();
                $fortable     =new \Joomla\CMS\Mdata\MdataHelper($domen);
                $objectField->id = 103;
                $item->jcfields = $objectField;
                $item->fortable = $fortable;
               // $item->fortable->test();
                $layout = new JLayoutFile('catalog_item', JPATH_ROOT . '/templates/gorod/html/com_content/category');
                $restxt .= $layout->render($item);
               $dlisttofile[]=$item->fortable->getArray();



                $restxt .= '</div>';

            }
        }
        $rresulrlist['datahtml'] = $restxt;
        $rresulrlist['countl'] = $cntr;
        $rresulrlist['totable'] = $dlisttofile;
        echo json_encode($rresulrlist);
        jexit();
    }

    public function _SetCity()
    {
        $input = JFactory::getApplication()->input;
        $citysclass = new cityclass();

        $Suid = $input->get('fstid', "00000000-0000-0000-0000-000000000000", 'string');


        $Sname = $citysclass->GetCityNameforID($Suid);

        $session = JFactory::getSession();


        $session->set('cityname', $Sname["Name"]);
        $session->set('cityid', $Suid);
        $session->set('citynid', $Sname["id"]);

        if (!$this->user->guest) {
            $this->user->cityname = $Sname["Name"];// $session->get('cityname', 'Все города');
            $this->user->cityid = $Suid;// $session->get('cityid', '00000000-0000-0000-0000-000000000000');
            $this->user->citynid = $Sname["id"];// $session->get('citynid', '');
            $this->user->save();
        }
        //  $session->close();
        // $jcookie->set( 'cityid', $Suid,$stm);
        // $jcookie->set( $name = 'cityname', $value = $Sname ,$stm);

        echo "ok";
        jexit();
    }

    public function _CityesInRegion()
    {
        $session = JFactory::getSession();
        $input = JFactory::getApplication()->input;
        $citysclass = new cityclass();
        $Ruid = $input->get('region', "", 'string');
        $cityid = $session->get('cityid', '');
        $cityInRegionslist = $citysclass->GetCityInRegoinList($cityid, $Ruid);
        echo json_encode($cityInRegionslist);
        jexit();
    }

    public function _findCityes()
    {
        $session = JFactory::getSession();
        $input = JFactory::getApplication()->input;
        $searchtext = $input->get('stext', "", 'string');
        $cityid = $session->get('cityid', '');
        $searchtext = urldecode($searchtext);
        if (strlen($searchtext) > 15) {
            $articles = array();
            $articles["towns"] = '<span style="line-height: 30px;display: inline-block; color: #616161;">По запросу : <span style="font-weight: 600; color: #106d53;">"' . $searchtext . '"</span> ничего не найдено.</span>';;
            echo json_encode($articles);
            jexit();
        }
        $citysclass = new cityclass();
        $cityRegionslist = $citysclass->FindCity($cityid, $searchtext);
        echo json_encode($cityRegionslist);
        jexit();
    }

    public function _getCityes()
    {
        $session = JFactory::getSession();
        $cityid = $session->get('cityid', '');
        $citysclass = new cityclass();
        $cityRegionslist = $citysclass->GetCityList($cityid);
        echo json_encode($cityRegionslist);
        jexit();
    }

    public function _findCompanys()
    {
        $session = JFactory::getSession();
        $cityid = $session->get('cityid', '00000000-0000-0000-0000-000000000000');
        $input = JFactory::getApplication()->input;
        $searchtext = $input->get('stext', "", 'string');
        $searchtext = urldecode($searchtext);
        if (strlen($searchtext) > 30 || strlen($searchtext) < 3) {
            $articles = array();
            $articles["towns"] = '<span style="line-height: 30px;display: inline-block; color: #616161;">По запросу : <span style="font-weight: 600; color: #106d53;">"' . $searchtext . '"</span> ничего не найдено.</span>';;
            echo json_encode($articles);
            jexit();


        }

        $resultSearch = [];
        $resultSearch["finresult"] = "";
        $rnames = $this->getnames($searchtext, $cityid);
        $ruslg = $this->getulsugs($searchtext, $cityid);
        //$rnames=array();

        if ($rnames != array() || $ruslg != array()) {
            $text = '<table class="table table-condensed table-hover tfinder"><tbody>';

            if ($rnames != array()) {
                $text .= '<tr class="text-center"><td>Компании</td></tr>';
                foreach ($rnames as $item) {
                    $titl=	preg_replace("#($searchtext)#iu", '<span class="slect">'."$1</span>",  $item[0]);
                    $text .= '<tr><td onclick="' . "document.location ='/katalog/91784593210" . $item[1] . "';" . '">' . $titl. '</td></tr>';
                }

            } else  $text = 'Нет совпадений по названию компании';

            if ($ruslg != array()) {
                $text .= '<tr class="text-center"><td>Услуги/Товары</td></tr>';

                foreach ($ruslg as $item) {
                    $titl=	preg_replace("#($searchtext)#iu", '<span class="slect">'."$1</span>",  $item[0]);
                    $text .= '<tr><td onclick="' . "document.location ='/katalog?aname=" . $item[1] . "';" . '">' .$titl . '</td></tr>';
                }

            }
            $text .= '</tbody></table>';
        }else   $text = 'Совпадения не найденны';

        $resultSearch["finresult"] = $text;
        //$resultSearch["finresult"]=$this->getnames($searchtext,$cityid);

        echo json_encode($resultSearch);
        //  echo json_encode(print_r($rnames,true));
        jexit();
    }

    function getulsugs($sfind, $cityid)
    {
        $db = JFactory::getDboC();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('Name', 'rowguid')));
        $query->from($db->quoteName('Names'));

        if (!empty($sfind)) {
            $arrayNames = explode(' ', $sfind);
            foreach ($arrayNames as $str) {
                $query->where($db->quoteName('Name') . ' LIKE ' . $db->quote('%' . $str . '%'));
            }
        }
        $db->setQuery($query, 0, 5);
        $datas = $db->loadRowList();
        return $datas;
    }

    function getnames($sfind, $cityid)
    {

        $db = JFactory::getDboC();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('Official_Name', 'id', 'Color_Index')));
        $query->from($db->quoteName('Firms'));

        if (!empty($sfind)) {
            $arrayNames = explode(' ', $sfind);
            foreach ($arrayNames as $str) {
                $query->where($db->quoteName('Official_Name') . ' LIKE ' . $db->quote('%' . $str . '%'));
            }
        }

        $query->where('Color_Index <=3');
        if ($cityid != '00000000-0000-0000-0000-000000000000') {
            $query->where('Town_num =' . $db->quote($cityid));
        }

        $query->order('Color_Index ASC');

        $db->setQuery($query, 0, 5);

        // $query = $db->getQuery();
        //  return $query;
        // $str= $db->getQuery();
        //echo $str;
        //  jexit();
        // return $str;
        $datas = $db->loadRowList();
        return $datas;
    }
}

?>
<?php
namespace Joomla\CMS\Mdata;

defined('JPATH_PLATFORM') or die;
class MdataHelper
{
    private $Official_Name = "";
    private $adress = "";
    private $phone = "";
    private $WorkHours = "";
    private $URL = "";
    private $Email = "";
    private $sitelink = "https://516.ru";
    private $domian = "";

    public function __construct(string $domian) {
        $this->domian = $domian;
    }
    public function test()
    {
        die ('$this->Official_Name4');
    }

    public function setData($name, $addr,$phn, $whour, $urle, $mail, $slink)
    {
        $this->Official_Name = $name;
        $this->adress = $addr;
        $this->phone = $phn;
        $this->WorkHours = $whour;
        $this->URL = $urle;
        $this->Email = $mail;
        $this->sitelink =  $this->domian.$slink;
    }
    public function getArray()
    {
        $narr=array();
        $narr[]= $this->Official_Name;
        $narr[]=  $this->adress;
        $narr[]=  $this->phone ;
        $narr[]=  $this->WorkHours;
        $narr[]=  $this->URL;
        $narr[]=  $this->Email;
        $narr[]=  $this->sitelink ;
        return $narr;
    }
    public function getTR()
    {
        return '<tr><td>' . $this->Official_Name . '</td>
                <td>' . $this->adress . '</td>
                <td>' . $this->phone . '</td>
                <td>' . $this->WorkHours . '</td>
                <td>' . $this->URL . '</td>
                <td>' . $this->Email . '</td>
                <td>' . $this->sitelink . '</td></tr>';
    }
  public static function to_prepositional($str) {


        if (in_array( substr($str, -1), ['и','о','е','ё','э'])) return $str;
        if (in_array( substr($str, -3), ['ово','ево','ино','ыно'])) return $str;

        $custom_cities = [
            'Москва'=>'Москвы'
        ];
        if (isset($custom_cities[$str])) return $custom_cities[$str];

        $replace = array();
        $replace['2'][] = array('ия','ии');
        $replace['2'][] = array('ия','ии');
        $replace['2'][] = array('ий','ом');
        $replace['2'][] = array('ое','ом');
        $replace['2'][] = array('ая','ой');
        $replace['2'][] = array('ль','ле');
        $replace['1'][] = array('а','е');
        $replace['1'][] = array('о','е');
        $replace['1'][] = array('и','ах');
        $replace['1'][] = array('ы','ах');
        $replace['1'][] = array('ь','и');

        foreach ($replace as $length => $replacement) {
            $str_length = mb_strlen($str, 'UTF-8');
            $find = mb_substr($str, $str_length - $length, $str_length, 'UTF-8');
            foreach($replacement as $try) {
                if ( $find == $try[0] ) {
                    $str = mb_substr($str, 0, $str_length - $length, 'UTF-8');
                    $str .= $try['1'];
                    return $str;
                }
            }
        }
        if ($find == 'е') {
            return $str;
        } else {
            return $str.'е';
        }

    }
}

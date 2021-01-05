<?php

use Medoo\Medoo;

class cityclass
{
    public function url_encode($string){
        return urlencode(utf8_encode($string));
    }

    public function url_decode($string){
        return utf8_decode(urldecode($string));
    }
    public function GetCityNameforID($cityid)
    {
        global $database;
        $resu='nulcity';
         $data = $database->select("Towns", ["Name","id"], ["rowguid" => $cityid]);
          if ($data!=array())
             $resu=$data[0];
        return $resu ;
    }

        public function FindCity($cityid, $ftext)
    {

        global $database;
        $articles = array();
        $dattownactive = array();
        $articles["towns"] = "";
        $townactivid = $cityid;


        if ($ftext == "") {
            $dattownactive = $database->select("Towns", "*", ["rowguid" => $cityid]);
            if ( $dattownactive!=array()) {
                $dattown = $database->select("Towns", ["Name", "rowguid"], ["AND" => ["rowguid[!]" => $cityid]]);
                $articles["towns"] .= '<li class="last-in-top selected"><span class="' . $this->isT_bold($dattownactive[0]["rowguid"]) . '" style="line-height: 30px;display: inline-block;">' . $dattownactive[0]["Name"] . '</span></li>';
            } else {
                $dattown = $database->select("Towns", ["Name", "rowguid"], ["rowguid[!]" => $cityid]);
            }
        } else {
            $dattown = $database->select("Towns", ["Name", "rowguid"], ["Name[~]" => $ftext . "%"]);
        }
        foreach ($dattown as $valtown) {
            $slctd="";
            if($valtown["rowguid"]==$cityid)$slctd="selected";
            $articles["towns"] .= '<li class="last-in-top '.$slctd.'"><a href="javascript:void(0);" onclick="SetCity(\'' . $valtown["rowguid"] . '\');"    class="top-city "><span class="' . $this->isT_bold($valtown["rowguid"]) . '">' . $valtown["Name"] . '</span></a></li>';
        }
        if ( $dattown==array()) {
            $articles["towns"] = '<span style="line-height: 30px;display: inline-block; color: #616161;">По запросу : <span style="font-weight: 600; color: #106d53;">"' . $ftext . '"</span> ничего не найдено.</span>';

        }
        return $articles;
    }


    public function GetCityList($cityid)
    {

        global $database;
        $articles = array();
        $articles["regions"] = "";
        $articles["towns"] = "";
        $articles["regionfrst"] = "";
        $articles["townfrst"] = "";
        $regionactivid = "";
        $townactivid = $cityid;

        $dattownactive = $database->select("Towns", "*", ["rowguid" => $cityid]);

        if ( $dattownactive==array()) {
            $cityid="00000000-0000-0000-0000-000000000000";
            $dattownactive = $database->select("Towns", "*", ["rowguid" => $cityid]);
        }

        $datregionactiv = $database->select("Regions", "*", ["rowguid" => $dattownactive[0]["Region_Num"]]);
        if ( $datregionactiv!=array()) {
            $regionactivid = $datregionactiv[0]["rowguid"];
        }
        $datregion = $database->select("Regions", ["Name", "rowguid"], ["AND"=>["rowguid[!]" => $regionactivid,"rowguid[!]" => '00000000-0000-0000-0000-000000000000']]);


        if ( $dattownactive!=array()) {
            if($regionactivid!="00000000-0000-0000-0000-000000000000"){
                $dattown = $database->select("Towns", ["Name", "rowguid"], ["AND" => ["rowguid[!]" => $cityid, "Region_Num" => $regionactivid],"ORDER" => ["Name" => "ASC"]]);
            }else{
                $dattown = $database->select("Towns", ["Name", "rowguid"], ["rowguid[!]" => $cityid,"ORDER" => ["Name" => "ASC"]]);
            }

            // $articles["townfrst"]='<span class="last-in-top selected"><span style="line-height: 30px;display: inline-block;">'.$dattownactive[0]["Name"].'</span></span>';

            $articles["towns"] .= '<li class="last-in-top selected"><span class="' .$this->isT_bold($cityid) . '" style="line-height: 30px;display: inline-block;">' . $dattownactive[0]["Name"] . '</span></li>';
        } else {
            $dattown = $database->select("Towns", ["Name", "rowguid"], ["rowguid[!]" => $cityid,"ORDER" => ["Name" => "ASC"]]);
        }
        $i = 0;
        if ( $datregionactiv!=array()) {
            $i++;
            //$articles["regionfrst"]='<span class="regselected"><a href="#" data-id="'.$datregionactiv[0]["rowguid"].'" >'.$datregionactiv[0]["Name"].'</a></span>';
            $articles["regions"] .= '<li class="selected" id="regonnum'.$i.'"><a href="javascript:void(0);" class="' . $this->isR_bold($datregionactiv[0]["rowguid"]) . '"  onclick="chnjregion(this,\'' . $datregionactiv[0]["rowguid"] . '\');" >' . $datregionactiv[0]["Name"] . '</a></li>';
            if($datregionactiv[0]["rowguid"]!='00000000-0000-0000-0000-000000000000')
            {
                $i++;
                $articles["regions"] .= '<li class="" id="regonnum'.$i.'"><a href="javascript:void(0);" class=""  onclick="chnjregion(this,\'00000000-0000-0000-0000-000000000000\');" >Все города</a></li>';
            }
        }

        foreach ($datregion as $valregion) {
            $i++;
            $articles["regions"] .= '<li class="" style="" id="regonnum' . $i . '"  ><a href="javascript:void(0);" class="' . $this->isR_bold($valregion["rowguid"]) . '"  onclick="chnjregion(this,\'' . $valregion["rowguid"] . '\');"  >' . $valregion["Name"] . '</a></li>';
        }
        foreach ($dattown as $valtown) {
            $articles["towns"] .= '<li class="last-in-top"><a href="javascript:void(0);" onclick="SetCity(\'' . $valtown["rowguid"] . '\');" class="top-city "><span class="' . $this->isT_bold($valtown["rowguid"]) . '">' . $valtown["Name"] . '</span></a></li>';
        }
        return $articles;
    }
    public function GetCityInRegoinList($cityid,$ruid)
    {
        global $database;
        $articles = array();
        $articles["towns"] = "";

        if($ruid=='00000000-0000-0000-0000-000000000000')
        {
            $dattown = $database->select("Towns", ["Name", "rowguid"],["ORDER" => ["Name" => "ASC"]]);
        }else{
            $dattown = $database->select("Towns", ["Name", "rowguid"], ["Region_Num" => $ruid,"ORDER" => ["Name" => "ASC"]]);
        }

        foreach ($dattown as $valtown) {
            $slctd="";
            $rgid=$valtown["rowguid"];
            if($rgid==$cityid)$slctd="selected";

            $articles["towns"] .= '<li class="last-in-top '.$slctd.'"><a href="javascript:void(0);" onclick="SetCity(\'' . $rgid . '\');" class="top-city "><span class="' . $this->isT_bold($rgid) . '">' . $valtown["Name"] . '</span></a></li>';
        }
        return $articles;
    }


    protected function isR_bold($guid)
    {
        $clasbld = "";
        switch ($guid) {
            case "800D8E42-2917-41D3-89C3-0F191168BCDA":
                $clasbld = "bold";
                break;
        }
        return  $clasbld;
    }
    protected function isT_bold($guid)
    {
        $clasbld = "";
        switch ($guid) {
            case "E6D830DB-FA47-4D7C-8D6E-5BD09E037E98":
                $clasbld = "bold";
                break;
            case "FEB01130-4C36-4006-81F6-52F5CD64DD2C":
                $clasbld = "bold";
                break;
            case "0A674AF6-378E-4A52-932E-A27ACC16581A":
                $clasbld = "bold";
                break;
            case "BB2287A8-EB92-4CEE-A606-D09353452996":
                $clasbld = "bold";
                break;
            case "4E69AEB1-FC35-42A4-A313-F2A8B2158CCF":
                $clasbld = "bold";
                break;
        }
        return  $clasbld;
    }


}

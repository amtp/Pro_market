<?php
use Medoo\Medoo;

class newcatalog
{
    public $fieldstr="
                    [id] => 76,
                    [title] => Фото 3,
                    [name] => foto-3
                    [checked_out] => 0
                    [checked_out_time] => 0000-00-00 00:00:00
                    [note] => 
                    [state] => 1
                    [access] => 1
                    [created_time] => 2017-10-07 10:48:34
                    [created_user_id] => 399
                    [ordering] => 23
                    [language] => *
                    [fieldparams] => Joomla\Registry\Registry Object
                        (
                            [data:protected] => stdClass Object
                                (
                                    [filter] => 
                                    [maxlength] => 
                                )

                            [initialized:protected] => 1
                            [separator] => .
                        )

                    [params] => Joomla\Registry\Registry Object
                        (
                            [data:protected] => stdClass Object
                                (
                                    [hint] => 
                                    [render_class] => 
                                    [class] => 
                                    [showlabel] => 1
                                    [show_on] => 
                                    [display] => 2
                                )

                            [initialized:protected] => 1
                            [separator] => .
                        )

                    [type] => text
                    [default_value] => 
                    [context] => com_content.article
                    [group_id] => 11
                    [label] => Фото 3
                    [description] => 
                    [required] => 0
                    [language_title] => 
                    [language_image] => 
                    [editor] => 
                    [access_level] => Public
                    [author_name] => Super User
                    [group_title] => Галерея
                    [group_access] => 1
                    [group_state] => 1
                    [group_note] => 
                    [value] => 
                    [rawvalue] => ";

    protected  function GetTreeDown($mcatid)
    {



        global $database;
        $data5 =  $database->query("  WITH    C([rowguid], [Owner_Num]) AS
(
    SELECT  [rowguid], [Owner_Num]
    FROM  [516516_General_Data].[dbo].[Classifier] e
    WHERE e.[rowguid] = :guid 
    UNION ALL
    SELECT e.[rowguid], e.[Owner_Num]
    FROM [516516_General_Data].[dbo].[Classifier] e
        JOIN C r ON e.[Owner_Num] = r.[rowguid]
)
SELECT * FROM C",[":guid" => $mcatid])->fetchAll();
        if(count($data5)>0){
            $cotderevo= array();
            foreach($data5 as $data)
            {
                $cotderevo[]=$data["rowguid"];
            }
            $data5=$cotderevo;
        }else{$data5=$mcatid;}

        return $data5;
    }


    protected $catid;
   // protected $cityid="E6D830DB-FA47-4D7C-8D6E-5BD09E037E98";


//$nameid-товар услуга
//$cityid- город
//$cont- вернуть общее количество
//$pstart - с какой по счёту начать
//$plimit лимит списка
//$f1 color 0-all, 1-is green
//$f2 город 0-мой город 1-все города
//$fst использован фильтр впервые, показать с первой позиции

    public function GetAllIn_cat($catid,$cityid,&$cont,$pstart=0,$f1=0,$f2=0)
    {
        $plimit=15;
        //if($catid=='katalog-organizatsij')return null;
        $cont=100;
       // $catid='00000000-0000-0000-0000-000000000000';
        $dat0 =   $this->GetTreeDown($catid);
if($dat0=='katalog-organizatsij')return null;
        $db = JFactory::getDboC();

        $query = $db->getQuery(true);
        $query->select('_Firms.Official_Name AS Official_Name ,
            _Firms.Counter AS counter,
            _Firms.rowguid AS rowguid,
            _Firms.Street_num AS Street_num,
            _Firms.id AS nid,
            _Firms.URL AS URL,
            _Firms.Town_num AS Town_num,
            _Firms.WorkHours AS WorkHours,
            _Firms.Email AS Email,
            _Firms.Office AS Office,
            _Firms.Home AS Home,
            _Firms.Color_Index AS Color_Index');
        $query->from('Firms AS _Firms');
        $query->select('MIN(ISNULL(_Price3.prioritet,4)) AS prioritet, MIN(ISNULL(_Price3.townprioritet,4)) AS townprioritet')
            ->join('LEFT', $db->quoteName('Price3') . ' AS _Price3 ON _Price3.firm_num = _Firms.rowguid');

        $query->join('LEFT', $db->quoteName('Object_Classes') . ' AS o ON o.Class_Num IN ('."'" .implode("', '", $dat0)."'".')');
//if(count($dat0)>1){
    $query->where('(_Firms.rowguid IN (o.Object_Num))');
//}

        if($f1==1)
            $query->where('_Firms.Color_Index =1');
            else
        $query->where('_Firms.Color_Index <=8');

        if($cityid!='00000000-0000-0000-0000-000000000000' && $f2==0) {
            $query->where('_Firms.Town_num ='.$db->quote($cityid));
        }

        $query->order('_Price3.townprioritet ASC, _Price3.prioritet ASC, Color_Index ASC');
        $query->group('_Firms.Official_Name,
            _Firms.rowguid,
            _Firms.Street_num,
            _Firms.Counter,
            _Firms.id,
            _Firms.Town_num,
            _Firms.WorkHours,
            _Firms.Email,
            _Firms.URL,
            _Firms.Office,
            _Firms.Home,
            _Firms.Color_Index'
        );

         $db->setQuery($query);
        $my_count = $db->query();
         $cont = $db->getNumRows();

       // $query->to
        $db->setQuery($query,$pstart,$plimit);
        $datas= $db->loadObjectList();

       // print_r($datas);
        return $datas ;
    }
//$nameid-товар услуга
//$cityid- город
//$cont- вернуть общее количество
//$pstart - с какой по счёту начать
//$plimit лимит списка
//$f1 color 0-all, 1-is green
//$f2 город 0-мой город 1-все города
//$fst использован фильтр впервые, показать с первой позиции
    public function GetAllIn_name($nameid,$cityid,&$cont,$pstart=0,$f1=0,$f2=0)
    {
        $plimit=15;
        //if($catid=='katalog-organizatsij')return null;
        $cont=100;
        // $catid='00000000-0000-0000-0000-000000000000';

      //  if($dat0=='katalog-organizatsij')return null;
        $db = JFactory::getDboC();




        $query = $db->getQuery(true);
        $query->select('_Firms.Official_Name AS Official_Name ,
            _Firms.Counter AS counter,
            _Firms.rowguid AS rowguid,
            _Firms.Street_num AS Street_num,
            _Firms.id AS nid,
            _Firms.URL AS URL,
            _Firms.Town_num AS Town_num,
            _Firms.WorkHours AS WorkHours,
            _Firms.Email AS Email,
            _Firms.Office AS Office,
            _Firms.Home AS Home,
            _Firms.Color_Index AS Color_Index');
        $query->from('Firms AS _Firms');
        $query->select('MIN(ISNULL(_Price3.prioritet,3)) AS prioritet, MIN(ISNULL(_Price3.townprioritet,3)) AS townprioritet')
            ->join('LEFT', $db->quoteName('Price3') . ' AS _Price3 ON _Price3.firm_num = _Firms.rowguid')
            ->join('LEFT', $db->quoteName('Price3') . ' AS o ON o.Reference1 = '.$db->quote($nameid));
//if(count($dat0)>1){
        $query->where('(_Firms.rowguid IN (o.firm_num))');
//}

        if($f1==1)
            $query->where('_Firms.Color_Index =1');
        else
        $query->where('_Firms.Color_Index <=8
        ');

        if($cityid!='00000000-0000-0000-0000-000000000000' && $f2==0) {
            $query->where('_Firms.Town_num ='.$db->quote($cityid));
        }

        $query->order('_Price3.townprioritet ASC, _Price3.prioritet ASC, Color_Index ASC');
        $query->group('_Firms.Official_Name,
            _Firms.rowguid,
            _Firms.Street_num,
            _Firms.Counter,
            _Firms.id,
            _Firms.Town_num,
            _Firms.WorkHours,
            _Firms.Email,
            _Firms.URL,
            _Firms.Office,
            _Firms.Home,
            _Firms.Color_Index'
        );

        $db->setQuery($query);
        $my_count = $db->query();
        $cont = $db->getNumRows();

        // $query->to
        $db->setQuery($query,$pstart,$plimit);
        $datas= $db->loadObjectList();

        // print_r($datas);
        return $datas ;
    }
// echo  $datas ;
//  var_dump( $database->error() );
}


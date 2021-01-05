<?php

class Table_item
{
    private $Official_Name = "";
    private $adress = "";
    private $WorkHours = "";
    private $URL = "";
    private $Email = "";
    private $sitelink = "https://516.ru";


    public function setData($name, $addr, $whour, $urle, $mail,$slink)
    {
        $this->Official_Name = $name;
        $this->adress = $addr;
        $this->WorkHours = $whour;
        $this->URL = $urle;
        $this->Email = $mail;
        $this->sitelink = $slink;
    }

    public function getTR()
    {
        return '<tr><td>' . $this->Official_Name . '</td>
                <td>' . $this->adress . '</td>
                <td>' . $this->WorkHours . '</td>
                <td>' . $this->URL . '</td>
                <td>' . $this->Email . '</td>
                <td>' . $this->sitelink . '</td></tr>';
    }
}


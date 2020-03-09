<?php
namespace PpMiniblog\Classes;

class MiniBlogCategory
{
    public function getCategorys()
    {
        $sql_category = 'SELECT * FROM '._DB_PREFIX_.'pp_miniblog_category';
        $categorys = \Db::getInstance()->ExecuteS($sql_category);
        return $categorys;
    }
}
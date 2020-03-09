<?php
namespace PpMiniblog\Classes;

class MiniBlogTag
{
    public function getTagsNamesById($id_tags)
    {
        $id_tags = json_decode($id_tags);
        foreach($id_tags as $id_tag)
        {
            $tags[]  = \Db::getInstance()->getValue("SELECT tag FROM "._DB_PREFIX_."pp_miniblog_tag WHERE id_tag = ".(int)$id_tag);
        }
        return $tags;
    }
}
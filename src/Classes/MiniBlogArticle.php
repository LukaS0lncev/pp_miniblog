<?php
namespace PpMiniblog\Classes;

class MiniBlogArticle
{
    public function getArticles()
    {
        $db = \Db::getInstance();
        $context = \Context::getContext();
        $sql_article = 'SELECT * FROM '._DB_PREFIX_.'pp_miniblog_article';
        $articles = \Db::getInstance()->ExecuteS($sql_article);
        $categorys = MiniBlogCategory::getCategorys();
        
        foreach($articles as &$article)
        {
            $tags = array();
            $sql_get_category_name = "SELECT name FROM "._DB_PREFIX_."pp_miniblog_category WHERE id_category = ".(int)$article['id_category'];
            
            if (\Db::getInstance()->execute($sql_get_category_name))
            {
                $category_name = \Db::getInstance()->getValue($sql_get_category_name);
                $article['category'] = $category_name; 
            }
            else
            {
                $article['category'] = '';
            }

            $tags = json_decode($article['tags']);
            foreach($tags as $id_tag)
            {
                $tags[]  = \Db::getInstance()->getValue("SELECT tag FROM "._DB_PREFIX_."pp_miniblog_tag WHERE id_tag = ".(int)$id_tag);
            }
            $article['tags'] = $tags;
        }

        return $articles;
    }

}
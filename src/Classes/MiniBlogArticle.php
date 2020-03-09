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

            $tags = MiniBlogTag::getTagsNamesById($article['tags']);

            $article['tags'] = $tags;
        }

        return $articles;
    }

    public function getArticleById($id_article)
    {
        $article_array = \Db::getInstance()->executeS("SELECT * FROM "._DB_PREFIX_."pp_miniblog_article WHERE id_article = ".(int)$id_article);
        $article = $article_array[0];
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

        $tags = MiniBlogTag::getTagsNamesById($article['tags']);
        $article['tags'] = $tags;
        return $article;
    }

}
<?php
namespace PpMiniblog\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Form\Admin\Type\MaterialChoiceTreeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ArticleController extends FrameworkBundleAdminController
{
    public function indexArticle()
    {
        $articles = $this->getArticles();
        $categorys = $this->getCategorys();
        $link = New \Link();

        $form_link_add =  $link->getAdminLink('PpMiniblogArticleController', true, [], ['action' => 'add']);
        $form_link_button_active =  $link->getAdminLink('PpMiniblogArticleController', true, [], ['action' => 'form_link_button_active']);
        $form_link_delete =  $link->getAdminLink('PpMiniblogArticleController', true, [], ['action' => 'delete']);
        $form_link_edit=  $link->getAdminLink('PpMiniblogArticleController', true, [], ['action' => 'edit']);
        return $this->render('@Modules/pp_miniblog/templates/admin/article/card.html.twig',
        array(
            'articles' => $articles,
            'categorys' => $categorys,
            'form_link_add' => $form_link_add,
            'form_link_button_active' => $form_link_button_active,
            'form_link_delete' => $form_link_delete,
            'form_link_edit' => $form_link_edit,
        ));

    }

    public function addArticle()
	{


            $tags = $_POST['article_tags'];
            $article_tags_json = $this->checkTags($tags);

            $title = $_POST['article_title'];
            $article = $_POST['article_article'];
            if(empty($_POST['article_slug']))
            {
                $slug = ToolsController::getUrlSlug($_POST['article_title'], array('transliterate' => true));
            }
            else
            {
                $slug = ToolsController::getUrlSlug($_POST['article_slug'], array('transliterate' => true));
            }

            $id_category = $_POST['article_category'];
            \Db::getInstance()->insert('pp_miniblog_article', array(
                'title'      => pSQL($title),
                'slug'      => pSQL($slug),
                'article'   => pSQL($article),
                'active'    => 1,
                'id_category'    => (int)$id_category,
                'tags'      => $article_tags_json,
                'date_add'  => date("Y-m-d H:i:s")
            ));
            

            return $this->indexArticle();

	}

    public function deleteArticle()
	    {
            $id_article = $_POST['id_article'];
            \Db::getInstance()->delete('pp_miniblog_article', 'id_article = '.$id_article);
            return $this->indexArticle();

	    }

    public function editArticle()
	    {
            dump('editCategory');
            die;
            $id_article = $_POST['id_article'];
            \Db::getInstance()->delete('pp_miniblog_article', 'id_article = '.$id_article);
            return $this->indexArticle();

	    }

    public function buttonActive()
    {
            $id_article = $_POST['id_article'];
            $active = $_POST['button_active'];

            \Db::getInstance()->update('pp_miniblog_article', array(
                'active'      => (int)($active),
            ),
            'id_article = '.$id_article
        );
            return $this->indexArticle();
    }

    public function checkTags($tags)
    {
        $tags_array = explode(',', $tags);
        $tags_array = array_map('trim', $tags_array);
        $tags_id_array = array();

        foreach($tags_array as $tag)
        {
            $sql_search_tag = "SELECT id_tag FROM "._DB_PREFIX_."pp_miniblog_tag WHERE tag = '".$tag."'";
            if ($sql_search_results = \Db::getInstance()->ExecuteS($sql_search_tag))
            {
                $tags_id_array[] = \Db::getInstance()->getValue($sql_search_tag);
            }
            else
            {
                \Db::getInstance()->insert('pp_miniblog_tag', array(
                    'tag'      => pSQL($tag),
                ));
               // \Db::getInstance()->getValue('SELECT id_tag FROM '._DB_PREFIX_.'pp_miniblog_tag WHERE tag = '.$tag.' ORDER BY id_tag');
                $tags_id_array[] = \Db::getInstance()->getValue($sql_search_tag);
            }
        }
        return json_encode($tags_id_array, JSON_UNESCAPED_UNICODE);
    }

    public function getArticles()
    {
        $db = \Db::getInstance();
        $context = \Context::getContext();
        $sql_article = 'SELECT * FROM '._DB_PREFIX_.'pp_miniblog_article';
        $articles = \Db::getInstance()->ExecuteS($sql_article);
        $categorys = $this->getCategorys();
        
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

    public function getCategorys()
    {
        $sql_category = 'SELECT * FROM '._DB_PREFIX_.'pp_miniblog_category';
        $categorys = \Db::getInstance()->ExecuteS($sql_category);
        return $categorys;
    }
}
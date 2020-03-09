<?php

use PpMiniblog\Classes\MiniBlogArticle;
use PpMiniblog\Classes\MiniBlogCategory;
use PpMiniblog\Classes\MiniBlogTools;

class pp_miniblogPostModuleFrontController extends ModuleFrontController
{
    public function initContent()
        {
            parent::initContent();
            
            $id_post = Tools::getValue('id_post');
            $post = MiniBlogArticle::getArticleById($id_post);
            $categories = MiniBlogCategory::getCategorys();
            $id_lang = Context::getContext()->language->id;
            $id_shop = Context::getContext()->shop->id;
            $link = new Link();
            $comments = MiniBlogArticle::getCommentsArticleById($id_post);

            $this->context->smarty->assign(array(
                'post' => $post,
                'categories' => $categories,
                'link' => $link,
                'comments' => $comments
            ));
            $template_name = 'module:pp_miniblog/templates/front/article/post.tpl';
            $this->setTemplate($template_name);
        }

    public function postProcess()
    {

        if(Tools::isSubmit('CommentSubmit'))
        {
            $comment = Tools::getValue('comment');
            $id_article = Tools::getValue('id_post');
            
            Db::getInstance()->insert('pp_miniblog_comment', array(
                'id_article' => (int)$id_article,
                'comment'      => pSQL($comment),
            ));
            Tools::redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
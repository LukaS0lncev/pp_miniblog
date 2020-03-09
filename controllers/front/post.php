<?php

use PpMiniblog\Classes\MiniBlogArticle;
use PpMiniblog\Classes\MiniBlogCategory;

class pp_miniblogPostModuleFrontController extends ModuleFrontController
{
    public function initContent()
        {
            parent::initContent();
            
            $post = MiniBlogArticle::getArticleById(Tools::getValue('id_post'));
            $categories = MiniBlogCategory::getCategorys();
            //dump($post);
            //dump($categories);
            $this->context->smarty->assign(array(
                'post' => $post,
                'categories' => $categories
            ));

            $template_name = 'module:pp_miniblog/templates/front/article/post.tpl';
            $this->setTemplate($template_name);
        }
}
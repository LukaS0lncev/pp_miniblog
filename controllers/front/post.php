<?php

use PpMiniblog\Classes\MiniBlogArticle;
use PpMiniblog\Classes\MiniBlogCategory;
use PpMiniblog\Classes\MiniBlogTools;

class pp_miniblogPostModuleFrontController extends ModuleFrontController
{
    public function initContent()
        {
            parent::initContent();
            
           // $url_miniblog = MiniBlogTools::getMiniBlogUrl();
            $id_post = Tools::getValue('id_post');
            $post = MiniBlogArticle::getArticleById($id_post);
            $categories = MiniBlogCategory::getCategorys();
            $id_lang = Context::getContext()->language->id;
            $id_shop = Context::getContext()->shop->id;
            /*
            $params = array(
                'id_post' => $id_post,
                'slug' => $post['slug']
            );
            */
            /*
            $dispatcher = Dispatcher::getInstance();
            $post_create_url =  $dispatcher->createUrl(
                'miniblog_post_rule',
                $id_lang,
                $params,
                $force_routes = false,
                $anchor = '',
                $id_shop
            );
            */
            $post_url = $url_miniblog.$post_create_url;
            //dump($post_url);
            //die;
            $this->context->smarty->assign(array(
                'post' => $post,
                'categories' => $categories
            ));

           // parent::canonicalRedirection($post_url);
            $template_name = 'module:pp_miniblog/templates/front/article/post.tpl';
            $this->setTemplate($template_name);
        }
}
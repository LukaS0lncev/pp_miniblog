<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
use PpMiniblog\Classes\MiniBlogArticle;
use PpMiniblog\Classes\MiniBlogCategory;
use PpMiniblog\Classes\MiniBlogTools;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Pp_miniblog extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'pp_miniblog';
        $this->tab = 'administration';
        $this->version = '1.0.11';
        $this->author = 'LukaSolncev';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Mini Blog');
        $this->description = $this->l('Mini Blog for PrestaShop');

        $this->confirmUninstall = $this->l('');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayBanner') &&
            $this->registerHook('moduleRoutes') &&
            $this->registerHook('displayHome') && 
            $this->installTab();
    }

    public function uninstall()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');
       // return parent::uninstall();
        return parent::uninstall() &&
        	$this->uninstallTab();
    }

     public function enable($force_all = false)
    {
        return parent::enable($force_all)
            && $this->installTab()
        ;
    }

    public function disable($force_all = false)
    {
        return parent::disable($force_all)
            && $this->uninstallTab()
        ;
    }

    private function installTab()
    {
        //Создаем Родительский Tab
        $langs = Language::getLanguages();

        $tabId = (int) Tab::getIdFromClassName('AdminPpMiniBlog');
        if (!$tabId) {
            $tabId = null;
        }

        $miniblog_tab_parent = new Tab($tabId);
        $miniblog_tab_parent->class_name = "AdminPpMiniBlog";
        $miniblog_tab_parent->module = "";
        $miniblog_tab_parent->id_parent = 0;
        foreach ($langs as $l) {
            $miniblog_tab_parent->name[$l['id_lang']] = $this->l('Mini Blog');
        }
        
        $miniblog_tab_parent->save();
        $tab_parent_id = $miniblog_tab_parent->id;

        //Создаем дочерний Tab PpMiniblogCategoryController начало
        $tabId = (int) Tab::getIdFromClassName('PpMiniblogCategoryController');
        if (!$tabId) {
            $tabId = null;
        }
        
        $tab = new Tab($tabId);
        $tab->active = 1;
        $tab->class_name = 'PpMiniblogCategoryController';
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
                    $tab->name[$lang['id_lang']] = 'Category blog';
        }
        $tab->id_parent = (int) $tab_parent_id;
        $tab->module = $this->name;
        $tab->save();
        //Создаем дочерний Tab PpMiniblogCategoryController Конец

        //Создаем дочерний Tab PpMiniblogCategoryController начало
                $tabId = (int) Tab::getIdFromClassName('PpMiniblogArticleController');
                if (!$tabId) {
                    $tabId = null;
                }
                
                $tab = new Tab($tabId);
                $tab->active = 1;
                $tab->class_name = 'PpMiniblogArticleController';
                $tab->name = array();
                foreach (Language::getLanguages() as $lang) {
                            $tab->name[$lang['id_lang']] = 'Article blog';
                }
                $tab->id_parent = (int) $tab_parent_id;
                $tab->module = $this->name;
                $tab->save();
        //Создаем дочерний Tab PpMiniblogCategoryController Конец

        return true;
    }

    private function uninstallTab()
    {
        $tab_id[]  = (int) Tab::getIdFromClassName('AdminPpMiniBlog');
        $tab_id[] = (int) Tab::getIdFromClassName('PpMiniblogCategoryController');
        $tab_id[] = (int) Tab::getIdFromClassName('PpMiniblogArticleController');
        if (!$tab_id) {
            return true;
        }
        foreach($tab_id as $id){
            $tab = new Tab($id);
            $tab->delete();
        }

        return true;
    }



    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'views/js/owl_carousel/owl.carousel.js');
        $this->context->controller->addJS($this->_path.'views/js/front.js');
        $this->context->controller->addCSS($this->_path.'views/css/owl_carousel/owl.carousel.min.css');
        $this->context->controller->addCSS($this->_path.'views/css/owl_carousel/owl.theme.default.min.css');
        $this->context->controller->addCSS($this->_path.'views/css/owl_carousel/owl.theme.default.min.css');
        $this->context->controller->addCSS($this->_path.'views/css/front.css');
    }

    public function hookDisplayBanner()
    {
        /* Place your code here. */
    }

    public function hookDisplayHome()
    {
        $Article = new PpMiniblog\Controller\ArticleController;
        $articles =  $Article->getArticles();

        $link = new Link;
        $params = array(
            'id_post' => 1,
            'id_cat' => 2
        );
        $url = $link->getModuleLink('pp_miniblog', 'front', $params);
        $miniblog_tools = new MiniBlogTools;
        $id_lang = Context::getContext()->language->id;
        $id_shop = Context::getContext()->shop->id;
        //dump($url);
        //die;

        $this->context->smarty->assign(array(
            'articles' => $articles,
            'link' => $link,
            'miniblog_tools' =>$miniblog_tools,
            'id_lang' => $id_lang,
            'id_shop' => $id_shop
        ));
        return $this->context->smarty->fetch(_PS_MODULE_DIR_.'pp_miniblog/templates/front/hook/displayHome.tpl');
    }

    public function hookModuleRoutes($params){
        $my_link = array(
            'miniblog_post_rule' => array(
                'controller' => 'post',

                'rule' => 'blog' . '/{id_post}_{slug}' . '.html',
                'keywords' => array(
                    'id_post' => array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'id_post'),
                    'slug' => array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'slug'),
                 ),
                 'params' => array(
                     'fc' => 'module',
                     'module' => 'pp_miniblog'
                 )
             )
          );
          return $my_link;
      }
}

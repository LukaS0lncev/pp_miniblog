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
        $this->version = '1.0.6';
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
        Configuration::updateValue('PP_MINIBLOG_LIVE_MODE', false);

        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->installTab() && 
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayBanner');
    }

    public function uninstall()
    {
        Configuration::deleteByName('PP_MINIBLOG_LIVE_MODE');

        include(dirname(__FILE__).'/sql/uninstall.php');

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
        //$tabIdParent = (int) Tab::getIdFromClassName('PpMiniblogDemoController');
        //Создаем Родительский Tab
        $langs = Language::getLanguages();
        $miniblog_tab_parent = new Tab();
        $miniblog_tab_parent->class_name = "AdminPpMiniBlog";
        $miniblog_tab_parent->module = "";
        $miniblog_tab_parent->id_parent = 0;
        foreach ($langs as $l) {
            $miniblog_tab_parent->name[$l['id_lang']] = $this->l('Mini Blog');
        }
        
        $miniblog_tab_parent->save();
        $tab_parent_id = $miniblog_tab_parent->id;

        //Создаем дочерний Tab PpMiniblogCategoryController начало
        $tabId = (int) Tab::getIdFromClassName('PpMiniblogCategoryControllerr');
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
                $tabId = (int) Tab::getIdFromClassName('PpMiniblogArticleControllerr');
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
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitPp_miniblogModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch(_PS_MODULE_DIR_.'pp_miniblog/views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitPp_miniblogModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'PP_MINIBLOG_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'PP_MINIBLOG_ACCOUNT_EMAIL',
                        'label' => $this->l('Email'),
                    ),
                    array(
                        'type' => 'password',
                        'name' => 'PP_MINIBLOG_ACCOUNT_PASSWORD',
                        'label' => $this->l('Password'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'PP_MINIBLOG_LIVE_MODE' => Configuration::get('PP_MINIBLOG_LIVE_MODE', true),
            'PP_MINIBLOG_ACCOUNT_EMAIL' => Configuration::get('PP_MINIBLOG_ACCOUNT_EMAIL', 'contact@prestashop.com'),
            'PP_MINIBLOG_ACCOUNT_PASSWORD' => Configuration::get('PP_MINIBLOG_ACCOUNT_PASSWORD', null),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
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
        //dump($url);
        //die;
        $this->context->smarty->assign(array(
            'articles' => $articles,
            'link' => $link
        ));
        return $this->context->smarty->fetch(_PS_MODULE_DIR_.'pp_miniblog/templates/front/hook/displayHome.tpl');


    }
}

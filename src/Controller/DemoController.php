<?php
namespace PpMiniblog\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
//use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
//use PrestaShop\PrestaShop\Adapter\Shop\Context;
class DemoController extends FrameworkBundleAdminController
{
    public function demoAction()
    {

        //dump('test');
        //die;
        return $this->render('@Modules/pp_miniblog/templates/admin/demo.html.twig');

    }
/*
    public function demoAction()
    {

        $content = $this->renderForm();

        $context = new Context();
        dump($context->getShops());
        die;
        //$context->smarty->assign(array('content' => $content));
    }
    */
/*
    public function renderForm()
    {
        $fields_value = array(
            'type_text' => 'with value',
            'type_text_readonly' => 'with value that you can\'t edit',
            'type_switch' => 1,
            'days' => 17,
            'months' => 3,
            'years' => 2014,
            'groupBox_1' => false,
            'groupBox_2' => true,
            'groupBox_3' => false,
            'groupBox_4' => true,
            'groupBox_5' => true,
            'groupBox_6' => false,
            'type_color' => '#8BC954',
            'tab_note' => 'The tabs are always pushed to the top of the form, wherever they are in the fields_form array.',
            'type_free' => '<p class="form-control-static">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc lacinia in enim iaculis malesuada. Quisque congue fermentum leo et porta. Pellentesque a quam dui. Pellentesque sed augue id sem aliquet faucibus eu vel odio. Nullam non libero volutpat, pulvinar turpis non, gravida mauris. Nullam tincidunt id est at euismod. Quisque euismod quam in pellentesque mollis. Nulla suscipit porttitor massa, nec eleifend risus egestas in. Aenean luctus porttitor tempus. Morbi dolor leo, dictum id interdum vel, semper ac est. Maecenas justo augue, accumsan in velit nec, consectetur fringilla orci. Nunc ut ante erat. Curabitur dolor augue, eleifend a luctus non, aliquet a mi. Curabitur ultricies lectus in rhoncus sodales. Maecenas quis dictum erat. Suspendisse blandit lacus sed felis facilisis, in interdum quam congue.<p>',
        );

        $fields_form = array(
            'legend' => array(
                'title' => 'patterns of helper form.tpl',
                'icon' => 'icon-edit',
            ),
            'tabs' => array(
                'small' => 'Small Inputs',
                'large' => 'Large Inputs',
            ),
            'description' => 'You can use image instead of icon for the title.',
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => 'simple input text',
                    'name' => 'type_text',
                ),
                array(
                    'type' => 'text',
                    'label' => 'input text with desc',
                    'name' => 'type_text_desc',
                    'desc' => 'desc input text',
                ),
                
            ),
            'submit' => array(
                'title' => 'Save',
            ),
            'buttons' => array(),
        );

        return $fields_form;
        //return parent::renderForm();
    }
    */
}
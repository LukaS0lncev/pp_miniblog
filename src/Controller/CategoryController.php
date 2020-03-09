<?php
namespace PpMiniblog\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Form\Admin\Type\MaterialChoiceTreeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use PpMiniblog\Classes\MiniBlogArticle;
use PpMiniblog\Classes\MiniBlogCategory;
use PpMiniblog\Classes\MiniBlogTools;

class CategoryController extends FrameworkBundleAdminController
{
    public function indexCategory()
    {
        $db = \Db::getInstance();
        $context = \Context::getContext();
        $categorys = MiniBlogCategory::getCategorys();
        
        $link = New \Link();

        $form_link_add =  $link->getAdminLink('PpMiniblogCategoryController', true, [], ['action' => 'add']);
        $form_link_button_active =  $link->getAdminLink('PpMiniblogCategoryController', true, [], ['action' => 'form_link_button_active']);
        $form_link_delete =  $link->getAdminLink('PpMiniblogCategoryController', true, [], ['action' => 'delete']);
        $form_link_edit=  $link->getAdminLink('PpMiniblogCategoryController', true, [], ['action' => 'edit']);
        return $this->render('@Modules/pp_miniblog/templates/admin/category/index.html.twig',
        array(
            'categorys' => $categorys,
            'form_link_add' => $form_link_add,
            'form_link_button_active' => $form_link_button_active,
            'form_link_delete' => $form_link_delete,
            'form_link_edit' => $form_link_edit,
        ));

    }


    public function addCategory()
	{
            $name = $_POST['category_name'];
            if(empty($_POST['category_slug']))
            {
                $slug = MiniBlogTools::getUrlSlug($_POST['category_name'], array('transliterate' => true));
            }
            else
            {
                $slug = MiniBlogTools::getUrlSlug($_POST['category_slug'], array('transliterate' => true));
            }
            
            
            \Db::getInstance()->insert('pp_miniblog_category', array(
                'name'      => pSQL($name),
                'slug'      => pSQL($slug),
                'active'    => 1,
            ));
            return $this->indexCategory();

	}

    public function deleteCategory()
	    {
            $id_category = $_POST['id_category'];
            \Db::getInstance()->delete('pp_miniblog_category', 'id_category = '.$id_category);
            return $this->indexCategory();

	    }

    public function editCategory()
	    {
            dump('editCategory');
            die;
            $id_category = $_POST['id_category'];
            \Db::getInstance()->delete('pp_miniblog_category', 'id_category = '.$id_category);
            return $this->indexCategory();

	    }

    public function buttonActive()
    {
            $id_category = $_POST['id_category'];
            $active = $_POST['button_active'];

            \Db::getInstance()->update('pp_miniblog_category', array(
                'active'      => (int)($active),
            ),
            'id_category = '.$id_category
        );
            return $this->indexCategory();
    }


}
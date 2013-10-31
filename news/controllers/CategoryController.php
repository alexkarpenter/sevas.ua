<?php

class CategoryController extends Controller
{
    public function actionViewCategories()
    {
        $dataProvider = new CActiveDataProvider('NewsCategory', array(

            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        $this->render('kriminal.views.category.list_edite', array('dataProvider' => $dataProvider));
    }

    public function actionCreateCategory()
    {
        $root_id = NewsCategory::model()->findAll(array(
            'select' => 'root',
            'distinct' => true,
        ));
        $model = NewsCategory::model()->findAll(array('order' => 'lft'));
        $criteria = new CDbCriteria;
        $criteria->order = 't.lft'; // or 't.root, t.lft' for multiple trees
        $categories = NewsCategory::model()->findAll($criteria);

        $checked_cat = $_GET['checked_cat'];
        $category_name = $_GET['category_name'];
        $cnc = $_GET['cnc'];
        if (Yii::app()->request->isAjaxRequest) {
            if ($checked_cat != 'root') {
                $category = new NewsCategory;
                $category->url = $cnc;
                $category->name = $category_name;
                $category->root = $checked_cat;
                $edit_root = NewsCategory::model()->findByPk($checked_cat);
                $category->appendTo($edit_root);
            } else {
                $root = new NewsCategory;
                $root->name = $category_name;
                $root->url = $cnc;
                $root->saveNode();
            }
        }
        $this->render('kriminal.views.category.create', array('model' => $model, 'categories' => $categories, 'category_name' => $category_name));
    }

    public function actionEditeCategory()
    {
        $root_id = NewsCategory::model()->findAll(array(
            'select' => 'root',
            'distinct' => true,
        ));
        $model = NewsCategory::model()->findAll(array('order' => 'lft'));
        $criteria = new CDbCriteria;
        $criteria->order = 't.lft'; // or 't.root, t.lft' for multiple trees
        $categories = NewsCategory::model()->findAll($criteria);

        $checked_cat = $_GET['checked_cat'];
        $category_name = $_GET['category_name'];
        $cnc = $_GET['cnc'];
        $category_id = $_GET['category_id'];
        $id = $_GET['id'];
        $parent_name = $_GET['parent_name'];
        $edit_model = NewsCategory::model()->find(array(
            'select' => '*',
            'condition' => 'id=:id',
            'params' => array(':id' => $id)
        ));

        if (Yii::app()->request->isAjaxRequest) {
            NewsCategory::model()->updateByPk($category_id, array('url' => $cnc, 'name' => $category_name, 'root' => $checked_cat));
        }

        $this->render('kriminal.views.category.edite', array('model' => $model, 'categories' => $categories, 'category_name' => $category_name, 'edit_model' => $edit_model));
    }

    public function actionDeleteCategory()
    {
        if (isset($_GET['id']) && NewsCategory::model()->findByPk($_GET)) {
            NewsCategory::model()->deleteByPk($_GET['id']);
            $this->successTo('Запись удалена', 'category/viewcategories');
        } else {
            $this->errorTo('Отсутствие записи для удаления', 'category/viewcategories');
        }
    }
}
<?php
/**
 * User: Alex
 * Date: 05.10.13
 * Time: 19:50
 */

//Get array tree with category
echo '<script> getCatTree(); </script>';

$criteria=new CDbCriteria;
$criteria->order = 't.root, t.lft'; // or 't.root, t.lft' for multiple trees
$cat = NewsCategory::model()->findAll($criteria);

$level = 0;

$checkCategory = NewsCategoryRelation::getCategoryByNewsId($news_id);

foreach($cat as $n=>$category)
{
    if($category->level==$level)
        echo CHtml::closeTag('li')."\n";
    else if($category->level>$level)
        echo CHtml::openTag('ul')."\n";
    else
    {
        echo CHtml::closeTag('li')."\n";

        for($i=$level-$category->level;$i;$i--)
        {
            echo CHtml::closeTag('ul')."\n";
            echo CHtml::closeTag('li')."\n";
        }
    }

    echo CHtml::openTag('li');
    echo CHtml::checkBox("Category[$category->id]", ( $checkCategory && array_key_exists($category->id, $checkCategory) ? true : false), array('id' => 'Category_id_'.$category->id, 'value' => $category->id));
    echo CHtml::label($category->name, 'Category_id_'.$category->id);
    $level = $category->level;
}

for($i=$level; $i; $i--)
{
    echo CHtml::closeTag('li')."\n";
    echo CHtml::closeTag('ul')."\n";
}
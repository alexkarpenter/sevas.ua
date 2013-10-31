<?php
/**
 * @var $this CategoryController
 * @var $form CActiveForm
 */
?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("input").change(function(){
                var category_name = $(this).attr("category_value");
               checked_cat = $(this).attr("class");

            });
            $('#category_save_btn').click(function () {

                var cnc = $("#cnc_name").val();
                var category_id = $("#cat_id").val();
                var parent_name = $("#parent_name").val();
                var category_name = $("#category_name").val();
                alert(checked_cat);
                $.ajax({
                    type: "GET",
                    url: '<?=$this->createUrl('/category/editecategory')?>',
                    data: {checked_cat:checked_cat, parent_name:parent_name, category_name:category_name, cnc:cnc, category_id:category_id},
                    async: false,
                    success:function(data){
                    }
                })
            });
        });
    </script>
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form_category',
    'htmlOptions' => array(
        'class' => 'tab',
        'name' => 'form_category',
    ),
    'action' => ' ',
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => false,
    ),
));
?>
<?php $formcategory = new CommentForm();?>
    <div class="row">
        <div class="input-block"><div class="text-block">Название категории</div><label class="input-wrap inputs"><?php echo $form->textField($formcategory,'name',array('id'=>'category_name', 'value'=>$edit_model->name)); ?></label></div><br class="c"/>
        <div class="input-block"><div class="text-block">Урл</div><label class="input-wrap inputs"><?php echo $form->textField($formcategory,'cnc',array('id'=>'cnc_name', 'value'=>$edit_model->url)); ?></label></div><br class="c"/>
        <div class="input-block"><div class="text-block">Родительская категория</div><label class="input-wrap inputs"><?php echo $form->textField($formcategory,'parent',array('id'=>'parent_name', 'value'=>$edit_model->getParentId())); ?></label></div><br class="c"/>
        <input id="cat_id" type="hidden" value='<?php echo $edit_model->id?>'>
        <?
        $i = 0;
        $level=0;
        foreach($categories as $n=>$category)
        {
            if ($category->level == $level)
                echo CHtml::closeTag('li') . "\n";
            elseif ($category->level > $level)
            {
                echo CHtml::openTag("ul class='cat_in'") . "\n";
                if($i==0)
                {
                    echo CHtml::openTag('li') . "\n";
                   // echo CHtml::radioButton("NewsCategory[id]", true, array('id'=>'NewsCategory_id_0', 'checked'=>true, 'class'=>'root'));
                   // echo CHtml::label('Не имеет родителя', 'NewsCategory_id_0');
                    echo CHtml::closeTag('li') . "\n";
                    ++$i;
                }
            }
            else
            {
                echo CHtml::closeTag('li') . "\n";

                for ($i = $level - $category->level; $i; $i--) {
                    echo CHtml::closeTag('ul') . "\n";
                    echo CHtml::closeTag('li') . "\n";
                }
            }

            echo CHtml::openTag('li');

            echo $form->radioButton($category, 'id', array('id'=>'NewsCategory_id_'.$category->id, 'class'=>$category->id));
            echo $form->label($category, $category->name, array('for'=>'NewsCategory_id_'.$category->id));
            $level = $category->level;
        }

        for ($i = $level; $i; $i--) {
            echo CHtml::closeTag('li') . "\n";
            echo CHtml::closeTag('ul') . "\n";
        }?>
    </div>
    <div class="row">
        <span class="gray-btn">Зарегистрировать<?php echo CHtml::submitButton('Сохранить', array('id'=>'category_save_btn')); ?></span>
    </div>

<?php $this->endWidget(); ?>
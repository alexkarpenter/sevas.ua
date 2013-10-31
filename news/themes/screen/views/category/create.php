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
            });
            $('#category_save_btn').click(function () {

                var cnc = $("#cnc_name").val();
                var category_name = $("#category_name").val();
                var checked_cat = $("input:radio:checked")[0]['className'];
                $.ajax({
                    type: "GET",
                    async :false,
                    url: '<?=$this->createUrl('/category/createcategory')?>',
                    data: {checked_cat:checked_cat, category_name:category_name, cnc:cnc},
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
<?php print_r($category_name);?>
<?php $formcategory = new CommentForm();?>
    <div class="row">
        <div class="input-block"><div class="text-block">Название категории</div><label class="input-wrap inputs"><?php echo $form->textField($formcategory,'name',array('id'=>'category_name', 'value'=>'')); ?></label></div><br class="c"/>
        <div class="input-block"><div class="text-block">Урл</div><label class="input-wrap inputs"><?php echo $form->textField($formcategory,'cnc',array('id'=>'cnc_name', 'value'=>'')); ?></label></div><br class="c"/>
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
                    echo CHtml::radioButton("NewsCategory[id]", true, array('id'=>'NewsCategory_id_0', 'checked'=>true, 'class'=>'root'));
                    echo CHtml::label('Не имеет родителя', 'NewsCategory_id_0');
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
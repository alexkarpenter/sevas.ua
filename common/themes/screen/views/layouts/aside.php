<?php /* @var $this Controller */ ?>
<?php $this->beginContent('common.themes.'.Yii::app()->theme->name.'.views.layouts.main'); ?>
<div id="content">
    <?php echo $content;?>
</div><!-- content -->
<div id="aside">

    <?php
    $this->beginWidget('common.widgets.popularnews.PopularNews',array());
    $this->endWidget();
    ?>
    <?php
    $this->beginWidget('common.widgets.talkingnow.TalkingNow',array(
        'params'=>array(
            'action' => Yii::app()->getController()->getAction()->getId(),
        )));
    $this->endWidget();
    ?>
    <?php
    $this->beginWidget('common.widgets.changesperday.ChangesPerDay',array());
    $this->endWidget();
    ?>
</div>
<?php $this->endContent(); ?>

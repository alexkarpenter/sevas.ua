<?php
/**
 * @var $form CActiveForm
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'htmlOptions'=>array(
        'class'=>'tab',
        'name'=>'login'
    ),
    'action'=>'/user/login',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>false,
    ),
));
?>

    <p>Для того чтобы войти на сайт, пожалуйста используйте Ваш <strong>Логин</strong> и <strong>пароль</strong> указанные при регистрации</p>
    <div class="row">
        <label class="input-wrap"><?php echo $form->textField($modelLogin,'email', array('id'=>'modelLogin_email', 'value'=>'Email', 'onblur'=>"if (this.value == '') {
                        this.value = 'Email';
                    }", 'onfocus'=>"if (this.value == 'Email') {
                        this.value = '';
                    }")); ?></label>
        <?php echo $form->error($modelLogin,'email'); ?>
    </div>

    <div class="row">
        <label class="input-wrap"><?php echo $form->textField($modelLogin,'password', array('id'=>'modelLogin_password', 'value'=>'Пароль', 'onblur'=>"if (this.value == '') {
                        this.type = 'text';
                        this.value = 'Пароль';
                    }", 'onfocus'=>"if (this.value == 'Пароль') {
                        this.type = 'password';
                        this.value = '';
                    }")); ?></label>
        <?php echo $form->error($modelLogin,'password'); ?>
    </div>

    <div class="row">
        <label class="ch">
            <?php echo $form->checkBox($modelLogin, 'rememberMe', array('id'=>'modelLogin_rememberMe', 'class' => 'checkbox', 'checked' => 'checked')); ?>
            <?php echo $form->label($modelLogin, 'rememberMe'); ?>
            <?php echo $form->error($modelLogin, 'rememberMe'); ?>
        </label>
    </div>

    <div class="row">
        <span class="gray-btn">Вход<?php echo CHtml::Button('Login', array('id' => 'login-form-submit')); ?>
        </span>
    </div>

    <div class="user_error"></div>

    <div class="bottom-row">
        <span class="note">Вход на SEVAS.ru</span>
    </div>
<?php $this->endWidget(); ?>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'reg-form',
    'htmlOptions' => array(
        'class' => 'tab',
        'name' => 'registration'
    ),
    'action' => '/user/reg',
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
    <div id='reg_aria'>
        <p>Для того чтобы зарегистрироваться на сайте, пожалуйста заполните все поля в форме ниже</p>
        <div class="row">
            <label class="input-wrap"><?php echo $form->textField($modelReg,'nickname', array('value'=>'Желаемый ник', 'onblur'=>"if (this.value == '') {
                                        this.value = 'Желаемый ник';
                                    }", 'onfocus'=>"if (this.value == 'Желаемый ник') {
                                        this.value = '';
                                    }")); ?></label>
            <?php echo $form->error($modelReg,'nickname'); ?>
        </div>

        <div class="row">
            <label class="input-wrap"><?php echo $form->textField($modelReg,'email', array('value'=>'Email', 'onblur'=>"if (this.value == '') {
                                        this.value = 'Email';
                                    }", 'onfocus'=>"if (this.value == 'Email') {
                                        this.value = '';
                                    }")); ?></label>
            <?php echo $form->error($modelReg,'email'); ?>
        </div>

        <div class="row">
            <label class="input-wrap"><?php echo $form->textField($modelReg,'password', array('value'=>'Пароль', 'onblur'=>"if (this.value == '') {
                                        this.type = 'text';
                                        this.value = 'Пароль';
                                    }", 'onfocus'=>"if (this.value == 'Пароль') {
                                        this.type = 'password';
                                        this.value = '';
                                    }")); ?></label>
            <?php echo $form->error($modelReg,'password'); ?>
        </div>

        <div class="row">
            <label class="input-wrap"><?php echo $form->textField($modelReg,'password_repeat', array('value'=>'Пароль еще раз','onblur'=>"if (this.value == '') {
                                        this.type = 'text';
                                        this.value = 'Пароль еще раз';
                                    }", 'onfocus'=>"if (this.value == 'Пароль еще раз') {
                                        this.type = 'password';
                                        this.value = '';
                                    }")); ?></label>
            <?php echo $form->error($modelReg,'password_repeat'); ?>
        </div>

        <div class="row_buttons">
            <span class="gray-btn">Зарегистрировать<?php echo CHtml::Button('Регистрация', array('id'=>'registration-data-submit-button')); ?></span>
        </div>

        <div class="user_reg_error"></div>
    </div>

    <div id='succes_msg'>
        <div id="block">
            <p>Благодарим Вас  за pерегистрацию на сайте Sevas.ru!</p>
            <p>На указаный Вами Email было оправлено письмо с подтверждением Вашей регистрации</p>
            <p>Просим Вас перейти по ссылке из письма для активации Вашей учетной записи</p>
        </div>
        <div class="row">
            <span class="gray-btn">Закрыть <input id="close-registration-data-submit-button" value="" title="Закрыть"></span>
        </div>
    </div>

    <div class="bottom-row">
        <span class="note">Регистрация на SEVAS.ru</span>
    </div>

<?php $this->endWidget(); ?>
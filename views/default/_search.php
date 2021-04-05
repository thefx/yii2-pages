<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\forms\PagesSearchFrom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'PageId') ?>

    <?= $form->field($model, 'Name') ?>

    <?= $form->field($model, 'Title') ?>

    <?= $form->field($model, 'Keywords') ?>

    <?= $form->field($model, 'Description') ?>

    <?php // echo $form->field($model, 'Alias') ?>

    <?php // echo $form->field($model, 'Parent') ?>

    <?php // echo $form->field($model, 'Visible') ?>

    <?php // echo $form->field($model, 'Order') ?>

    <?php // echo $form->field($model, 'LanguageId') ?>

    <?php // echo $form->field($model, 'Horizontal') ?>

    <?php // echo $form->field($model, 'HideInMain') ?>

    <?php // echo $form->field($model, 'WithoutDesign') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'Text') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

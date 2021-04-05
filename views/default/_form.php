<?php

use thefx\pages\models\Page;
use thefx\pages\widgets\select\Select2Input;
use thefx\pages\widgets\switcher\SwitchInput;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Page */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Общая информация</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">СЕО</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Другое</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-four-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'id' => 'name']) ?>

                <?= $form->field($model, 'path')->textInput(['maxlength' => true, 'id' => 'slug']) ?>

                <?= $form->field($model, 'parent_id')->widget(Select2Input::class, [
                    'data' => $model->pagesList(),
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]) ?>

                <?= $form->field($model, 'text')->widget(Widget::class, [
                    'settings' => [
                        'image' => [
                            'upload' => Url::to(['upload-image', 'id' => $model->id]),
                            'select' => Url::to(['get-uploaded-images', 'id' => $model->id])
                        ],
                    ]
                ]) ?>

            </div>
            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

                <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">

                <?= $form->field($model, 'public')->widget(SwitchInput::class) ?>

            </div>

        </div>
    </div>
    <div class="card-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <!-- /.card -->
</div>

<?php ActiveForm::end(); ?>

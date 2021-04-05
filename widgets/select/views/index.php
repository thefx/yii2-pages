<?php

/* @var ActiveRecord $model */
/* @var array $data */
/* @var string $attributeName */
/* @var array $options */

/* @var array $pluginOptions */

use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;

echo '<div class="form-group">';
echo Html::activeDropDownList($model, $attributeName, $data, $options);
echo '</div>';

$inputId = Html::getInputId($model, $attributeName);
$this->registerJs("$('#{$inputId}').select2(" . json_encode($pluginOptions) . ");", View::POS_READY);


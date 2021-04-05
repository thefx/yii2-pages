<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\shop\entities\Page\Pages */

$this->title = 'Редактирование страницы';
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
?>
<div class="pages-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

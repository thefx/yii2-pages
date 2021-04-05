<?php

/* @var $this yii\web\View */
/* @var $model app\shop\entities\Page\Pages */

$this->title = 'Добавить страницу';
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

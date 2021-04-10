<?php

namespace thefx\pages\actions;

use thefx\pages\models\Page;
use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class GetPageAction extends Action
{
    public function run($q = null, $id = null)
    {
        if ($q === null) {
            return false;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $out = ['results' => ['id' => '', 'value' => '']];

        $goods = Page::find()
            ->select(['id', 'title'])
            ->where(['like', 'Name', $q])
            ->orderBy('Name')
            ->limit(15)
            ->all();

        $out['results'] = ArrayHelper::getColumn($goods, static function ($element) {
            return ['id' => $element['id'], 'text' => "[{$element['id']}] {$element['title']}"];
        });

        return $out;
    }
}
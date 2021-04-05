<?php

namespace thefx\pages\assets\JsTree;

use yii\web\AssetBundle;

class JsTreeAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';

    public $css = [
        'themes/default/style.min.css',
    ];

    public $js = [
        'jstree.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

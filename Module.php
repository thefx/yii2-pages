<?php

namespace thefx\pages;

class Module extends \yii\base\Module
{
//    path.page.editor
    public $layoutPure;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        }
        return false;
    }
}

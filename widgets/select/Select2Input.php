<?php

namespace thefx\pages\widgets\select;

use thefx\blocks\assets\Select2Asset\Select2Asset;
use yii\widgets\InputWidget;

class Select2Input extends InputWidget
{
    public $data;
    public $pluginOptions = []; // todo

    public function run()
    {
        Select2Asset::register($this->view);

        $this->options['style'] = 'width: 100%';

        if (array_key_exists('placeholder', $this->options)) {
            $this->pluginOptions['placeholder'] = $this->options['placeholder'];
        }

        return $this->render('index', [
            'pluginOptions' => $this->pluginOptions,
            'options' => $this->options,
            'data' => $this->data,
            'model' => $this->model,
            'attributeName' => $this->attribute
        ]);
    }
}

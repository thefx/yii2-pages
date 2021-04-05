<?php

namespace thefx\pages\models\queries;

use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class PagesQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;
}
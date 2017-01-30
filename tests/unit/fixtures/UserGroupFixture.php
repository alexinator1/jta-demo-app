<?php

namespace tests\unit\fixtures;


use yii\test\ActiveFixture;

class UserGroupFixture extends ActiveFixture
{
    public $modelClass = 'app\models\UserGroup';

    public $depends = [
        'tests\unit\fixtures\GroupFixture',
        'tests\unit\fixtures\UserFixture',
    ];
}
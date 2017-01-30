<?php

namespace app\tests\fixtures;


use yii\test\ActiveFixture;

class UserGroupFixture extends ActiveFixture
{
    public $modelClass = 'app\models\UserGroup';

    public $depends = [
        'app\tests\fixtures\GroupFixture',
        'app\tests\fixtures\UserFixture',
    ];
}
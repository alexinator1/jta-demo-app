<?php
/**
 * Created by PhpStorm.
 * User: mactra
 * Date: 08.10.16
 * Time: 17:39
 */

namespace tests\codeception\unit\fixtures;


use yii\test\ActiveFixture;

class UserGroupFixture extends ActiveFixture
{
    public $modelClass = 'app\models\UserGroup';

    public $depends = [
        'tests\codeception\unit\fixtures\GroupFixture',
        'tests\codeception\unit\fixtures\UserFixture',
    ];
}
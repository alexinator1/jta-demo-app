<?php
namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;

class DataController extends Controller
{
    public function actionLoadSamples()
    {
        $groups = [
            ['id' => 21, 'name' => 'Group 1', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 22, 'name' => 'Group 2', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 23, 'name' => 'Group 3', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $users = [
            ['id' => 11, 'username' => 'Alex Rudakov', 'email'=>'alex@rudakov.com', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 12, 'username' => 'Dim Peregudov', 'email'=>'dim@peregudov.com', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 13, 'username' => 'Vas Smith', 'email'=>'vas@smith.com', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 14, 'username' => 'Steav Sothern', 'email'=>'steav@rudakov.com', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 15, 'username' => 'Vlad Len', 'email'=>'vlad@len.com', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $userGroups = [
            [11, 21, date('Y-m-d H:i:s'), 'Head 11-21'],
            [11, 22, date('Y-m-d H:i:s'), 'Member 11-22'],
            [11, 23, date('Y-m-d H:i:s'), 'Su-Head 11-23'],
            [12, 21, date('Y-m-d H:i:s'), 'Su-Head 12-21'],
            [12, 22, date('Y-m-d H:i:s'), 'Member 12-22'],
            [12, 23, date('Y-m-d H:i:s'), 'Member 12-23'],
            [13, 21, date('Y-m-d H:i:s'), 'Member 13-21'],
            [13, 22, date('Y-m-d H:i:s'), 'Member 13-22'],
            [13, 23, date('Y-m-d H:i:s'), 'Head 13-23'],
            [14, 22, date('Y-m-d H:i:s'), 'Member 14-22'],
            [14, 23, date('Y-m-d H:i:s'), 'Member 14-23'],
            [14, 21, date('Y-m-d H:i:s'), 'Member 14-21'],
            [15, 21, date('Y-m-d H:i:s'), 'Member 15-21'],
            [15, 22, date('Y-m-d H:i:s'), 'Member 15-22'],
            [15, 23, date('Y-m-d H:i:s'), 'Member 15-23'],
        ];

        foreach($groups as $group){
            \Yii::$app->db->createCommand()->insert(\app\models\Group::tableName(), $group)->execute();
            echo $this->ansiFormat("\nGroups were populated", Console::FG_GREEN);
        }

        foreach($users as $user){
            \Yii::$app->db->createCommand()->insert(\app\models\User::tableName(), $user)->execute();
            echo $this->ansiFormat("\nUsers were populated", Console::FG_GREEN);
        }

        \Yii::$app->db->createCommand()->batchInsert(\app\models\UserGroup::tableName(),
            ['user_id','group_id', 'joined_at', 'role'],$userGroups)->execute();
            echo $this->ansiFormat("\nUser groups connections were populated", Console::FG_GREEN);
    }
}
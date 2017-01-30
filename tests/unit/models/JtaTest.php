<?php

namespace tests\codeception\unit\models;


use app\tests\fixtures\UserGroupFixture;
use Codeception\Specify;
use Codeception\Test\Unit;
use app\models\Group;
use yii\test\FixtureTrait;

class JtaTest extends Unit
{
    use FixtureTrait;
    use Specify;

    protected function setUp()
    {
        parent::setUp();
        $this->loadFixtures();
    }

    public function fixtures()
    {
        return [
            'user_group' => UserGroupFixture::className()
        ];
    }


    public $expectedArray = [
        21 => ['Head 21-11', 'Member 21-12','Member 21-13'],
        22 => ['Member 22-11', 'Head 22-12', 'Member 22-13', 'Member 22-14'],
        23 => ['Member 23-11', 'Member 23-12', 'Head 23-13']
    ];


    public function testLazyLoad()
    {
        $roles = [];
        $group = Group::findOne(21);

        foreach($group->users as $user)
        {
            $roles[] = $user->role[$group->id];
        }
        expect($roles)->equals($this->expectedArray[21]);

        $roles = [];
        $groups = Group::find()->all();

        foreach($groups as $group){
            foreach($group->users as $user)
            {
                $roles[$group->id][] = $user->role[$group->id];
            }
        }
        expect($roles)->equals($this->expectedArray);
    }


    public function testEagerLoadWith()
    {
        $this->specify("Testing lazy load for group", function(){

            $roles = [];
            $group = Group::find()->where(['id'=>21])->with('users')->one();
            foreach($group->users as $user)
            {
                $roles[] = $user->role[$group->id];
            }

            $this->assertEquals($this->expectedArray[21], $roles);
        });

        $this->specify("Testing lazy load for groups", function(){

            $roles = [];
            $groups =  Group::find()->with('users')->all();

            foreach($groups as $group){
                foreach($group->users as $user)
                {
                    $roles[$group->id][] = $user->role[$group->id];
                }
            }
            $this->assertEquals($this->expectedArray, $roles);
        });


        $this->specify("Testing lazy load for groups as array", function(){
            $roles = [];
            $groups = Group::find()->asArray()->with('users')->all();
            foreach($groups as $group){
                foreach($group['users'] as $user)
                {
                    $roles[$group['id']][] = $user['role'][$group['id']];
                }
            }

            $this->assertEquals($this->expectedArray, $roles);
        });
    }



    public function testEagerLoadJoinWith()
    {
        $this->specify("Testing lazy load for group using 'joinWith'", function(){

            $roles = [];
            $group = Group::find()->where(['`group`.`id`'=>21])->joinWith('users')->one();
            foreach($group->users as $user)
            {
                $roles[] = $user->role[$group->id];
            }

            $this->assertEquals($this->expectedArray[21], $roles);
        });

        $this->specify("Testing lazy load for groups using 'joinWith'", function(){

            $roles = [];
            $groups =  Group::find()->joinWith('users')->all();

            foreach($groups as $group){
                foreach($group->users as $user)
                {
                    $roles[$group->id][] = $user->role[$group->id];
                }
            }
            $this->assertEquals($this->expectedArray, $roles);
        });


        $this->specify("Testing lazy load for groups as array using 'joinWith'", function(){
            $roles = [];
            $groups = Group::find()->asArray()->joinWith('users')->all();
            foreach($groups as $group){
                foreach($group['users'] as $user)
                {
                    $roles[$group['id']][] = $user['role'][$group['id']];
                }
            }

            $this->assertEquals($this->expectedArray, $roles);
        });
    }
}
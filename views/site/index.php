<?php

/* @var $this yii\web\View */

$this->title = 'Junction table attributes demo yii2 application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Junction table attributes demo yii2 application (Yii version:<?= \Yii:: getVersion() ?>)</h2>

        <p class="lead">for testing various cases of using extenstion</p>
    </div>

    <div class="body-content">

        This application shows different cases of using extension. Below you may see junction table, to minimize risk of  confusing all user ids starts from '1' and all groups ids starts with '2'.
        Also in roles names includes accordance between user and group ids for esier checking.

        <h3>Junction table:</h3>

        <?= \yii\grid\GridView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                   'query' => \app\models\UserGroup::find()
                ]),
                'columns' => [
                    'user_id',
                    'group_id',
                    'joined_at',
                    'role'
                ],
                'summary' => false
        ]); ?>


        <h3>Code samples</h3>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#lazy-loading" aria-controls="home" role="tab" data-toggle="tab">Lazy loading</a></li>
            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">
                    Eager loading <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                    <li class=""><a href="#with-all" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1" aria-expanded="false">with('users')->all()</a></li>
                    <li class=""><a href="#with-one" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2" aria-expanded="false">with('users')->one()</a></li>
                    <li class=""><a href="#with-all-array" role="tab" id="dropdown3-tab" data-toggle="tab" aria-controls="dropdown2" aria-expanded="false">with('users')->asArray()->all()</a></li>
                </ul>
            </li>
            <li role="presentation" class="dropdown">
                <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">
                    Eager loading using join <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                    <li class=""><a href="#join-with-all" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1" aria-expanded="false">joinWith('users')->all()</a></li>
                    <li class=""><a href="#join-with-one" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2" aria-expanded="false">joinWith('users')->one()</a></li>
                    <li class=""><a href="#join-with-all-array" role="tab" id="dropdown3-tab" data-toggle="tab" aria-controls="dropdown2" aria-expanded="false">joinWith('users')->asArray()->all()</a></li>
                </ul>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="lazy-loading">
                <h4>Code:</h4>
                <div class="code well">
                    $group = Group::findOne(21);<br>
                    foreach($group->users as $user)<br>
                    {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;$roles[] = $user->role;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;$joinDates[] = $user->joined_at;<br>
                    }
                </div>
                <h4>Result:</h4>
                <p>
                    <?php
                    $group = \app\models\Group::findOne(21);
                    foreach($group->users as $user)
                    {
                        $roles[$user->id] = $user->role;
                        $joinDates[$user->id] = $user->joined_at;
                    }
                    ?>
                    <div>$roles:&nbsp; <?= var_export($roles) ?></div>
                    <br>
                    <div>$joinDates: &nbsp;<?= var_export($joinDates) ?></div>

                </p>
            </div>
            <div role="tabpanel" class="tab-pane" id="with-one">
                <h4>Code:</h4>
                <div class="code well">
                    $group = Group::find()->with('users')->one();<br>
                    foreach($group->users as $user)<br>
                    {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;$roles[] = $user->role;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;$joinDates[] = $user->joined_at;<br>
                    }
                </div>
                <h4>Result:</h4>
                <p>
                    <?php
                    $group = \app\models\Group::find()->with('users')->one();
                    foreach($group->users as $user)
                    {
                        $roles[$user->id] = $user->role;
                        $joinDates[$user->id] = $user->joined_at;
                    }
                    ?>
                <div>$roles:&nbsp; <?= var_export($roles) ?></div>
                <br>
                <div>$joinDates: &nbsp;<?= var_export($joinDates) ?></div>
                </p>
            </div>

            <div role="tabpanel" class="tab-pane" id="with-all">
                <h3>Code:</h3>
                <div class="code">
                    <div class="code well">
                        $groups = Group::find()->with('users')->all();<br>
                        foreach($groups as $group)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;foreach($group->users as $user)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;{<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$roles[$group->id] = $user->role;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$joinDates[$group->id] = $user->joined_at;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}
                    </div>
                </div>
                <h3>Result:</h3>
                <p>
                    <?php
                    $roles = [];
                    $joinDates = [];
                    $groups = \app\models\Group::find()->with('users')->all();
                    foreach($groups as $group){
                        foreach($group->users as $user)
                        {
                            $roles[$group->id] = $user->role;
                            $joinDates[$group->id] = $user->joined_at;
                        }
                    }
                    ?>
                <div>$roles:&nbsp; <?= var_export($roles) ?></div>
                <br>
                <div>$joinDates: &nbsp;<?= var_export($joinDates) ?></div>
                </p>
            </div>

            <div role="tabpanel" class="tab-pane" id="with-all-array">
                <h3>Code:</h3>
                <div class="code">
                    <div class="code well">
                        $groups = Group::find()->with('users')->asArray()->all();<br>
                        foreach($groups as $group)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;foreach($group['users'] as $user)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;{<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$roles[$group['id']] = $user['role'];<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$joinDates[$group['id']] = $user['joined_at'];<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}
                    </div>
                </div>
                <h3>Result:</h3>
                <p>
                    <?php
                    $roles = [];
                    $joinDates = [];
                    $groups = \app\models\Group::find()->asArray()->with('users')->all();
                    foreach($groups as $group){
                        foreach($group['users'] as $user)
                        {
                            $roles[$group['id']] = $user['role'];
                            $joinDates[$group['id']] = $user['joined_at'];
                        }
                    }
                    ?>
                <div><i>$roles:</i>&nbsp; <?= var_export($roles) ?></div>
                <br>
                <div><i>$joinDates:</i> &nbsp;<?= var_export($joinDates) ?></div>
                </p>
            </div>
            <div role="tabpanel" class="tab-pane" id="join-with-one">
                <h4>Code:</h4>
                <div class="code well">
                    $group = Group::find()->joinWith('users')->one();<br>
                    foreach($group->users as $user)<br>
                    {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;$roles[] = $user->role;<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;$joinDates[] = $user->joined_at;<br>
                    }
                </div>
                <h4>Result:</h4>
                <p>
                    <?php
                    $group = \app\models\Group::find()->joinWith('users')->one();
                    foreach($group->users as $user)
                    {
                        $roles[$user->id] = $user->role;
                        $joinDates[$user->id] = $user->joined_at;
                    }
                    ?>
                <div>$roles:&nbsp; <?= var_export($roles) ?></div>
                <br>
                <div>$joinDates: &nbsp;<?= var_export($joinDates) ?></div>
                </p>
            </div>

            <div role="tabpanel" class="tab-pane" id="join-with-all">
                <h3>Code:</h3>
                <div class="code">
                    <div class="code well">
                        $groups = Group::find()->joinWith('users')->all();<br>
                        foreach($groups as $group)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;foreach($group->users as $user)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;{<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$roles[$group->id] = $user->role;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$joinDates[] = $joinDates[$group->id] = $user->joined_at;<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}
                    </div>
                </div>
                <h3>Result:</h3>
                <p>
                    <?php
                    $roles = [];
                    $joinDates = [];
                    $groups = \app\models\Group::find()->joinWith('users')->all();
                    foreach($groups as $group){
                        foreach($group->users as $user)
                        {
                            $roles[$group->id] = $user->role;
                            $joinDates[$group->id] = $user->joined_at;
                        }
                    }
                    ?>
                <div>$roles:&nbsp; <?= var_export($roles) ?></div>
                <br>
                <div>$joinDates: &nbsp;<?= var_export($joinDates) ?></div>
                </p>
            </div>

            <div role="tabpanel" class="tab-pane" id="join-with-all-array">
                <h3>Code:</h3>
                <div class="code">
                    <div class="code well">
                        $groups = Group::find()->joinWith('users')->asArray()->all();<br>
                        foreach($groups as $group)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;foreach($group['users'] as $user)<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;{<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$roles[$group['id']] = $user['role'];<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$joinDates[$group['id']] = $user['joined_at'];<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;}
                    </div>
                </div>
                <h3>Result:</h3>
                <p>
                    <?php
                    $roles = [];
                    $joinDates = [];
                    $groups = \app\models\Group::find()->asArray()->joinWith('users')->all();
                    foreach($groups as $group){
                        foreach($group['users'] as $user)
                        {
                            $roles[$group['id']] = $user['role'];
                            $joinDates[$group['id']] = $user['joined_at'];
                        }
                    }
                    ?>
                <div><i>$roles:</i>&nbsp; <?= var_export($roles) ?></div>
                <br>
                <div><i>$joinDates:</i> &nbsp;<?= var_export($joinDates) ?></div>
                </p>
            </div>
        </div>
    </div>
</div>

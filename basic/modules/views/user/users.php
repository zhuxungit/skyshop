<?php
use yii\helpers\Url;

?>
<!-- main container -->
<div class="content">

    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>用户列表</h3>
                <div class="span10 pull-right">
                    <input type="text" class="span5 search" placeholder="Type a user's name..."/>

                    <!-- custom popup filter -->
                    <!-- styles are located in css/elements.css -->
                    <!-- script that enables this dropdown is located in js/theme.js -->
<!--                    <div class="ui-dropdown">-->
<!--                        <div class="head" data-toggle="tooltip" title="Click me!">-->
<!--                            Filter users-->
<!--                            <i class="arrow-down"></i>-->
<!--                        </div>-->
<!--                        <div class="dialog">-->
<!--                            <div class="pointer">-->
<!--                                <div class="arrow"></div>-->
<!--                                <div class="arrow_border"></div>-->
<!--                            </div>-->
<!--                            <div class="body">-->
<!--                                <p class="title">-->
<!--                                    Show users where:-->
<!--                                </p>-->
<!--                                <div class="form">-->
<!--                                    <select>-->
<!--                                        <option/>-->
<!--                                        Name-->
<!--                                        <option/>-->
<!--                                        Email-->
<!--                                        <option/>-->
<!--                                        Number of orders-->
<!--                                        <option/>-->
<!--                                        Signed up-->
<!--                                        <option/>-->
<!--                                        Last seen-->
<!--                                    </select>-->
<!--                                    <select>-->
<!--                                        <option/>-->
<!--                                        is equal to-->
<!--                                        <option/>-->
<!--                                        is not equal to-->
<!--                                        <option/>-->
<!--                                        is greater than-->
<!--                                        <option/>-->
<!--                                        starts with-->
<!--                                        <option/>-->
<!--                                        contains-->
<!--                                    </select>-->
<!--                                    <input type="text"/>-->
<!--                                    <a class="btn-flat small">Add filter</a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                    <a href="<?php echo Url::to(['user/reg']) ?>" class="btn-flat success pull-right">
                        <span>&#43;</span>
                        加入新用户
                    </a>
                </div>
            </div>

            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span2 sortable align-left">
                            <span class="line"></span>用户名
                        </th>
                        <th class="span3 sortable align-left">
                            <span class="line"></span>真实姓名
                        </th>
                        <th class="span3 sortable align-left">
                            <span class="line"></span>昵称
                        </th>
                        <th class="span3 sortable align-left">
                            <span class="line"></span>性别
                        </th>
                        <th class="span3 sortable align-left">
                            <span class="line"></span>年龄
                        </th>
                        <th class="span3 sortable align-left">
                            <span class="line"></span>生日
                        </th>
                        <th class="span2 sortable align-left">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php foreach ($users as $user): ?>
                        <tr class="first">
                            <td>
                                <?php if (empty($user->profile->avatar)): ?>
                                    <img src="<?php echo Yii::$app->params['defaultValue']['avatar']; ?>" class="img-circle">
                                <?php else: ?>
                                <img src="assets/uploads/avatar/<?php echo $user->profile->avatar; ?>" class="img-circle">
                                <?php endif; ?>
                                <a href="#" class="name"><?php echo $user->username; ?></a>
                                <span class="subtext"><?php echo $user->useremail;?></span>
                            </td>
                            <td>
                                <?php echo isset($user->profile->truename)?$user->profile->truename:'未填写'; ?>
                            </td>
                            <td>
                                <?php echo isset($user->profile->nickname)?$user->profile->nickname:'未填写'; ?>
                            </td>
                            <td>
                                <?php echo isset($user->profile->sex)?$user->profile->sex:'未填写'; ?>
                            </td>
                            <td>
                                <?php echo isset($user->profile->age)?$user->profile->age:'未填写'; ?>
                            </td>
                            <td>
                                <?php echo isset($user->profile->birthday)?$user->profile->nickname:'未填写'; ?>
                            </td>
                            <td class="align-right">
                                <a href="<?php echo Url::to(['user/del', 'userid' => $user->userid]); ?>">删除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
                <?php
                if (Yii::$app->session->hasFlash('info')) {
                    echo Yii::$app->session->getFlash('info');
                }
                ?>
            </div>
            <div class="pagination pull-right">
                <?php echo yii\widgets\LinkPager::widget(['pagination' => $pager, 'prevPageLabel' => '&#8249;', 'nextPageLabel' => '&#8250;']) ?>
            </div>
            <!-- end users table -->
        </div>
    </div>
</div>
<!-- end main container -->


<!--<!-- scripts -->-->
<!--<script src="js/jquery-latest.js"></script>-->
<!--<script src="js/bootstrap.min.js"></script>-->
<!--<script src="js/theme.js"></script>-->
<!---->
<!--</body>-->
<!--</html>-->
<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;
use Dcat\Admin\Layout\Navbar;
use App\Models\AdminMessage;

/**
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
//  Form 表单初始化
Form::resolving(function (Form $form) {

    $form->disableEditingCheck();

    $form->disableCreatingCheck();

    $form->disableViewCheck();

    $form->tools(function (Form\Tools $tools) {
        $tools->disableDelete();
        $tools->disableView();
    });
});

//  查看初始化
Show::resolving(function (Show $show) {
    $show->disableDeleteButton();

    $show->disableEditButton();
});

//  自定义头部导航
Admin::navbar(function (Navbar $navbar) {
    //  获取后台管理员未读消息
    $messages = AdminMessage::where('status',0)->limit(10)
        ->orderBy('created_at','desc')
        ->get();

    $count = AdminMessage::where('status',0)->count();

    $navbar->right(view('admin.admin-message',[
        'messages' => $messages ?: [],
        'total' => $count,
        'type_name' => AdminMessage::TYPE
    ]));
});

Admin::style('.main-footer {display:none;}[class*=sidebar-dark-] .navbar-header{padding:.35rem 1rem 0;height:auto !important;background:#1e1e2d}');

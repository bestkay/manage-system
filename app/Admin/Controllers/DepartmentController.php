<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Department;
use Encore\Admin\Form;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Controllers\AdminController;

class DepartmentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '科室设置';

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title(trans('疾病设置'))
            ->row(function (Row $row) {
                $row->column(6, Department::tree());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('/departments'));
                    $form->select('parent_id', trans('上级栏目'))->options(Department::selectOptions());
                    $form->text('title', __('科室名称'))->autofocus();
                    $form->text('intro', __('科室简介'));
                    $form->hidden('_token')->default(csrf_token());
                    $column->append((new Box(trans('添加'), $form))->style('success'));
                });
            });
    }

    /**
     * Redirect to edit page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function show($id)
    // {
    //     return redirect()->route('Departments.id.edit', ['id' => $id]);
    // }

    protected function detail($id)
    {
        return redirect()->route('admin.departments.edit', ['department' => $id]);
    }

    /**
     * Edit interface.
     *
     * @param string  $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->title(trans('科室设置'))
            ->row($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Department());

        $form->select('parent_id', trans('admin.parent_id'))->options(Department::selectOptions());
        $form->text('title', __('科室名称'))->autofocus();
        $form->text('intro', __('科室简介'));

        return $form;
    }



}

<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Doctor;
use Encore\Admin\Form;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Controllers\AdminController;

class DoctorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '医生设置';

    public function index(Content $content)
    {
        return $content
            ->title(trans('医生设置'))
            ->row(function (Row $row) {
                $row->column(6, Doctor::tree());
                
                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('/doctors'));
                    $form->select('parent_id', trans('上级栏目'))->options(Doctor::selectOptions());
                    $form->text('title', __('医生名称'));
                    $form->text('intro', __('医生简介'));
                    $form->hidden('_token')->default(csrf_token());
                    $column->append((new Box(trans('添加'), $form))->style('success'));
                });
            });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        return redirect()->route('admin.doctors.edit', ['doctor' => $id]);
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
            ->title(trans('医生设置'))
            ->row($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Doctor());

        $form->select('parent_id', trans('所属分类'))->options(Doctor::selectOptions());
        $form->text('title', __('医生名字'));
        $form->text('intro', __('医生简介'));

        return $form;
    }
}

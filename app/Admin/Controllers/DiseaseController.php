<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Disease;
use Encore\Admin\Form;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Controllers\AdminController;


class DiseaseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '疾病设置';
    
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
                $row->column(6, Disease::tree());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('/diseases'));
                    $form->select('parent_id', trans('上级栏目'))->options(Disease::selectOptions());
                    $form->text('title', __('疾病名称'));
                    $form->textarea('items', __('治疗项目'));
                    $form->text('intro', __('疾病简介'));
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
    //     return redirect()->route('diseases.id.edit', ['id' => $id]);
    // }
    protected function detail($id)
    {
        return redirect()->route('admin.diseases.edit', ['disease' => $id]);
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
            ->title(trans('疾病设置'))
            ->row($this->form()->edit($id));
    }

    // ======================================

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Disease());

        $form->select('parent_id', trans('上级栏目'))->options(Disease::selectOptions());
        $form->text('title', __('疾病名称'));
        $form->textarea('items', __('治疗项目'));
        $form->text('intro', __('疾病简介'));

        return $form;
    }

}

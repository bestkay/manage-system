<?php

namespace App\Admin\Controllers;

use App\Admin\Model\Engine;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Layout\Content;

class EngineController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '搜索引擎设置';

    public function index(Content $content)
    {
        return $content
            ->title(trans('搜索引擎设置'))
            ->row(function (Row $row) {
                $row->column(6, $this->grid());
                
                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('/engines'));
                    $form->text('title', __('标题'))->autofocus();

                    $form->hidden('_token')->default(csrf_token());
                    $column->append((new Box(trans('添加'), $form))->style('success'));
                });
            });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Engine());

        $grid->column('id', __('Id'));
        $grid->column('title', __('标题'));
        $grid->column('created_at', __('Created at'))->hide();
        $grid->column('updated_at', __('Updated at'))->hide();

        $grid->disableCreateButton();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Engine::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('标题'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Engine());

        $form->text('title', __('标题'));

        return $form;
    }
}

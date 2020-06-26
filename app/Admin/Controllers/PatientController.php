<?php

namespace App\Admin\Controllers;

use Encore\Admin\Facades\Admin;
use App\Admin\Model\Patient;
use App\Admin\Model\Disease;
use App\Admin\Model\Department;
use App\Admin\Model\Engine;
use App\Admin\Model\Media;
use App\Admin\Model\Doctor;
use App\Admin\Model\Area;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Auth\Database\Administrator as User;
use App\Admin\Actions\Patient\Sign;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;

class PatientController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Patient';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new Patient());

        $grid->actions(function ($actions) {
            $actions->add(new Sign);
        });


        $grid->model()
            // ->where('author_id', Admin::user()->id)
            // ->orwhere('admin_user_id', Admin::user()->id)
            ->orderBy('id','desc');

        $grid->column('status', __('状态'))->using([
            0 => '未到',
            1 => '已到',
            2 => '不来了'
        ])->label([
            0 => 'default',
            1 => 'success',
            2 => 'warning'
        ])->sortable();
        $grid->column('id', __('Id'))->hide();
        $grid->column('name', __('姓名'));
        $grid->column('sex', __('性别'))->sortable();
        $grid->column('age', __('年龄'))->sortable();
        $grid->column('tel', __('电话'));
        $grid->column('qq', __('qq号'))->hide();
        $grid->column('wechat', __('微信号'))->hide();
        $grid->column('content', __('咨询内容'))->hide();
        $grid->column('department.title', __('科室'))->hide();
        $grid->column('engine.title', __('搜索引擎'))->hide();
        // $grid->column('media.title', __('渠道'));
        $grid->column('media.id', __('渠道'))->display(function($id){
            $media = $this->transformMedia($id);
            return $media;
        })->map('ucwords')->implode('>');
        $grid->column('keyword', __('关键字'))->hide();
        $grid->column('diseases', '疾病')->display(function ($diseases) {

            $diseases = array_map(function ($disease) {
                return "<span class='label label-success'>{$disease['title']}</span>";
            }, $diseases);

            return join('&nbsp;', $diseases);
        });
        $grid->column('area.id', __('地区'))->display(function($id){
            $regions = $this->transform($id);
            return $regions;
        })->map('ucwords')->implode('>');
        $grid->column('customer.name', __('客服'))->hide();
        $grid->column('author.name', __('录入人员'));
        $grid->column('receive.title', __('接诊主任'));
        $grid->column('cure.title', __('主治医生'));
        $grid->column('come_time', __('预约时间'))->sortable();
        $grid->column('edit_log', __('修改记录'))->hide();
        $grid->column('memo', __('备注'))->hide();
        $grid->column('arrive_time', __('到院时间'))->sortable();
        $grid->column('created_at', __('添加时间'))->sortable();
        $grid->column('updated_at', __('修改时间'))->sortable()->hide();

        $grid->selector(function (Grid\Tools\Selector $selector) {
            $selector->select('status', '状态', [
                0 => '未到',
                1 => '已到',
                2 => '不来了',
            ]);
            $selector->select('come_time', '预约时间', [0 => '昨天', 1 => '今天', 2 => '明天'], function ($query, $value) {
                $date = [
                    date("Y-m-d",strtotime("-1 day")),
                    date("Y-m-d"),
                    date("Y-m-d",strtotime("+1 day"))

                ];
                // dd($date[$value[0]]);
                $query->where('come_time', 'like', $date[$value[0]]."%");
            });
        });


        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('name', '名字');
            $filter->like('tel', '电话号');
            $filter->scope('性别', '男性')->where('sex', '男');

            // 多条件查询
            $filter->scope('new', '最近修改')
                ->whereDate('created_at', date('Y-m-d'))
                ->orWhere('updated_at', date('Y-m-d'));

        });

        return $grid;
    }



    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    public function show($id, Content $content)
    {

        $patient = Admin::show(Patient::findOrFail($id));
        dd($patient->title);
        // 选填
        $content->header('填写页面头标题');

        // 选填
        $content->description('填写页面描述小标题');

        $content->body();

        return $content;
    }
    protected function detail($id)
    {

        // $show = new Show(Patient::findOrFail($id));

        // $show->field('id', __('Id'));
        // $show->field('name', __('Name'));
        // $show->field('sex', __('Sex'));
        // $show->field('age', __('Age'));
        // $show->field('tel', __('Tel'));
        // $show->field('qq', __('Qq'));
        // $show->field('wechat', __('Wechat'));
        // $show->field('content', __('Content'));
        // $show->field('department_id', __('Department id'));
        // $show->field('engine_id', __('Engine id'));
        // $show->field('media_id', __('Media id'));
        // $show->field('keyword', __('Keyword'));
        // $show->field('area_id', __('Area id'));
        // $show->field('admin_user_id', __('Admin user id'));
        // $show->field('author_id', __('Author id'));
        // $show->field('doctor_a_id', __('Doctor a id'));
        // $show->field('doctor_b_id', __('Doctor b id'));
        // $show->field('come_time', __('Come time'));
        // $show->field('status', __('Status'));
        // $show->field('status_info', __('Status info'));
        // $show->field('edit_log', __('Edit log'));
        // $show->field('memo', __('备注'));
        // $show->field('created_at', __('Created at'));
        // $show->field('updated_at', __('Updated at'));

        // return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Patient());

        $form->column(1/2, function ($form) {
            $form->text('name', __('姓名'))->autofocus();
            $form->radioCard('sex', '性别')->options(['未知' => '未知', '男' => '男', '女' => '女'])->default('男');
            $form->text('qq', __('qq号'));
            $form->select('department_id', __('科室'))->options(Department::selectOptions());
            $form->select('engine_id', __('来源'))->options(Engine::all()->pluck('title', 'id'));
            $form->select('media_id', __('渠道'))->options(Media::selectOptions());
            $form->text('keyword', __('关键词'));
            $form->select('area_id', __('地区'))->options(Area::selectOptions());
            $form->select('admin_user_id', __('客服'))->options(User::all()->pluck('name', 'id'));
            $form->hidden('author_id')->value(Admin::user()->id);
        });
        $form->column(1/2, function ($form) {
            $form->select('age', __('年龄'))->options(range(10, 90))->default(40);
            $form->text('tel', __('电话'));
            $form->text('wechat', __('微信号'));
            $form->multipleSelect('diseases', '  疾病')->options(Disease::all()->pluck('title', 'id'));
            $form->datetime('come_time', __('预约时间'))->default(date('Y-m-d H:i:s'));
            $form->textarea('content', __('内容'));
        });
        $form->column(12, function ($form) {
            $form->textarea('memo', __('备注'));
        });


        return $form;
    }
}

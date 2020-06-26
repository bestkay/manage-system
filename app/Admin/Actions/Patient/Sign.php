<?php

namespace App\Admin\Actions\Patient;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Admin\Model\Patient;
use App\Admin\Model\Doctor;

class Sign extends RowAction
{
    public $name = '签到';

    public function handle(Model $model, Request $request)
    {
        $patient = Patient::find($model->id);
        $patient->doctor_b_id = $request['doctor_b_id'];
        $patient->doctor_a_id = $request['doctor_a_id'];
        $patient->status = $request['status'];
        $patient->arrive_time = $request['arrive_time'];
        $patient->memo = $model->memo. '<br>' .$request['memo'];
        $patient->save();

        return $this->response()->success('签到完成')->refresh();
    }

    public function form(Model $model)
	{

    	// 接诊医生
    	$this->select('doctor_b_id', '接诊医生')->options(Doctor::where('parent_id', 2)->pluck('title', 'id'))->default($model->doctor_b_id);
    	// 主治医生
    	$this->select('doctor_a_id', '主治医生')->options(Doctor::where('parent_id', 1)->pluck('title', 'id'))->default($model->doctor_a_id);
	    // 状态选择
    	$this->select('status', '状态')->options([
    		1 => '已到',
    		2 => '不来了'
    	])->default($model->status);;
    	$this->datetime('arrive_time', '到院时间')->default($model->arrive_time);;
        $this->textarea('memo', '备注');
	}

}

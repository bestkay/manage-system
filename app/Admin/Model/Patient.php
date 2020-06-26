<?php

namespace App\Admin\Model;

use Illuminate\Database\Eloquent\Model;
use App\Admin\Model\Disease;
use App\Admin\Model\Department;
use App\Admin\Model\Engine;
use App\Admin\Model\Media;
use App\Admin\Model\Doctor;
use App\Admin\Model\Area;
use Encore\Admin\Auth\Database\Administrator as User;

class Patient extends Model
{

	protected $guarded = [];

	public function diseases()
    {
        return $this->belongsToMany(Disease::class);
    }

    public function department()
    {
    	return $this->belongsTo(Department::class);
    }

    public function engine()
    {
    	return $this->belongsTo(Engine::class);
    }

    public function media()
    {
    	return $this->belongsTo(Media::class);
    }

    public function area()
    {
    	return $this->belongsTo(Area::class);
    }
    public function transform($id){
        //查询数据
        $position = Area::where('id',$id)->first();
        $relation = [];
        $relation[] = $position;
        $pid = $position->parent_id;
        //循环子级pid，查找所有父级id
        while ($top = Area::where(['id' => $pid])->first()) {
            $pid = $top->parent_id;
            //从头部添加数组元素，与 array_push 相似，一个是头部一个是尾部
            array_unshift($relation, $top);
        }
        foreach ($relation as $k => $v){
            $data[] = $v->name ;
        }
        return $data;
    }

    public function transformMedia($id){
        //查询数据
        $position = Media::where('id',$id)->first();
        $relation = [];
        $relation[] = $position;
        $pid = $position->parent_id;
        //循环子级pid，查找所有父级id
        while ($top = Media::where(['id' => $pid])->first()) {
            $pid = $top->parent_id;
            //从头部添加数组元素，与 array_push 相似，一个是头部一个是尾部
            array_unshift($relation, $top);
        }
        foreach ($relation as $k => $v){
            $data[] = $v->title ;
        }
        return $data;
    }

    public function customer()
    {
    	return $this->belongsTo(User::class, 'admin_user_id', 'id');
    }
    public function author()
    {
    	return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function receive()
    {
    	// 接诊主任
    	return $this->belongsTo(Doctor::class, 'doctor_a_id', 'id');
    }
    public function cure()
    {
    	// 主治医生
    	return $this->belongsTo(Doctor::class, 'doctor_b_id', 'id');
    }
}

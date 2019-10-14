<?php

namespace App\Http\Resources\Admin;

use App\Models\AdminEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * 在 C 层输出 V 层时，中间再来一层来专门处理字段问题，
     * 我们可以称之为 ViewModel 层
     * 也就是"将资源转换为数组"
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

       /*
        switch ($this->status){
            case -1:
                $this->status = '已删除';
                break;
            case 0:
                $this->status = '正常';
                break;
            case 1:
                $this->status = '冻结';
                break;
        }
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at'=>(string)$this->created_at,
            'updated_at'=>(string)$this->updated_at
        ];
       */
       //升级使用枚举型
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'status' => AdminEnum::getStatusName($this->status),
            'created_at'=>(string)$this->created_at,
            'updated_at'=>(string)$this->updated_at
        ];
    }
}

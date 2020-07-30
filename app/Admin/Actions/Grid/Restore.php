<?php

namespace App\Admin\Actions\Grid;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 公共行恢复操作类
 * Class Restore
 * @package App\Admin\Actions\Grid
 */
class Restore extends RowAction
{
    /**
     * @return string
     */
	protected $title = '恢复';

    protected $model;

    /**
     * 注意构造方法的参数必须要有默认值
     * 并且在控制器, 添加行操作时, 一定要传对应的模型:
     *      $actions->append(new Restore(Advert::class));
     *
     * Restore constructor.
     * @param string|null $model
     */
    public function __construct(string $model = null)
    {
        $this->model = $model;
    }

    /**
     * Handle the action request.
     *
     * 此方法中处理 我们的业务逻辑
     * 并且 $request->all() 可以看到, 我们在 parameters() 方法里自定义的参数列表
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        //  获取主键
        $key = $this->getKey();

        $model = $request->get('model');

        $model::withTrashed()->findOrFail($key)->restore();

        return $this->response()->success('已恢复')->refresh();
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		 return ['确定恢复此行, 到正常数据列表?'];
	}

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * 自定义要传递的参数 , 此参数会原样从前端传递回来
     *
     * @return array
     */
    protected function parameters()
    {
        return [
            'model' => $this->model,
        ];
    }
}

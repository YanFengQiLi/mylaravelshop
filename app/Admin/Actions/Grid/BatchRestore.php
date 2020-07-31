<?php

namespace App\Admin\Actions\Grid;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 公共批量恢复操作
 * Class BatchRestore
 * @package App\Admin\Actions\Grid
 */
class BatchRestore extends BatchAction
{
    /**
     * @return string
     */
	protected $title = '批量恢复';

    protected $model;

    // 注意构造方法的参数必须要有默认值
    public function __construct(string $model = null)
    {
        $this->model = $model;
    }

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $model = $request->get('model');

        foreach ((array) $this->getKey() as $key) {
            $model::withTrashed()->findOrFail($key)->restore();
        }

        return $this->response()->success('已恢复')->refresh();
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		 return ['你确定要恢复,你选中的这些数据?'];
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
     * @return array
     */
    protected function parameters()
    {
        return [
            'model' => $this->model,
        ];
    }
}

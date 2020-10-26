<?php

namespace App\Admin\Actions\Grid;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 公共批量删除方法
 * Class BatchDelete
 * @package App\Admin\Actions\Grid
 */
class BatchDelete extends BatchAction
{
    /**
     * @return string
     */
	protected $title = '批量删除';

    protected $model;

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
        $idsArr = (array) $this->getKey();

        $model = $request->get('model');

        $model::whereIn('id', $idsArr)->delete();

        return $this->response()->success('删除成功')->refresh();
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		 return ['确认删除,这些选中的数据?'];
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

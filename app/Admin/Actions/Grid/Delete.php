<?php

namespace App\Admin\Actions\Grid;

use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 公共删除删除方法
 * Class Delete
 * @package App\Admin\Actions\Grid
 */
class Delete extends RowAction
{
    /**
     * @return string
     */
	public function title()
    {
        return '<i class="feather icon-trash"></i> ';
    }

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
        $id = $this->getKey();

        $model = $request->get('model');

        $model::where('id', $id)->delete();

        return $this->response()->success('删除成功')->refresh();
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		 return ['确定删除这条数数据?'];
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
            'model' => $this->model
        ];
    }

    //  设置 删除按钮的 html 显式属性
    public function html()
    {
        $this->setHtmlAttribute([
            'data-url'     => $this->url(),
            'data-action'  => 'delete',
        ]);

        return parent::html();
    }

    public function url()
    {
        return "{$this->resource()}/{$this->getKey()}";
    }
}

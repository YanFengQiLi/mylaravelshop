<?php

namespace App\Admin\Actions\Grid;

use App\Models\AdminMessage;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 后台消息, 标记为已读
 * Class Read
 * @package App\Admin\Actions\Grid
 */
class Read extends RowAction
{
    /**
     * @return string
     */
	protected $title = '标记为已读';

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

        $message = AdminMessage::find($id);

        $message->status = 1;

        $message->save();

        return $this->response()->success('标记成功')->refresh();
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		 return ['确定将此条消息, 标记为已读?'];
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

}

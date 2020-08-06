<?php

namespace App\Admin\Actions\Grid;

use App\Models\AdminMessage;
use Carbon\Carbon;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * 批量标记为已读
 * Class BatchRead
 * @package App\Admin\Actions\Grid
 */
class BatchRead extends BatchAction
{
    /**
     * @return string
     */
	protected $title = '批量标记';

    /**
     * Handle the action request.
     * @return Response
     */
    public function handle()
    {
        $idsArr = $this->getKey();

        AdminMessage::whereIn('id', $idsArr)->update([
            'status' => 1,
            'updated_at' => Carbon::now()
        ]);

        return $this->response()->success('标记成功')->refresh();
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		 return ['确认将选中项标记为已读?'];
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

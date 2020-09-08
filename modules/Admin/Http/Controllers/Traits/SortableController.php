<?php

namespace Modules\Admin\Http\Controllers\Traits;

use App\Models\Traits\SortableTrait;
use Modules\Admin\Http\Requests\SortRequest;

/**
 * @property SortableTrait|string $modelClass
 */
trait SortableController
{
    public function sort(SortRequest $request)
    {
        $order = $request->input('order');
        \DB::transaction(fn() => $this->modelClass::setNewOrder($order));
        return response()->json(['status' => 'Sectors has been sorted']);
    }
}

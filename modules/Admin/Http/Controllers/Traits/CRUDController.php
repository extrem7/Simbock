<?php

namespace Modules\Admin\Http\Controllers\Traits;

/**
 * @property string $resource
 */
trait CRUDController
{
    protected function listing()
    {
        return view('admin::crud.index', ['resource' => $this->resource]);
    }

    protected function form()
    {
        return view('admin::crud.form', ['resource' => $this->resource]);
    }
}

<?php

namespace MerakiShop\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    public function getQueries($fields = [])
    {
        $fields = array_merge(['page', 'filter', 'sort'], $fields);

        return $this->request()->only($fields);
    }
}

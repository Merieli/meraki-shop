<?php

namespace MerakiShop\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    /**
     * Get all queries of request
     * @param array<string> $fields
     * @return array<mixed>
     */
    public function getQueries(array $fields = []): array
    {
        $fields = array_merge(['page', 'filter', 'sort'], $fields);

        return request()->only($fields);
    }
}

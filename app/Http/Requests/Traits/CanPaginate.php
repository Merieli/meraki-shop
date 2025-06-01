<?php

namespace MerakiShop\Repositories\Concerns\Query;

use Illuminate\Pagination\LengthAwarePaginator;

trait CanPaginate
{
    public function paginate(array $query = []): LengthAwarePaginator
    {
        return $this->getResource()
            ->paginate($query, true)
            ->toPaginator();
    }
}

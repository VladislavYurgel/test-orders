<?php

namespace App\Repositories;

use App\Models\Good;

class GoodRepository
{
    /**
     * @param int $id
     * @return Good
     */
    public function getById(int $id): Good
    {
        return Good::find($id);
    }
}

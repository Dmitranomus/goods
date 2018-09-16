<?php
namespace App\Services;

class Categories
{
    /**
     * @return array
     */
    public function list()
    {
        return \App\Repositories\Categories::list();
    }
}

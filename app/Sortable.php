<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 8/3/2016
 * Time: 9:14 PM
 */

namespace app;


trait Sortable
{
    public static function sortable($list = false)
    {
        return ($list ? implode(',', static::$sortable_columns) : static::$sortable_columns);
    }
}
<?php

namespace Bedard\Backend\Http\Controllers;

use Bedard\Backend\Classes\SortOrder;
use Bedard\Backend\Exceptions\InvalidSortOrderException;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function applySortOrderToQuery($query, string $default = 'id,desc')
    {
        try {
            $order = SortOrder::from(request()->query('order') ?? $default);

            if ($order->direction === 1) {
                $query->orderBy($order->property);
            } elseif ($order->direction === -1) {
                $query->orderByDesc($order->property);
            }

            return $order;
        } catch (InvalidSortOrderException $e) {}

        return null;
    }
}
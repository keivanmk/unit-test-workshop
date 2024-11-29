<?php

namespace App;

class UserService
{
    private OrderService $orderService;

    public function __construct(OrderServiceInterface $orderService,string $mysqlConnection)
    {
        $this->orderService= $orderService;
        //env('MYSQL_CONNECTION');
//        $result = do some calculation

    }
}


$userService = new UserService(new MockOrderService());

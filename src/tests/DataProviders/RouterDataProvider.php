<?php

namespace Tests\DataProviders;

class RouterDataProvider
{
    public function routeNotFoundCases(): array
    {
        return [
            ['/users', 'put'], // requestUri found & requestMethod not found
            ['/invoice', 'post'], // requestUri not found & requestMethod found
            ['/users', 'get'], // class does not exist
            ['/users', 'post'], // class exists & method does not exist
        ];
    }
}
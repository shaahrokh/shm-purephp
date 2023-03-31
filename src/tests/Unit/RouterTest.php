<?php

namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        parent::setUp();

        $this->router = new Router();
    }

    /** @test */
    public function it_register_a_route(): void
    {
        $this->router->register('get', '/users', ['Users', 'index']);

        $excepted = [
            'get' => [
                '/users' => ['Users', 'index']
            ]
        ];
        $this->assertEquals($excepted, $this->router->routes());
    }

    /** @test */
    public function it_register_a_get_route(): void
    {
        $this->router->get('/users', ['Users', 'index']);

        $excepted = [
            'get' => [
                '/users' => ['Users', 'index']
            ]
        ];
        $this->assertEquals($excepted, $this->router->routes());
    }

    /** @test */
    public function it_register_a_post_route(): void
    {
        $this->router->post('/users', ['Users', 'index']);

        $excepted = [
            'post' => [
                '/users' => ['Users', 'index']
            ]
        ];
        $this->assertEquals($excepted, $this->router->routes());
    }

    /** @test */
    public function there_are_no_routes_when_route_is_created(): void
    {
        $this->assertEmpty((new Router())->routes());
    }

    /**
     * @test
     * @dataProvider  \Tests\DataProviders\RouterDataProvider::routeNotFoundCases
     */
    public function it_throw_exception_route_not_found(
        string $requestUri,
        string $requestMethod
    ): void
    {
        $user = new class() {
            public function delete(): bool
            {
                return true;
            }
        };

        $this->router->post('/users', [$user::class , 'store']);
        $this->router->get('/users', ['Users' , 'index']);

        // var_dump($this->router->routes());

        /*
        the expectException assertion has to happen before calling
        the method that actually throws the exception otherwise if
        we did it the other way, and we put expectException after this would
        throw the exception, and it would stop the execution so we need to
        add this beforehand
        */
        $this->expectException(RouteNotFoundException::class);

        $this->router->resolve($requestUri, $requestMethod);
    }

    /** @test */
    public function it_resolves_route_from_closure(): void
    {
        $this->router->get('/users', fn() => [1, 2, 3]);

        $this->assertEquals([1, 2, 3], $this->router->resolve('/users', 'get'));
    }

    /** @test */
    public function it_resolves_route_from_array(): void
    {
        $user = new class() {
            public function index(): array
            {
                return [1, 2, 3];
            }
        };

        $this->router->get('/users', [$user::class, 'index']);

        $this->assertSame([1, 2, 3], $this->router->resolve('/users', 'get'));
    }

}
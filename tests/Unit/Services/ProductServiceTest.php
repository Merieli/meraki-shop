<?php

namespace Tests\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Contracts\ProductRepositoryInterface;
use MerakiShop\Facades\Logger;
use MerakiShop\Models\Product;
use MerakiShop\Services\ProductService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;

class ProductServiceTest extends MockeryTestCase
{
    private MockInterface|ProductRepositoryInterface $repository;
    private ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();

        if (!defined('Logger')) {
            define(Logger::class, 'Logger');
        }

        $this->repository = Mockery::mock(ProductRepositoryInterface::class);
        $this->service = new ProductService($this->repository);

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_products_should_return_builder()
    {
        Logger::shouldReceive('info')->andReturnNull();
        // Logger::shouldReceive('error')->andReturnNull();

        $request = Mockery::mock(Request::class);
        $expectedBuilder = Mockery::mock(Builder::class);
        // Define o comportamento esperado do repository
        $this->repository
        ->shouldReceive('list')
        ->once()
        ->with($request)
        ->andReturn($expectedBuilder);
        
        $result = $this->service->getProducts($request);

        self::assertSame($expectedBuilder, $result);
    }

    /** DADOS */
    public function productOrNull(): array
    {
        return [
            [null],
            [Mockery::mock(Product::class)]
        ];
    }

    /**
     * @dataProvider productOrNull
     */
    public function test_find_product_should_return_product_or_null(?Product $expectedReturn)
    {
        $mockId = 3;

        $this->repository
            ->shouldReceive('findById')
            ->once()
            ->with($mockId)
            ->andReturn($expectedReturn);

        $result = $this->service->findProduct($mockId);

        self::assertSame($expectedReturn, $result);
    }

}

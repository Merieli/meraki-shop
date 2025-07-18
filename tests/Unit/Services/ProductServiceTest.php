<?php

namespace Tests\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Contracts\Repositories\ProductRepositoryInterface;
use MerakiShop\Facades\Logger;
use MerakiShop\Models\Product;
use MerakiShop\Repositories\ProductRepository;
use MerakiShop\Services\ProductService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;

final class ProductServiceTest extends MockeryTestCase
{
    private MockInterface|ProductRepositoryInterface $repository;

    private ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Logger::shouldReceive('info')->andReturnNull();
        Logger::shouldReceive('error')->andReturnNull();
        $this->repository = Mockery::mock(ProductRepository::class);
        $this->service = new ProductService($this->repository);

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_products_should_return_builder()
    {
        $request = Mockery::mock(Request::class);
        $expected = Mockery::mock(Builder::class);
        $this->repository
            ->shouldReceive('list')
            ->once()
            ->with($request)
            ->andReturn($expected);

        $result = $this->service->getProducts($request);

        self::assertSame($expected, $result);
    }

    public function skip_test_create_product_should_return_product()
    {
    }

    public function test_find_product_should_return_product()
    {
        $mockId = 3;
        $product = Mockery::mock(Product::class);

        $this->repository
            ->shouldReceive('findById')
            ->once()
            ->with($mockId)
            ->andReturn($product);

        $result = $this->service
            ->findProduct($mockId);

        self::assertSame($product, $result);
    }
}

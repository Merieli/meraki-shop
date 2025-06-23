<?php

namespace Tests\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MerakiShop\Contracts\ProductRepositoryInterface;
use MerakiShop\Services\ProductService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ProductServiceTest extends MockeryTestCase
{
    private ProductRepositoryInterface $repository;
    private ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock do repository
        $this->repository = Mockery::mock(ProductRepositoryInterface::class);
        
        // Instância do service com o mock
        $this->service = new ProductService($this->repository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_products_should_return_builder()
    {
        // Arrange
        $request = Mockery::mock(Request::class);
        $expectedBuilder = Mockery::mock(Builder::class);
        
        // Define o comportamento esperado do repository
        $this->repository
            ->shouldReceive('list')
            ->once()
            ->with($request)
            ->andReturn($expectedBuilder);

        // Act
        $result = $this->service->getProducts($request);

        // Assert
        self::assertSame($expectedBuilder, $result );
    }
}

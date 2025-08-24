<?php

namespace MerakiShop\DTOs;

readonly class ResponseToken
{
    public function __construct(
        public string $token,
    ) {
    }
}

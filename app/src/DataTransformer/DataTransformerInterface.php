<?php

declare(strict_types=1);

namespace App\DataTransformer;

interface DataTransformerInterface
{
    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    public function transform($from, $to = null): mixed;
}
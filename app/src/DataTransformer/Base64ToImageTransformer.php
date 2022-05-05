<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\HttpFoundation\File\Base64EncodedFile;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
final class Base64ToImageTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $value
     * @return string|null
     */
    public function transform(mixed $value): ?string
    {
        return $value;
    }

    /**
     * @param $value
     * @return File|null
     */
    public function reverseTransform($value): ?File
    {
        if (!$value) {
            return null;
        }

        return new Base64EncodedFile($value);
    }
}

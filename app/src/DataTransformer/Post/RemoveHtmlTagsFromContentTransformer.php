<?php

declare(strict_types=1);

namespace App\DataTransformer\Post;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
final class RemoveHtmlTagsFromContentTransformer implements DataTransformerInterface
{
    private const ALLOWED_TAGS = ['ul', 'li', 'ol', 'p', 'strong'];

    public function transform(mixed $value): ?string
    {
        return $value;
    }

    /**
     * @param mixed $value
     * @return string|null
     */
    public function reverseTransform(mixed $value): ?string
    {
        if (!$value) {
            return null;
        }

        return strip_tags($value, self::ALLOWED_TAGS);
    }
}

<?php

declare(strict_types=1);

namespace App\DataTransformer\Post;

use App\Dto\Post\PostOutput;
use App\Entity\Post;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
final class PostOutputTransformer
{
    public function transform(Post $from): PostOutput
    {
        return (new PostOutput())
            ->setUuid((string)$from->getUuid())
            ->setTitle($from->getTitle())
            ->setContent($from->getContent())
            ->setImage($from->getImageName());
    }
}

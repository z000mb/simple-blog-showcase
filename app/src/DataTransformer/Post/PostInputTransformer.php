<?php

declare(strict_types=1);

namespace App\DataTransformer\Post;

use App\Dto\Post\PostInput;
use App\Entity\Post;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
final class PostInputTransformer
{
    public function __construct(
        private readonly ?array $uploadedImagesConfig,
        private readonly string $appUrl
    ) {
    }

    public function transform(PostInput $from, $to = null): Post
    {
        $config = $this->uploadedImagesConfig;
        $file = $from->getImage();

        $fileName = md5(uniqid($file->getFilename(), true));
        if ($file->getExtension()) {
            $fileName .= '.' . $file->getExtension();
        }

        $image = sprintf("%s/%s/%s", $this->appUrl, $config['postImageUriPath'], $fileName);

        $file->move($config['postImageDir'], $fileName);

        return (new Post())
            ->setTitle($from->getTitle())
            ->setContent($from->getContent())
            ->setImageName($image);
    }
}

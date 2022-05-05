<?php

declare(strict_types=1);

namespace App\Dto\Post;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
final class PostOutput
{
    private ?string $uuid = null;
    private ?string $title = null;
    private ?string $content = null;
    private ?string $image = null;

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string|null $uuid
     * @return PostOutput
     */
    public function setUuid(?string $uuid): PostOutput
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return PostOutput
     */
    public function setTitle(?string $title): PostOutput
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return PostOutput
     */
    public function setContent(?string $content): PostOutput
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return PostOutput
     */
    public function setImage(?string $image): PostOutput
    {
        $this->image = $image;
        return $this;
    }
}

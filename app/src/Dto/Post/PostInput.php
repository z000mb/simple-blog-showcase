<?php

declare(strict_types=1);

namespace App\Dto\Post;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
final class PostInput
{
    private const EXAMPLE_IMAGE = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD//gAfQ29tcHJlc3NlZCBieSBqcGVnLXJlY29tcHJlc3P/2wCEAAQEBAQEBAQEBAQGBgUGBggHBwcHCAwJCQkJCQwTDA4MDA4MExEUEA8QFBEeFxUVFx4iHRsdIiolJSo0MjRERFwBBAQEBAQEBAQEBAYGBQYGCAcHBwcIDAkJCQkJDBMMDgwMDgwTERQQDxAUER4XFRUXHiIdGx0iKiUlKjQyNEREXP/CABEIACAAIAMBIgACEQEDEQH/xAAaAAEAAgMBAAAAAAAAAAAAAAAHBAgAAgUG/9oACAEBAAAAALjg8ewA2o8cyVY+eOe686sn/8QAFgEBAQEAAAAAAAAAAAAAAAAAAwQF/9oACAECEAAAANlJ1//EABcBAAMBAAAAAAAAAAAAAAAAAAMEBQb/2gAIAQMQAAAAwwKSn//EAC0QAAICAQMBBQcFAAAAAAAAAAECAwQFAAYREiExMlJxEyMzQUJRYRQWImJy/9oACAEBAAE/AN67zj27EtSoqyX5V5VT3IvmbWRyOdyiG/fnsyQs/SHPIi5P0jjs1QzOUxcolo3pomHyDcqfUHsOtkb2TcEbUrgWK/GvJA8Mg8y6myhv7ulyE9FryG0wFbp6yyL/ABAA1FL+66mR25kqcOPkCJLWjjZXaNQfqA7mH21S25suY3sBRsm1lDBJ79uT0Mvl+WsPasYXPVJvDJBZCSD8c9LDVupHi7NmrFCldHkYdxhWTn/PVNMfwOF0ktinbqT1UZrNZupawARmRuxlEMfIjB80h51Jm9m4a/bztWGwcpKJPcEEKHbxf10uIq5LJ4GSnkltW8hMZrcSr8E89ba3BhP1kT2ag6bKoRwr+yMv2RpACwX01nZ9x1zJSu1Ho1ufgwp0RN6sPH6k6Mue3NWxeLgoe1Smns42ij47Pu7d2tl7MXb0bXLhWTISrwSPDGvlXX//xAAfEQACAQQCAwAAAAAAAAAAAAABAhEAAwQTIUESJFH/2gAIAQIBAT8AQLhrbOsEkAu3yri2cxLgVCtxRIJEE1j+xx5CewacriITsO0iImeOq//EACIRAAICAQQBBQAAAAAAAAAAAAECAwQFABESIRMxUWFxgf/aAAgBAwEBPwCd5c3LYAtMiqSsMQB2Yj3PzqrLcwstYyTrJXkYq6q3JQR6/o1kgccefjbhvuhQdDVdJsvOkYrqKqkOX4FNmPbfZOv/2Q==";

    #[OA\Property(
        type: 'string',
        default: 'Great post!'
    )]
    #[Assert\NotBlank]
    #[Assert\Length(min: 10, max: 80)]
    private string $title;

    #[OA\Property(
        type: 'string',
        default: 'Very interesting post content.'
    )]
    #[Assert\NotBlank]
    #[Assert\Length(min: 20)]
    private string $content;

    #[OA\Property(
        type: 'string',
        default: self::EXAMPLE_IMAGE)]
    #[Assert\NotBlank]
    #[Assert\Image(
        maxSize: '1M',
        mimeTypes: [
        'image/jpeg',
        'image/jpg'
        ],
        mimeTypesMessage: 'Mime type not allowed. Only allow jpg/jpeg'
    )]
    private File $image;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return PostInput
     */
    public function setTitle(string $title): PostInput
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return PostInput
     */
    public function setContent(string $content): PostInput
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return File
     */
    public function getImage(): File
    {
        return $this->image;
    }

    /**
     * @param File $image
     * @return PostInput
     */
    public function setImage(File $image): PostInput
    {
        $this->image = $image;
        return $this;
    }
}

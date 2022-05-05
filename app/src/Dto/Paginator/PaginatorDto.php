<?php

declare(strict_types=1);

namespace App\Dto\Paginator;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
final class PaginatorDto
{
    private int $pageNumber;
    private int $pageSize;

    private int $totalItems = 0;
    private int $totalPages = 1;

    /**
     * @param int $pageNumber
     * @param int $pageSize
     */
    public function __construct(int $pageNumber = 1, int $pageSize = 5)
    {
        $this->pageNumber = $pageNumber;
        $this->pageSize = $pageSize;
    }

    /**
     * @return int
     */
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * @param int|null $pageNumber
     * @return PaginatorDto
     */
    public function setPageNumber(?int $pageNumber): PaginatorDto
    {
        if ($pageNumber !== null) {
            $this->pageNumber = $pageNumber;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @param int|null $pageSize
     * @return PaginatorDto
     */
    public function setPageSize(?int $pageSize): PaginatorDto
    {
        if ($pageSize !== null) {
            $this->pageSize = $pageSize;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    /**
     * @param int $totalItems
     * @return PaginatorDto
     */
    public function setTotalItems(int $totalItems): PaginatorDto
    {
        $this->totalItems = $totalItems;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @param int $totalPages
     * @return PaginatorDto
     */
    public function setTotalPages(int $totalPages): PaginatorDto
    {
        $this->totalPages = $totalPages;
        return $this;
    }
}

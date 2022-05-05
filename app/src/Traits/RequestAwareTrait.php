<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\HttpFoundation\{Request, RequestStack};

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
trait RequestAwareTrait
{
    protected ?Request $request;

    /**
     * @param RequestStack $requestStack
     * @required
     */
    public function setRequest(RequestStack $requestStack): void
    {
        $this->request = $requestStack->getCurrentRequest();
    }
}

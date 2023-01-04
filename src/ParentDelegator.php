<?php

declare(strict_types=1);

namespace Devly\ACF;

use BadMethodCallException;

use function call_user_func_array;
use function method_exists;

abstract class ParentDelegator
{
    /** @var mixed */
    protected ?object $parentContext;

    /**
     * @param array<array-key, mixed> $arguments
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        if ($this->parentContext !== null) {
            if (method_exists($this->parentContext, $method)) {
                return call_user_func_array([$this->parentContext, $method], $arguments);
            }
        }

        throw new BadMethodCallException($method . ' not exists.');
    }

    public function getParentContext(): ?object
    {
        return $this->parentContext;
    }

    public function setParentContext(?object $parentContext = null): ParentDelegator
    {
        $this->parentContext = $parentContext;

        return $this;
    }
}

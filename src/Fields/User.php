<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function is_array;
use function sprintf;

class User extends FieldBuilder
{
    protected string $type = 'user';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'role'          => '',
            'allow_null'    => 0,
            'multiple'      => 0,
            'return_format' => 'array',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function allowNull(): self
    {
        return $this->set('allow_null', 1);
    }

    public function disallowNull(): self
    {
        return $this->set('allow_null', 0);
    }

    public function allowMultiSelect(): self
    {
        return $this->set('multiple', 1);
    }

    public function disallowMultiSelect(): self
    {
        return $this->set('multiple', 0);
    }

    /** @param string|string[] $roles */
    public function addRoles($roles): self
    {
        if (! is_array($this->config['role'])) {
            $this->config['role'] = [];
        }

        foreach ((array) $roles as $role) {
            $this->config['role'][] = $role;
        }

        return $this;
    }

    public function returnFormat(string $type): self
    {
        $supported = ['array', 'id', 'object'];
        if (! in_array($type, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided return type is unsupported. Supported types: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('return_format', $type);
    }
}

<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class Number extends FieldBuilder
{
    protected string $type = 'number';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'default_value' => '',
            'placeholder'   => '',
            'prepend'       => '',
            'append'        => '',
            'min'           => '',
            'max'           => '',
            'step'          => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    /** @param mixed $value */
    public function default($value): self
    {
        return $this->set('default_value', $value);
    }

    public function placeholder(string $value): self
    {
        return $this->set('placeholder', $value);
    }

    public function prepend(string $value): self
    {
        return $this->set('prepend', $value);
    }

    public function append(string $value): self
    {
        return $this->set('append', $value);
    }

    public function min(int $value): self
    {
        return $this->set('min', $value);
    }

    public function max(int $value): self
    {
        return $this->set('max', $value);
    }

    public function step(int $value): self
    {
        return $this->set('step', $value);
    }
}

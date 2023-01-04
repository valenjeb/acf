<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class Password extends FieldBuilder
{
    protected string $type = 'password';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'placeholder' => '',
            'prepend'     => '',
            'append'      => '',
        ], $config);

        parent::__construct($key, $config, $parentContext);
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
}

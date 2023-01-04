<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class Accordion extends FieldBuilder
{
    protected string $type = 'accordion';

    /** @inheritdoc */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'open'         => 1,
            'multi_expand' => 0,
            'endpoint'     => 0,
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function openOnPageLoad(): self
    {
        return $this->set('open', 1);
    }

    public function closedOnPageLoad(): self
    {
        return $this->set('open', 0);
    }

    public function multiExpand(): self
    {
        return $this->set('multi_expand', 1);
    }

    public function notMultiExpand(): self
    {
        return $this->set('multi_expand', 0);
    }

    public function isEndpoint(): self
    {
        return $this->set('endpoint', 1);
    }

    public function isNotEndpoint(): self
    {
        return $this->set('endpoint', 0);
    }
}

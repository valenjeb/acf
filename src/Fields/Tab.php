<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class Tab extends FieldBuilder
{
    protected string $type = 'tab';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'placement' => 'top',
            'endpoint'  => 0,
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function placementTop(): self
    {
        return $this->set('placement', 'top');
    }

    public function placementSide(): self
    {
        return $this->placementLeft();
    }

    public function placementLeft(): self
    {
        return $this->set('placement', 'left');
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

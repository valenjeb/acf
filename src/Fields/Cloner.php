<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;
use function is_array;

class Cloner extends FieldBuilder
{
    protected string $type = 'clone';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'clone'        => '',
            'display'      => 'seamless',
            'layout'       => 'block',
            'prefix_label' => 0,
            'prefix_name'  => 0,
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function prefixLabel(): self
    {
        return $this->set('prefix_label', 1);
    }

    public function prefixName(): self
    {
        return $this->set('prefix_name', 1);
    }

    public function blockLayout(): self
    {
        return $this->set('layout', 'block');
    }

    public function rowLayout(): self
    {
        return $this->set('layout', 'row');
    }

    public function tableLayout(): self
    {
        return $this->set('layout', 'table');
    }

    public function displaySeamless(): self
    {
        return $this->set('display', 'seamless');
    }

    public function displayGroup(): self
    {
        return $this->set('display', 'group');
    }

    /** @param string|string[] $keys */
    public function clone($keys): self
    {
        if (! is_array($this->config['clone'])) {
            $this->config['clone'] = [];
        }

        foreach ((array) $keys as $key) {
            $this->config['clone'][] = $key;
        }

        return $this;
    }
}

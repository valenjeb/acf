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

class PostObject extends FieldBuilder
{
    protected string $type = 'post_object';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'post_type'     => '',
            'taxonomy'      => '',
            'allow_null'    => 0,
            'multiple'      => 0,
            'required'      => 0,
            'return_format' => 'object',
            'ui'            => 1,
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    /** @param string|string[] $postType */
    public function filterByPostType($postType): self
    {
        $postType = is_array($postType) ? $postType : [$postType];

        if (! is_array($this->config['post_type'])) {
            $this->config['post_type'] = [];
        }

        foreach ($postType as $type) {
            $this->config['post_type'][] = $type;
        }

        return $this;
    }

    /** @param string|string[] $taxonomies */
    public function filterByTaxonomy($taxonomies): self
    {
        foreach ((array) $taxonomies as $taxonomy) {
            $this->config['taxonomy'][] = $taxonomy;
        }

        return $this;
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

    public function stylisedUI(): self
    {
        return $this->set('ui', 1);
    }

    public function unstylisedUI(): self
    {
        return $this->set('ui', 1);
    }

    public function returnFormat(string $format): self
    {
        $supported = ['id', 'object'];
        if (! in_array($format, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided return type is unsupported. Supported types: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('return_format', $format);
    }
}

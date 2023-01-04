<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function sprintf;

class Relationship extends FieldBuilder
{
    protected string $type = 'relationship';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'post_type'     => '',
            'taxonomy'      => '',
            'filters'       => [
                'search',
                'post_type',
                'taxonomy',
            ],
            'elements'      => '',
            'min'           => '',
            'max'           => '',
            'return_format' => 'object',
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    /** @param string|string[] $postType */
    public function filterByPostType($postType): self
    {
        foreach ((array) $postType as $type) {
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

    /** @param string[] $filters */
    public function setFilters(array $filters): self
    {
        return $this->set('filters', $filters);
    }

    public function returnFormat(string $type): self
    {
        $supported = ['id', 'object'];
        if (! in_array($type, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided return type is unsupported. Supported types: %s.',
                implode(', ', $supported)
            ));
        }

        return $this->set('return_format', $type);
    }

    /** @param string|string[] $elements */
    public function addElements($elements): self
    {
        foreach ((array) $elements as $element) {
            $this->config['elements'][] = $element;
        }

        return $this;
    }

    public function minPosts(int $count): self
    {
        return $this->set('min', $count);
    }

    public function maxPosts(int $count): self
    {
        return $this->set('max', $count);
    }
}

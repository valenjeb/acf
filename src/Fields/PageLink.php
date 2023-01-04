<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;

use function array_replace_recursive;

class PageLink extends FieldBuilder
{
    protected string $type = 'page_link';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'post_type'      => '',
            'taxonomy'       => '',
            'allow_null'     => 0,
            'allow_archives' => 0,
            'multiple'       => 0,
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

    public function allowNull(): self
    {
        return $this->set('allow_null', 1);
    }

    public function allowArchivesUrls(): self
    {
        return $this->set('allow_archives', 1);
    }

    public function allowMultiSelect(): self
    {
        return $this->set('multiple', 1);
    }
}

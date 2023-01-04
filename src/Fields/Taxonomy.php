<?php

declare(strict_types=1);

namespace Devly\ACF\Fields;

use Devly\ACF\FieldBuilder;
use InvalidArgumentException;

use function array_replace_recursive;
use function implode;
use function in_array;
use function sprintf;

class Taxonomy extends FieldBuilder
{
    protected string $type = 'taxonomy';

    /** @inheritdoc  */
    public function __construct(string $key, array $config = [], ?object $parentContext = null)
    {
        $config = array_replace_recursive([
            'taxonomy'      => 'category',
            'field_type'    => 'checkbox',
            'add_term'      => 1,
            'save_terms'    => 0,
            'load_terms'    => 0,
            'return_format' => 'id',
            'multiple'      => 0,
            'allow_null'    => 0,
        ], $config);

        parent::__construct($key, $config, $parentContext);
    }

    public function taxonomy(string $taxonomy): self
    {
        return $this->set('taxonomy', $taxonomy);
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

    public function allowCreateTerms(): self
    {
        return $this->set('add_term', 1);
    }

    public function disallowCreateTerms(): self
    {
        return $this->set('add_term', 0);
    }

    public function loadValueFromPostsTerms(): self
    {
        return $this->set('load_terms', 1);
    }

    public function doNotLoadValueFromPostsTerms(): self
    {
        return $this->set('load_terms', 0);
    }

    public function saveTerms(): self
    {
        return $this->set('save_terms', 1);
    }

    public function doNotSaveTerms(): self
    {
        return $this->set('save_terms', 0);
    }

    public function setTypeCheckbox(): self
    {
        return $this->set('field_type', 'checkbox');
    }

    public function setTypeMultiSelect(): self
    {
        return $this->set('field_type', 'multi_select');
    }

    public function setTypeSelect(): self
    {
        return $this->set('field_type', 'select');
    }

    public function setTypeRadio(): self
    {
        return $this->set('field_type', 'radio');
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
}

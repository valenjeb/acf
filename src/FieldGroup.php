<?php

declare(strict_types=1);

namespace Devly\ACF;

use InvalidArgumentException;
use RuntimeException;

use function acf_add_local_field_group;
use function array_replace_recursive;
use function class_exists;
use function func_get_args;
use function func_num_args;
use function function_exists;
use function implode;
use function in_array;
use function is_array;
use function sprintf;
use function str_replace;
use function trigger_error;
use function ucwords;

use const E_USER_DEPRECATED;

class FieldGroup extends FieldGroupBuilder
{
    protected string $key;
    protected string $title;
    /** @var LocationManager[] */
    protected array $location;
    /** @var array<string, mixed>  */
    protected array $options;
    protected LocationManager $locationManager;
    protected bool $active;
    protected string $style;
    protected string $position;
    protected string $description;
    protected string $labelPlacement;
    protected string $instructionPlacement;
    protected int $showInRest;
    protected int $menuOrder;
    /** @var string[] */
    protected array $hideOnScreen;
    protected bool $isRegistered = false;

    /** @param array<string, mixed> $options */
    public function __construct(string $key, ?string $title = null, array $options = [], ?object $parentContext = null)
    {
        if (! class_exists('ACF')) {
            throw new RuntimeException('The Advanced Custom Fields plugin is not installed.');
        }

        $this->key     = $key;
        $this->title   = $title ?? $this->generateLabel($key);
        $this->options = $options;
        $this->setParentContext($parentContext);

        add_action('acf/init', function () {
            if ($this->isRegistered) {
                return;
            }

            $this->registerFieldGroup();
        }, PHP_INT_MAX);
    }

    protected function generateLabel(string $key): string
    {
        return ucwords(str_replace('_', ' ', $key));
    }

    /** @param array<string, mixed> $options */
    public static function create(string $key, ?string $title = null, array $options = []): self
    {
        return new self($key, $title, $options);
    }

    /**
     * @param string|mixed $operatorOrValue
     * @param mixed        $value
     */
    public function addLocation(string $param, $operatorOrValue, $value = null): LocationManager
    {
        if (func_num_args() === 2) {
            $value           = $operatorOrValue;
            $operatorOrValue = '==';
        }

        return $this->createLocationManager()->where($param, $operatorOrValue, $value);
    }

    /**
     * @param string|mixed $operatorOrValue
     * @param mixed        $value
     */
    public function where(string $param, $operatorOrValue, $value = null): LocationManager
    {
        if (func_num_args() === 2) {
            $value           = $operatorOrValue;
            $operatorOrValue = '==';
        }

        return $this->createLocationManager()->where($param, $operatorOrValue, $value);
    }

    /**
     * @param string|mixed $operatorOrValue
     * @param mixed        $value
     */
    public function orWhere(string $param, $operatorOrValue, $value = null): LocationManager
    {
        if (func_num_args() === 2) {
            $value           = $operatorOrValue;
            $operatorOrValue = '==';
        }

        return $this->createLocationManager()->where($param, $operatorOrValue, $value);
    }

    protected function createLocationManager(): LocationManager
    {
        $manager          = new LocationManager($this);
        $this->location[] = $manager;

        return $manager;
    }

    public function active(bool $active = true): self
    {
        $this->active = $active;

        return $this;
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Whether to show the metabox value in rest responses.
     */
    public function showInRest(bool $show = true): self
    {
        $this->showInRest = $show ? 1 : 0;

        return $this;
    }

    /**
     * Hide element on the admin screen.
     *
     * @param string|string[] $items
     */
    public function hideOnScreen($items): self
    {
        $items = is_array($items) ? $items : func_get_args();

        foreach ($items as $item) {
            $this->hideOnScreen[] = $item;
        }

        return $this;
    }

    /**
     * Determines where field labels are places in relation to fields. Defaults to 'top'.
     *
     * @param string $placement Choices of 'top' (Above fields) or 'left' (Beside fields).
     */
    public function labelPlacement(string $placement): self
    {
        $supported = ['top', 'left'];
        if (! in_array($placement, $supported)) {
            throw new InvalidArgumentException(
                'Provided label placement is unsupported. Supported placement: ' . implode(', ', $supported)
            );
        }

        $this->labelPlacement = $placement === 'side' ? 'left' : $placement;

        return $this;
    }

    /**
     * Determines where field instructions are places in relation to fields.
     *
     * @param string $placement Choices of 'label' (Below labels) or 'field' (Below fields). Default to label.
     */
    public function instructionPlacement(string $placement): self
    {
        $supported = ['label', 'field'];
        if (! in_array($placement, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided instruction placement is unsupported. Supported placement: %s',
                implode(', ', $supported)
            ));
        }

        $this->instructionPlacement = $placement;

        return $this;
    }

    /**
     * Determines the position on the edit screen.
     *
     * @param string $position Choices of 'acf_after_title', 'high'
     *                         (alias to acf_after_title), 'normal'
     *                         or 'side'. Defaults to normal.
     */
    public function position(string $position): self
    {
        $supported = ['acf_after_title', 'high', 'normal', 'side'];
        if (! in_array($position, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided position is unsupported. Supported positions: %s',
                implode(', ', $supported)
            ));
        }

        $this->position = $position === 'high' ? 'acf_after_title' : $position;

        return $this;
    }

    /**
     * Determines the metabox style.
     *
     * @param string $style Choices of 'default', or 'seamless'. Defaults to 'default'.
     */
    public function style(string $style): self
    {
        $supported = ['seamless', 'default'];
        if (! in_array($style, $supported)) {
            throw new InvalidArgumentException(sprintf(
                'Provided style is unsupported. Supported styles: %s',
                implode(', ', $supported)
            ));
        }

        $this->style = $style;

        return $this;
    }

    /**
     * Field groups are shown in order from lowest to highest.
     *
     * @param int $menuOrder Menu order. Defaults to 0.
     */
    public function menuOrder(int $menuOrder): FieldGroup
    {
        $this->menuOrder = $menuOrder;

        return $this;
    }

    public function register(): void
    {
        $this->registerFieldGroup();
    }

    public function registerFieldGroup(): void
    {
        if ($this->isRegistered) {
            return;
        }
        
        if (! function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group($this->populate());
    }

    /** @return array<string, mixed> */
    public function populate(): array
    {
        return array_replace_recursive($this->options, [
            'key'                   => $this->key,
            'title'                 => $this->title,
            'fields'                => $this->populateFields(),
            'location'              => $this->populateLocations(),
            'style'                 => $this->style ?? 'default',
            'menu_order'            => $this->menuOrder ?? 0,
            'hide_on_screen'        => $this->hideOnScreen ?? '',
            'active'                => $this->active ?? true,
            'description'           => $this->description ?? '',
            'show_in_rest'          => $this->showInRest ?? 0,
            'label_placement'       => $this->labelPlacement ?? 'top',
            'instruction_placement' => $this->instructionPlacement ?? 'label',
            'position'              => $this->position ?? 'normal',
        ]);
    }

    /** @return array<array<string, mixed>> */
    protected function populateFields(): array
    {
        $fields = [];

        if (isset($this->fields)) {
            foreach ($this->fields as $field) {
                $fields[] = $field->populate();
            }
        }

        if (isset($this->importedFields)) {
            foreach ($this->importedFields as $field) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    /** @return array<array{param: string, operator: string, value: mixed}> */
    protected function populateLocations(): array
    {
        if (! isset($this->location)) {
            return [];
        }

        $locations = [];
        foreach ($this->location as $location) {
            $locations[] = $location->getLocations();
        }

        return $locations;
    }

    public function endFieldGroup(): ?object
    {
        return $this->getParentContext();
    }
}

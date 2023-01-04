<?php

declare(strict_types=1);

namespace Devly\ACF;

use RuntimeException;

use function acf_add_options_page;
use function acf_add_options_sub_page;
use function array_replace_recursive;
use function class_exists;
use function function_exists;
use function str_replace;
use function ucwords;

class OptionsPage
{
    protected string $key;
    /** @var array<string, mixed> */
    protected array $config;

    /** @var FieldGroup[] */
    protected array $fieldGroups;

    /** @param array<string, mixed> $config */
    public function __construct(string $key, array $config = [])
    {
        if (! class_exists('ACF')) {
            throw new RuntimeException('The Advanced Custom Fields plugin is not installed.');
        }

        $this->key         = $key;
        $humanFriendlyName = $this->getHumanFriendlyName($this->key);
        $this->config      = array_replace_recursive([
            'menu_slug'   => $this->key,
            'page_title'  => $humanFriendlyName,
            'menu_title'  => $humanFriendlyName,
            'capability'  => 'edit_posts',
            'redirect'    => false,
        ], $config);
    }

    protected function getHumanFriendlyName(string $key): string
    {
        $key = str_replace('-', ' ', $key);

        return ucwords(str_replace('_', ' ', $key));
    }

    /**
     * The icon class for this menu. Defaults to default WordPress gear.
     */
    public function iconUrl(string $url): OptionsPage
    {
        $this->config['icon_url'] = $url;

        return $this;
    }

    /**
     * The slug of another WP admin page. If set, this will become a child page of that parent.
     */
    public function parentSlug(string $slug): OptionsPage
    {
        $this->config['parent_slug'] = $slug;

        return $this;
    }

    /**
     * Set the capability required for this menu to be displayed to the user.
     */
    public function capability(string $capability): OptionsPage
    {
        $this->config['capability'] = $capability;

        return $this;
    }

    /**
     * Set page as redirect
     *
     * If set to true, this options page will redirect to the first child page (if a child page exists).
     * If set to false, this parent page will appear alongside any child pages as its own page.
     */
    public function redirect(): OptionsPage
    {
        $this->config['redirect'] = true;

        return $this;
    }

    /**
     * The position in the menu order where this menu should appear.
     *
     * WARNING: if two menu items use the same position, one of the items may be overwritten. Risk of conflict
     * can be reduced by using decimal instead of integer values, e.g. ‘63.3’ instead of 63 (must use quotes).
     *
     * @param int|string $position
     */
    public function position($position): OptionsPage
    {
        $this->config['position'] = $position;

        return $this;
    }

    /** @param array<string, mixed> $options */
    public function addFieldGroup(string $key, ?string $title = null, array $options = []): FieldGroup
    {
        $group = new FieldGroup($key, $title, $options, $this);
        $group->where('options_page', '==', $this->key);
        $this->fieldGroups[] = $group;

        return $group;
    }

    /**
     * Set the title to be displayed on the options page.
     */
    public function pageTitle(string $title): OptionsPage
    {
        $this->config['page_title'] = $title;

        return $this;
    }

    /**
     * Set the title to be displayed in the admin menu.
     */
    public function menuTitle(string $title): OptionsPage
    {
        $this->config['menu_title'] = $title;

        return $this;
    }

    /**
     * Set $post_id to save and load values from.
     *
     * Can be set to a numeric post ID (123), or a string (‘user_2’). Read more about the
     * available post_id values: https://www.advancedcustomfields.com/resources/get_field/
     *
     * @param int|string $id
     */
    public function postId($id): OptionsPage
    {
        $this->config['post_id'] = $id;

        return $this;
    }

    /**
     * Set autoload
     *
     * Data saved in the wp_options table is given an "autoload" identifier. When set to true,
     * WP will automatically load these values within a single SQL query which can improve
     * page load performance.
     */
    public function autoload(): OptionsPage
    {
        $this->config['autoload'] = true;

        return $this;
    }

    /**
     * Set the text displayed on the options' page submit button.
     */
    public function updateButton(string $text): OptionsPage
    {
        $this->config['update_button'] = $text;

        return $this;
    }

    /**
     * Set the message shown above the form after updating the options page.
     */
    public function updatedMessage(string $message): OptionsPage
    {
        $this->config['updated_message'] = $message;

        return $this;
    }

    /**
     * Register options page.
     */
    public function addOptionsPage(): void
    {
        if (! function_exists('acf_add_options_page')) {
            return;
        }

        acf_add_options_page($this->config);
    }

    /**
     * Register options subpage.
     */
    public function addOptionsSubPage(): void
    {
        if (! function_exists('acf_add_options_sub_page')) {
            return;
        }

        if (! acf_add_options_sub_page($this->config)) {
            throw new RuntimeException(
                'Options subpage could not be registered. please check its settings and try again.'
            );
        }
    }

    /**
     * Register the options page and its metaboxes.
     */
    public function register(): void
    {
        if (isset($this->config['parent_slug'])) {
            add_action('acf/init', [$this, 'addOptionsSubPage']);
        } else {
            add_action('acf/init', [$this, 'addOptionsPage']);
        }

        if (! isset($this->fieldGroups)) {
            return;
        }

        foreach ($this->fieldGroups as $group) {
            $group->register();
        }
    }

    /** @return array<string, mixed> */
    public function __debugInfo(): array
    {
        return $this->config;
    }
}

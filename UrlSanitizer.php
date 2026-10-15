<?php

namespace UrlSanitizer;

use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Module\BaseModule;

class UrlSanitizer extends BaseModule
{
    /** @var string */
    public const DOMAIN_NAME = 'urlsanitizer';

    public const REMOVE_HTML_CONFIG_KEY = 'url_sanitizer_remove_html';
    public const SPECIAL_CHARS_REGEXP_CONFIG_KEY = 'special_chars_regexp_config_key';

    /**
     * A rewritten URL is a path: the slash separates the levels a site nests its pages under
     * (TheliaCMS builds `parent/child`), so it stays out of the stripped characters, as in the
     * core's own sanitizer. Without it, `parent/child` is stored as `parentchild` and the page
     * id is prefixed on every save, since that address is already taken.
     */
    public const DEFAULT_SPECIAL_CHARS_REGEXP = '[^a-zA-Z0-9-\.\/]';

    /**
     * Defines how services are loaded in your modules.
     */
    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([__DIR__.'/I18n/*', __DIR__.'/Config/**/*.php', __DIR__.'/Tests/*', __DIR__.'/UrlSanitizer.php'])
            ->autowire(true)
            ->autoconfigure(true);
    }
}

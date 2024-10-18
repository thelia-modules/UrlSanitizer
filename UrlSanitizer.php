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
     * Defines how services are loaded in your modules.
     */
    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([THELIA_MODULE_DIR.ucfirst(self::getModuleCode()).'/I18n/*'])
            ->autowire()
            ->autoconfigure();
    }
}

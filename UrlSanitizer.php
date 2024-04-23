<?php

namespace UrlSanitizer;

use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Module\BaseModule;

class UrlSanitizer extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'urlsanitizer';

    public const REMOVE_HTML_CONFIG_KEY = 'url_sanitizer_remove_html';

    /**
     * Defines how services are loaded in your modules.
     */
    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([THELIA_MODULE_DIR.ucfirst(self::getModuleCode()).'/I18n/*'])
            ->autowire(true)
            ->autoconfigure(true);
    }
}

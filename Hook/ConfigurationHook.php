<?php

namespace UrlSanitizer\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Form\TheliaFormFactory;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Template\Parser\ParserResolver;
use UrlSanitizer\Form\ConfigurationForm;
use UrlSanitizer\UrlSanitizer;

final class ConfigurationHook extends BaseHook
{
    public function __construct(
        private readonly TheliaFormFactory $formFactory,
        ?\Symfony\Contracts\EventDispatcher\EventDispatcherInterface $dispatcher = null,
        ?ParserResolver $parserResolver = null,
    ) {
        parent::__construct($dispatcher, $parserResolver);
    }

    public static function getSubscribedHooks(): array
    {
        return [
            'module.configuration' => [
                ['type' => 'back', 'method' => 'onModuleConfiguration'],
            ],
        ];
    }

    public function onModuleConfiguration(HookRenderEvent $event): void
    {
        $form = $this->formFactory->createForm(ConfigurationForm::getName(), data: [
            'remove_html' => (bool) UrlSanitizer::getConfigValue(UrlSanitizer::REMOVE_HTML_CONFIG_KEY, true),
            'special_characters_regex' => UrlSanitizer::getConfigValue(UrlSanitizer::SPECIAL_CHARS_REGEXP_CONFIG_KEY, '[^a-zA-Z0-9-\.]'),
        ]);

        $event->add($this->render('UrlSanitizer/module-configuration.html.twig', [
            'form' => $form->createView()->getView(),
        ]));
    }
}

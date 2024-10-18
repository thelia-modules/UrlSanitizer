<?php

namespace UrlSanitizer\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use UrlSanitizer\UrlSanitizer;

class ConfigurationForm extends BaseForm
{
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add('remove_html', CheckboxType::class, [
                'required' => false,
                'label' => Translator::getInstance()?->trans('Remove ".html" extension from rewritten URLs', [], UrlSanitizer::DOMAIN_NAME),
                'data' => (bool)UrlSanitizer::getConfigValue(UrlSanitizer::REMOVE_HTML_CONFIG_KEY),
                'label_attr' => [
                    'help' => Translator::getInstance()?->trans(
                        'Check this box if you want to remove the ".html" extension from rewritten URLs.', [], UrlSanitizer::DOMAIN_NAME
                    )
                ]
            ])
            ->add('special_characters_regex', TextType::class, [
                'required' => true,
                'label' => Translator::getInstance()?->trans('Regular expression identifiying special characters', [], UrlSanitizer::DOMAIN_NAME),
                'data' => UrlSanitizer::getConfigValue(UrlSanitizer::SPECIAL_CHARS_REGEXP_CONFIG_KEY, '[^a-zA-Z0-9-\.]'),
                'label_attr' => [
                    'help' => Translator::getInstance()?->trans(
                        'The module will remove characters from URLs that match this regular expression.', [], UrlSanitizer::DOMAIN_NAME
                    )
                ]
            ]);
    }
}

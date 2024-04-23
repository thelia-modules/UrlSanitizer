<?php

namespace UrlSanitizer\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                'label' => Translator::getInstance()?->trans('Remove html extension from rewrite url ?', [], UrlSanitizer::DOMAIN_NAME),
                'data' => (bool)UrlSanitizer::getConfigValue(UrlSanitizer::REMOVE_HTML_CONFIG_KEY)
            ]);
    }
}
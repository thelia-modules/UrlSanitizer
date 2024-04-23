<?php

namespace UrlSanitizer\Controller;

use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Template\ParserContext;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Tools\URL;
use UrlSanitizer\Form\ConfigurationForm;
use UrlSanitizer\Service\UrlSanitizerService;
use UrlSanitizer\UrlSanitizer;

#[Route('/admin/module/UrlSanitizer', name: 'admin_url_sanitizer_')]
class ConfigurationController extends BaseAdminController
{
    #[Route('/sanitizeall', name: 'sanitizeall')]
    public function sanitizeAllAction(UrlSanitizerService $urlSanitizerService)
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["UrlSanitizer"], AccessManager::UPDATE)) {
            return $response;
        }

        $urlSanitizerService->sanitizeAllExistingUrls();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/UrlSanitizer', []));
    }

    #[Route('/configuration', name: 'configuration', methods: ['POST'])]
    public function SaveConfiguration(ParserContext $parserContext): RedirectResponse|Response
    {
        $form = $this->createForm(ConfigurationForm::getName());

        try {
            $data = $this->validateForm($form)->getData();

            UrlSanitizer::setConfigValue(UrlSanitizer::REMOVE_HTML_CONFIG_KEY, $data['remove_html']);

            return $this->generateSuccessRedirect($form);
        } catch (FormValidationException $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }

        $form->setErrorMessage($error_message);

        $parserContext
            ->addForm($form)
            ->setGeneralError($error_message);

        return $this->generateErrorRedirect($form);
    }
}

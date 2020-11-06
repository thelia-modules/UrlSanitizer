<?php

namespace UrlSanitizer\Controller;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Tools\URL;
use UrlSanitizer\Service\UrlSanitizerService;
use UrlSanitizer\UrlSanitizer;

class ConfigurationController extends BaseAdminController
{
    public function sanitizeAllAction()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["UrlSanitizer"], AccessManager::UPDATE)) {
            return $response;
        }

        /** @var UrlSanitizerService $urlSanitizerService */
        $urlSanitizerService = $this->getContainer()->get('urlsanitizer.service');
        $urlSanitizerService->sanitizeAllExistingUrls();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/UrlSanitizer', []));
    }
}

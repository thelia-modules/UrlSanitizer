<?php

namespace UrlSanitizer\Controller;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Tools\URL;
use UrlSanitizer\Service\UrlSanitizerService;

class ConfigurationController extends BaseAdminController
{
    public function sanitizeAllAction(UrlSanitizerService $urlSanitizerService)
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ["UrlSanitizer"], AccessManager::UPDATE)) {
            return $response;
        }

        $urlSanitizerService->sanitizeAllExistingUrls();

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/UrlSanitizer', []));
    }
}

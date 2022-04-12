<?php

namespace UrlSanitizer\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Model\Event\RewritingUrlEvent;
use Thelia\Model\RewritingUrl;
use UrlSanitizer\Service\UrlSanitizerService;

class RewriteUrlListener implements EventSubscriberInterface
{
    /** @var UrlSanitizerService */
    protected $sanitizerService;

    public function __construct(UrlSanitizerService $sanitizerService)
    {
        $this->sanitizerService = $sanitizerService;
    }

    public function sanitizeUrl(RewritingUrlEvent $event)
    {
        /** @var RewritingUrl $rewritingUrl */
        $rewritingUrl = $event->getModel();

        $sanitizedUrl = $this->sanitizerService->unifyUrl(
            $this->sanitizerService->sanitizeUrl($rewritingUrl->getUrl()),
            $rewritingUrl
        );

        $rewritingUrl->setUrl($sanitizedUrl);
    }

    public static function getSubscribedEvents()
    {
        return [
            RewritingUrlEvent::PRE_INSERT => ['sanitizeUrl', 64]
        ];
    }
}

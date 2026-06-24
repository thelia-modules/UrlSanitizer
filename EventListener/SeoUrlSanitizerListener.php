<?php

namespace UrlSanitizer\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\UpdateSeoEvent;
use UrlSanitizer\Service\UrlSanitizerService;

/**
 * Sanitizes the rewritten URL submitted from the SEO tab *before* the core SEO
 * listeners run.
 *
 * The core UrlRewritingTrait::setRewrittenUrl() compares the submitted URL with
 * the current one to decide whether anything changed. It works on the raw value,
 * so a variant of the current URL (e.g. adding ".html" while the module strips
 * it, or a different case) looks like a change: core inserts a brand new
 * RewritingUrl row, the PRE_INSERT unifier then finds the sanitized value already
 * taken by the object itself and prefixes it with the object id. Repeated saves
 * stack that prefix (23-23-23-…-slug) and eventually break the object URLs.
 *
 * Sanitizing here makes the comparison see the final value: an unchanged URL is a
 * no-op, and a genuinely new one is created already clean.
 */
class SeoUrlSanitizerListener implements EventSubscriberInterface
{
    /** @var UrlSanitizerService */
    protected $sanitizerService;

    public function __construct(UrlSanitizerService $sanitizerService)
    {
        $this->sanitizerService = $sanitizerService;
    }

    public function sanitizeSeoUrl(UpdateSeoEvent $event): void
    {
        $url = $event->getUrl();

        if ($url === null || $url === '') {
            return;
        }

        $cleanUrl = $this->sanitizerService->sanitizeUrl($url);

        if ($cleanUrl !== '' && $cleanUrl !== $url) {
            $event->setUrl($cleanUrl);
        }
    }

    public static function getSubscribedEvents()
    {
        // Priority 256 > the core SEO listeners (128) so the value is already clean
        // when UrlRewritingTrait::setRewrittenUrl() compares and persists it.
        $listener = ['sanitizeSeoUrl', 256];

        return [
            TheliaEvents::CATEGORY_UPDATE_SEO => $listener,
            TheliaEvents::PRODUCT_UPDATE_SEO => $listener,
            TheliaEvents::CONTENT_UPDATE_SEO => $listener,
            TheliaEvents::FOLDER_UPDATE_SEO => $listener,
            TheliaEvents::BRAND_UPDATE_SEO => $listener,
        ];
    }
}

<?php

namespace UrlSanitizer;

use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Model\RewritingUrl;
use Thelia\Model\RewritingUrlQuery;
use Thelia\Module\BaseModule;

class UrlSanitizer extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'urlsanitizer';
}

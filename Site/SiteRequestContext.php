<?php
/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\PageBundle\Site;

use Symfony\Component\Routing\RequestContext;

/**
 * SiteRequestContext
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class SiteRequestContext extends RequestContext
{
    protected $selector;

    /**
     * @param SiteSelectorInterface $site
     * @param string                $baseUrl
     * @param string                $method
     * @param string                $host
     * @param string                $scheme
     * @param int                   $httpPort
     * @param int                   $httpsPort
     */
    public function __construct(SiteSelectorInterface $selector, $baseUrl = '', $method = 'GET', $host = 'localhost', $scheme = 'http', $httpPort = 80, $httpsPort = 443)
    {
        $this->selector = $selector;

        parent::__construct($baseUrl, $method, $host, $scheme, $httpPort, $httpsPort);
    }

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        $site = $this->selector->retrieve();

        if ($site) {
            return $site->getDomain();
        }

        return parent::getHost();
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseUrl()
    {
        $site = $this->selector->retrieve();

        if ($site) {
            return parent::getBaseUrl() . $site->getRelativePath();
        }

        return parent::getBaseUrl();
    }
}

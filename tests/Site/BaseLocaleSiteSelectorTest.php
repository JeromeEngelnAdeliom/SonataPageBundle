<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\PageBundle\Tests\Site;

use PHPUnit\Framework\TestCase;
use Sonata\PageBundle\Entity\BaseSite;
use Sonata\PageBundle\Site\SiteSelectorInterface;

/**
 * @author Rémi Marseille <marseille@ekino.com>
 */
abstract class BaseLocaleSiteSelectorTest extends TestCase
{
    /**
     * @var SiteSelectorInterface
     */
    protected $siteSelector;

    /**
     * Cleanups the site selector.
     */
    protected function tearDown(): void
    {
        unset($this->siteSelector);
    }

    /**
     * Gets fixtures of sites.
     *
     * @return Site[]
     */
    protected function getSites(): array
    {
        $sites = [];

        $sites[0] = new Site();
        $sites[0]->setEnabled(true);
        $sites[0]->setRelativePath('/fr');
        $sites[0]->setHost('localhost');
        $sites[0]->setIsDefault(true);
        $sites[0]->setLocale('fr');

        $sites[1] = new Site();
        $sites[1]->setEnabled(true);
        $sites[1]->setRelativePath('/en');
        $sites[1]->setHost('localhost');
        $sites[1]->setIsDefault(false);
        $sites[1]->setLocale('en');

        return $sites;
    }

    /**
     * Gets the site from site selector.
     */
    protected function getSite(): ?Site
    {
        return $this->siteSelector->retrieve();
    }
}

final class Site extends BaseSite
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}

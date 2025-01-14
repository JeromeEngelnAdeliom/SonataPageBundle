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

namespace Sonata\PageBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Cache\CacheManagerInterface;
use Sonata\Form\Type\DateTimePickerType;

/**
 * Admin definition for the Snapshot class.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * @final since sonata-project/page-bundle 3.26
 */
class SnapshotAdmin extends AbstractAdmin
{
    protected $classnameLabel = 'Snapshot';

    /**
     * @var CacheManagerInterface|null
     */
    protected $cacheManager;

    protected $accessMapping = [
        'batchToggleEnabled' => 'EDIT',
    ];

    public function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('url')
            ->add('enabled')
            ->add('publicationDateStart')
            ->add('publicationDateEnd');
    }

    public function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('routeName');
    }

    public function configureFormFields(FormMapper $form)
    {
        $form
            ->add('enabled', null, ['required' => false])
            ->add('publicationDateStart', DateTimePickerType::class, ['dp_side_by_side' => true])
            ->add('publicationDateEnd', DateTimePickerType::class, ['required' => false, 'dp_side_by_side' => true]);
    }

    public function postUpdate($object)
    {
        if (null !== $this->cacheManager) {
            $this->cacheManager->invalidate([
                'page_id' => $object->getPage()->getId(),
            ]);
        }
    }

    public function postPersist($object)
    {
        if (null !== $this->cacheManager) {
            $this->cacheManager->invalidate([
                'page_id' => $object->getPage()->getId(),
            ]);
        }
    }

    public function setCacheManager(CacheManagerInterface $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    protected function configureBatchActions($actions): array
    {
        $actions = parent::configureBatchActions($actions);

        $actions['toggle_enabled'] = [
            'label' => 'toggle_enabled',
            'ask_confirmation' => true,
        ];

        return $actions;
    }
}

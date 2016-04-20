<?php

namespace Velygotsky\BaseBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * BaseService.
 *
 * @author Yaroslav Velygotsky <yaroslav@velygotsky.com>
 */
abstract class BaseService
{
    protected $em;
    protected $container;

    /**
     * Constructor.
     *
     * @param EntityManager      $em        The EntityManager instance.
     * @param ContainerInterface $container The ContainerInterface instance.
     */
    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }
}

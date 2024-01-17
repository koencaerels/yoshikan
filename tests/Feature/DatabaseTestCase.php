<?php

/*
 * This file is part of the Yoshi Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Feature;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Security;

class DatabaseTestCase extends KernelTestCase
{
    protected EntityManagerInterface $entityManager;
    protected Security $security;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        if ('test' !== $kernel->getEnvironment()) {
            throw new \LogicException('Execution only in Test environment possible!');
        }
        $this->initDatabase($kernel);
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->security = new Security($kernel->getContainer());
    }

    private function initDatabase(KernelInterface $kernel): void
    {
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metaData);
    }
}

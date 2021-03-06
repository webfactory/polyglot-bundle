<?php

namespace Webfactory\Bundle\PolyglotBundle\Tests\Doctrine;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Persistence\Mapping\RuntimeReflectionService;
use PHPUnit_Framework_TestCase;
use Psr\Log\LoggerInterface;
use Webfactory\Bundle\PolyglotBundle\Doctrine\TranslatableClassMetadata;
use Webfactory\Bundle\PolyglotBundle\Tests\TestEntity;
use Webfactory\Bundle\PolyglotBundle\Tests\TestEntityTranslation;
use Webfactory\Doctrine\ORMTestInfrastructure\ORMInfrastructure;

class TranslatableClassMetadataTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_be_serialized_and_retrieved()
    {
        $metadata = $this->createMetadata();

        $unserialized = unserialize(serialize($metadata->prepareSleepInstance()));
        $unserialized->wakeupReflection(new RuntimeReflectionService());

        $this->assertEquals($metadata, $unserialized);
    }

    private function createMetadata(LoggerInterface $logger = null): TranslatableClassMetadata
    {
        $reader = new AnnotationReader();
        $infrastructure = new ORMInfrastructure(
            [
                TestEntity::class,
                TestEntityTranslation::class,
            ]
        );
        $metadata = $infrastructure->getEntityManager()->getClassMetadata(TestEntity::class);
        $metadata = TranslatableClassMetadata::parseFromClassMetadata($metadata, $reader);
        if (null !== $logger) {
            $metadata->setLogger($logger);
        }

        return $metadata;
    }
}

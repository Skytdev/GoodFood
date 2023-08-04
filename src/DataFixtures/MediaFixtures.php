<?php

namespace App\DataFixtures;

use App\Entity\MediaObject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture
{
    private ManagerRegistry $doctrine;
    private String $mediaDirectory;

    public function __construct(ManagerRegistry $doctrine, String $mediaDirectory)
    {
        $this->doctrine = $doctrine;
        $this->mediaDirectory = $mediaDirectory;
    }

    public function load(ObjectManager $manager): void
    {
        $files1 = glob($this->mediaDirectory.'*.jpg');
        $files2 = glob($this->mediaDirectory.'*.png');
        foreach ($files1 as $key => $file) {
            $image = new MediaObject();
            $image->filePath = basename($file);

            $manager->persist($image);
        }

        foreach ($files2 as $key => $file) {
            $image = new MediaObject();
            $image->filePath = basename($file);

            $manager->persist($image);
        }

        $manager->flush();
    }
}

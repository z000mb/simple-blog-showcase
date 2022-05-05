<?php

namespace App\DataFixtures\Post;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

/**
 * @author Maciej Sobolak <maciek@koverlo.com>
 */
class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 30; $i++) {
            $post = (new Post())
                ->setTitle($faker->sentence(3))
                ->setContent($faker->paragraph(2))
                ->setImageName($faker->imageUrl(200, 100, 'animals', true, 'cats'));
            $manager->persist($post);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 5; $i++) {

            $cat = new Category;

            $cat->setName($faker->word);
            $cat->setDescription($faker->text);

            $manager->persist($cat);
        }

        $manager->flush();
    }
}

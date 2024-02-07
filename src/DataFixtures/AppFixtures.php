<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

        for ($c = 0; $c < 3; $c++) {
            $category = new Category;
            $category->setName($faker->department);

            $manager->persist($category);

            for ($p = 0; $p < mt_rand(15, 20); $p++) {
                $product = new Product;
                $product->setName($faker->productName)
                    ->setPrice($faker->price(4000, 20000))
                    ->setShortDescription($faker->paragraph())
                    ->setCategory($category);

                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}

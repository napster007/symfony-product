<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName('Sample Product');
        $product->setDescription('This is a sample product.');
        $product->setSize(10);
        $manager->persist($product);

        $product = new Product();
        $product->setName('Another Product');
        $product->setDescription('This is another product.');
        $product->setSize(20);
        $manager->persist($product);

        $product = new Product();
        $product->setName('Third Product');
        $product->setDescription('This is the third product.');
        $product->setSize(50);
        $manager->persist($product);

        $manager->flush();
    }
}

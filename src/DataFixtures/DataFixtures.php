<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use DateTime;

class DataFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger=$slugger;
    }

   # cette function load sera exceute en ligne de commande;, avec  php bin/console doctrine:fixtures:load
    public function load(ObjectManager $manager): void
    {
       $categories = [
           'Politique',
           'Société',
           'People',
           'Economie',
           'Santé',
           'Espace',
           'Sport',
           'Informatique',
           'Mode',
           'Ecologie',
           'Cinema',
           'Hi Tech'
       ];
  
    foreach ($categories as $cat){
          
         $categorie = new Categorie();

         $categorie -> setName($cat);
         $categorie -> setAlias($this->slugger->slug($cat));
         $categorie -> setCreatedAt(new DateTime());
         $categorie -> setUpdatedAt(new DateTime());

         $manager->persist($categorie);

    }
         

        $manager->flush();
    }
}

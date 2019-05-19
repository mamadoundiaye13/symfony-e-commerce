<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Categorie;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;
use Faker;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $faker = Faker\Factory::create('fr_FR');

        // Créer 3 fakees


        $arrayCategorie = array("homme", "femme", "enfant", "maison");

        for ($i= 0; $i < sizeof($arrayCategorie); $i++){
            $categorie = new Categorie();

            $categorie  ->setTitle($arrayCategorie[$i])
                        ->setDescription($faker->paragraph());

            $manager->persist($categorie);


            // créer 4 ou 6 articles

            for ($j = 1 ; $j  <= mt_rand(4, 10); $j++){
                $article = new Articles();

                $article -> setTitle($faker->realText(rand(10,20)))
                    -> setDescription($faker->paragraph(4, false))
                    -> setNombreDeStockRestant(rand(10, 100))
                    -> setPrice(rand(25, 500))
                    -> setPhoto($faker->imageUrl())
                    -> setCreatedAt( $faker->dateTimeBetween('-01 years'))
                    -> setUpdatedAt($faker->dateTimeBetween('-01 years'))
                    -> setCategorie($categorie);


                $manager->persist($article);

                //Les commentaires

                for ($k=1; $k<= mt_rand(4, 10); $k++){
                    $comment = new Comment();

                    $content = '<p>'.join($faker->paragraphs()).'</p>';


                    $days = (new \DateTime()) -> diff($article->getCreatedAt())->days;

                    $minimum = '-'.$days.' days';

                    $comment -> setAuthor($faker->name)
                             -> setContent($content)
                             -> setCreatedAt($faker->dateTimeBetween($minimum))
                             ->setArticle($article);

                    $manager->persist($comment);


                }
            }

        }

        $manager->flush();
    }
}

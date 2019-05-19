<?php

namespace App\Controller;



use App\Entity\Articles;
use App\Form\ArticleType;
use App\Repository\ArticlesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class ECommerceController extends AbstractController
{

    /**
     * @Route("/", name = "home");
     */
    public function home(ArticlesRepository $repo){

        $articles = $repo->findAll();
        return $this->render('e_commerce/accueil.html.twig', [
            'controller_name' =>  'ECommerceController',
            'articles' => $articles
        ]);

    }


    /**
     * @Route("/homme", name = "homme")
    */

    public function homme(ArticlesRepository $repo){

        $articles = $repo->findAll();

        return $this->render('e_commerce/homme.html.twig', [
            'controller_name' =>  'ECommerceController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/feminin", name = "feminin")
     */

    public function feminin(ArticlesRepository $repo){

        $articles = $repo->findAll();
        return $this->render('e_commerce/femme.html.twig', [
            'controller_name' =>  'ECommerceController',
            'articles' => $articles
        ]);    }


    /**
     * @Route("/enfant", name = "enfant")
     */

    public function enfant(ArticlesRepository $repo){

        $articles = $repo->findAll();
        return $this->render('e_commerce/enfant.html.twig', [
            'controller_name' =>  'ECommerceController',
            'articles' => $articles
        ]);    }


    /**
     * @Route("/maison", name = "maison")
     */

    public function maison(ArticlesRepository $repo){

        $articles = $repo->findAll();

        return $this->render('e_commerce/maison.html.twig', [
            'controller_name' =>  'ECommerceController',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/favoris", name = "favoris")
     */

    public function favoris(ArticlesRepository $repo){

        $articles = $repo->findAll();

        $nbrArticle = 0;
        return $this->render('e_commerce/favoris.html.twig', [
            'controller_name' =>  'ECommerceController',
            'articles' => $articles,
            'nbrArticle' => $nbrArticle,
        ]);
    }

    /**
     * @Route("/panier", name = "panier")
     */

    public function panier(ArticlesRepository $repo){

        $articles = $repo->findAll();

        $nbrArticle = 0;
        return $this->render('e_commerce/panier.html.twig', [
            'controller_name' =>  'ECommerceController',
            'articles' => $articles,
            'nbrArticle' => $nbrArticle,
        ]);
    }


    /**
     * @Route("/article/{id}", name = "show")
     */

    public function show(Articles $article){

        return $this->render('e_commerce/show.html.twig', [
            'controller_name' =>  'ECommerceController',
            'article' => $article
        ]);
    }


    /**
     * @Route("/admin/new", name="admin_create")
     * @Route("/article/{id}/edit", name="admin_edit")
     */
    public function form(Articles $article = null, Request $request, ObjectManager $manager){

        if (!$article){
            $article = new Articles();
        }

       /* $form = $this->createFormBuilder($article)
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('nombre_de_stock_restant')
            ->add('photo')
            ->getForm();
        */

       $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            if (!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }
            $article->setCreatedAt(new \DateTime());
            $article->setUpdatedAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('show', ['id' => $article->getId()]);

        }


        return $this->render('e_commerce/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMod' => $article->getId() !== null,
        ]);

    }
}

<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/tableau-de-bord", name="show_dashboard", methods={"GET"})
     */
    public function showDashboard(EntityManagerInterface $entityManager) : Response
    {
      $articles = $entityManager->getRepository(Article::class)->findAll();

      return $this->render('admin/show_dashboard.html.twig', [
        'articles'=>$articles,
      ]);

     
    }

    /**
     * @Route("/admin/creer-un-article", name="create_article",methods={"GET|POST"})
     */
    public function createArticle(Request $request,EntityManagerInterface $entityManager, SluggerInterface $slugger):Response
    {
       $article = new Article();
       $form = $this->createForm(ArticleFormType::class,$article)->handleRequest($request);

      

      if($form->isSubmitted() && $form->isValid()){

        // dump($article);
        // dd($form);

          $article->setAlias($slugger->slug($article->getTitle()));
          $article->setCreatedAt(new DateTime());
          $article->setUpdatedAt(new DateTime());

          $file = $form->get('photo')->getData();

        if($file){
            $extension = '.' . $file->guessExtension();

            $originalFilename =pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        //    $safeFilename = $slugger->slug($originalFilename);

          $safeFilename = $article->getAlias();

           $newFilename = $safeFilename . '_'. uniqid() . $extension;

           

        try{
              $file->move($this->getParameter('uploads_dir'), $newFilename);
              $article->setPhoto($newFilename);
             
        }catch(FileException $exception) {
         


        }//END CATCH
        }//END IF (file)
        $entityManager->persist($article);
        $entityManager->flush();

        $this->addFlash('success','Bravo, Votre article est bien en ligne!');

        return $this->redirectToRoute('show_dashboard');
      }//END IF (form)

       return $this -> render('admin/form/create_article.html.twig',[
        'form'=>$form->createView()
]);
       
}

}
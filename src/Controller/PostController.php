<?php

namespace App\Controller;


use App\Entity\Post;
use App\Form\CreateType;
use App\Services\FileUploader;
use App\Repository\PostRepository;


use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PostController extends AbstractController
{
/**
 * @Route("/post", name="app_post")
 * @param PostRepository $postRepository
 * @return Response
 */
    public function index(PostRepository $postRepository): Response
    {
            $posts = $postRepository->findAll();
            return $this->render('post/index.html.twig', [
                'posts' => $posts,
            ]);
    }

/**
 * @Route("/post/create", name="post_create")
 * @param Request $request
 * @return Response
 * @param FileUploader $uploader
 */

     public function create(Request $request, FileUploader $fileUPloader)
     {
            //Create a new post with title
            $post = new Post();

            // $post->setTitle('This is My title');
        //CREATE FORM 
            $form = $this->createForm(CreateType::class, $post);
            $form->handleRequest($request);
         //entity manager
                    if($form->isSubmitted() && $form->isValid()) {
                    $em =  $this->getDoctrine()->getManager();

//to add more function to my code
/**
 * @var UploadedFile $file 
 * 
 */
                    $file = $form->get('attachement')->getData();
         if($file){
                        
                    $filename = $fileUPloader->uploadFile($file);
                    
                    $post->setImage($filename);
                    $em->persist($post);
                    $em->flush();
                    // $this->addFlash('success', 'Post Created Successfully');
                    //Return a Response 
               }    
                    return $this->redirect($this->generateUrl('app_post'));
}


        return $this->render('post/create.html.twig', [
            'form' => $form->createView(),
        ]);
     }

/**
 * @Route("/post/show/{id}", name="post_show")
* @return Response 
* @param Post $post
*/

     public function show(Post $post)
     {
        return $this->render('post/show.html.twig', [
                'post' => $post,
        ]);
     }


/**
 * @Route("/post/delete/{id}", name="post_delete")
 * @param Post $post
 * @return Response 
 */
     
     public function remove(Post $post) {
     
            $em = $this->getDoctrine()->getManager();

            $em->remove($post);
            $em->flush();
            $this->addFlash('success', 'Post deleted successfully');
            return $this->redirect($this->generateUrl('app_post'));
    }
}

<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(Request $req, PostRepository $postRepository): Response
    {
        $post = new Post();
        $post->setAutor($this->getUser());
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $image = $form->get('image')->getData();
            $name = $image->getClientOriginalName();
            $image->move('images', $name);
            $post->setImage('/images/' . $name);
            $post->setPostAt(new \DateTime());
            //dd($post);
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'post' => $postRepository->findAll()
        ]);
    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Post $post, Request $req)
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($req);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setPost($post);
            $comment->setMakeAt(new \DateTime());
            $comment->setUser($this->getUser());
            $post->addComment($comment);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('read', ['id' => $post->getId()]);
        }
        //dd($post);
        return $this->render(
            'index/read.html.twig',
            [
                'post' => $post,
                'form' => $commentForm->createView()
            ]
        );
    }

    /**
     * @Route("/like/{id}", name="like")
     */
    public function like(Post $post)
    {
        if ($this->getUser()) {
            # code...
            $post->addLike($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        }
        return $this->redirectToRoute('read', ['id' => $post->getId()]);
       
    }
}

<?php

namespace Controller;

use Framework\Controller;
use Form\CommentEditType;
use Entity\Signal;
use Entity\Comment;
use Form\SignalType;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller {
    
    public function signalAction($id) {
        $em = $this->getDoctrine();
        $comment = $em->getRepository("Entity\Comment")->find($id);
        $signal = new Signal();
        $signal->setComment($comment);
        $form = $this->getFormFactory()->create(SignalType::class, $signal);
        $request = $this->getRequest();
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine();
            $em->persist($signal);
            $comment->setSignale('1');
            $em->flush();
            
            return $this->redirect('signal', array('id'=>$id));
        }
        
        
        return $this->render('signal.html.twig', ['comment' => $comment, 'signal' => $signal, 'form' => $form->createView()]);
    }
    
    public function editComAction($id) {
        $em = $this->getDoctrine();
        $comment = $em->getRepository("Entity\Comment")->find($id);
        $messages = $em->getRepository("Entity\Signal")->findBy(array('comment' => $comment));
        $form = $this->getFormFactory()->create(CommentEditType::class, $comment);
        $request = $this->getRequest();
        
        
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine();
            $em->flush();
            return $this->redirect('admin');
         }
         
         return $this->render('editcom.html.twig', array(
             'comment' => $comment,
             'messages' => $messages,
             'form' => $form->createView()
         ));
         
    }
    
    public function deleteComAction($id) {
        $em = $this->getDoctrine();
        $comment = $em->getRepository("Entity\comment")->find($id);
        $form = $this->getFormFactory()->create();
        $request = $this->getRequest();
        
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()){
            $comment->setDelete('1');
            $em->flush();
            return $this->redirect('admin');
          }  
            
          return $this->render('deletecom.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        )); 
    }
    
    public function restoreComAction($id) {
        $em = $this->getDoctrine();
        $comment = $em->getRepository("Entity\comment")->find($id);
        $form = $this->getFormFactory()->create();
        $request = $this->getRequest();
        
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()){
            $comment->setDelete('0');
            $em->flush();
            return $this->redirect('admin');
          }  
            
          return $this->render('restorecom.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        )); 
    }
            
}
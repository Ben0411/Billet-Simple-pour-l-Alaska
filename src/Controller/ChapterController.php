<?php

namespace Controller;

use Framework\Controller;
use Entity\Chapter;
use Entity\Contact;
use Form\ContactType;
use Form\ChapterType;
use Entity\Comment;
use Form\CommentType;
use Entity\Signal; 
use Symfony\Component\HttpFoundation\Request;


class ChapterController extends Controller {
    
    public function indexAction()
    {
       $em = $this->getDoctrine();
       $chapters = $em->getRepository("Entity\Chapter")->findby(array('published' => '1'));
       $contact = new Contact();
       $contact->setDate($date = new \DateTime);
       $contact->setArchive('0');
       $form = $this->getFormFactory()->create(ContactType::class, $contact);
       $request = $this->getRequest();
       
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $em = $this->getDoctrine();
            $em->persist($contact);
            $em->flush();
            
             return $this->redirect('home');
        }
        
       return $this->render('accueil.html.twig', ['chapters' => $chapters,'form' => $form->createView()]);
    }
    
    public function chapterAction($id){
        $em = $this->getDoctrine();
        $chapter = $em->getRepository("Entity\Chapter")->find($id);
        $comment = $em->getRepository("Entity\Comment")->findby(array('chapter' => $chapter));
        $commentAdd = new Comment();
        $commentAdd->setChapter($chapter);
        $form = $this->getFormFactory()->create(CommentType::class, $commentAdd);
        $request = $this->getRequest();
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $em = $this->getDoctrine();
            $em->persist($commentAdd);
            $em->flush();
            
            return $this->redirect('chapitre', array( 'id' => $id ));
        }
       
        return $this->render('chapter.html.twig', ['chapter' => $chapter, 'comment' => $comment,'form' => $form->createView()]);
    }
    
    public function adminAction() {
        $em = $this->getDoctrine();
        $chapters = $em->getRepository("Entity\Chapter")->findAll();
        $comments = $em->getRepository("Entity\Comment")->findAll();
        $contacts = $em->getRepository("Entity\Contact")->findBy(array('archive' => false), array('date' => 'DESC'));
        $contactLus = $em->getRepository("Entity\Contact")->findBy(array('archive' => true), array('date' => 'DESC'));
        
        
        
        return $this->render('admin.html.twig', ['chapters' => $chapters, 'comments' => $comments, 'contacts' => $contacts, 'contactLus'=>$contactLus ]);
    }
    
    public function addAction(){
        $chapter = new Chapter();
        $chapter->setDate($date = new \DateTime);
        $form = $this->getFormFactory()->create(ChapterType::class, $chapter);
        $request = $this->getRequest();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
          
            $em = $this->getDoctrine();
            $em->persist($chapter);
            $em->flush();
            
            
            
            return $this->redirect('admin');
        }
        
        return $this->render('add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function deleteAction($id){
        $em = $this->getDoctrine();
        $chapter = $em->getRepository("Entity\chapter")->find($id);
        $form = $this->getFormFactory()->create();
        $request = $this->getRequest();
        
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid() ){
            $chapter->setDelete('1');
            $em->flush();
            return $this->redirect('admin');
          }  
            
          return $this->render('delete.html.twig', array(
            'chapter' => $chapter,
            'form' => $form->createView(),
        )); 
    }
    
     public function restoreAction($id){
        $em = $this->getDoctrine();
        $chapter = $em->getRepository("Entity\chapter")->find($id);
        $form = $this->getFormFactory()->create();
        $request = $this->getRequest();
        
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid() ){
            $chapter->setDelete('0');
            $em->flush();
            return $this->redirect('admin');
          }  
            
          return $this->render('restore.html.twig', array(
            'chapter' => $chapter,
            'form' => $form->createView(),
        )); 
    }
    
    public function editAction($id){
        $em = $this->getDoctrine();
        $chapter = $em->getRepository("Entity\Chapter")->find($id);
        $form = $this->getFormFactory()->create(ChapterType::class, $chapter);
        $request = $this->getRequest();
                
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid() ){
            $em = $this->getDoctrine();
            $em->flush();
            return $this->redirect('admin');
         }
        
         return $this->render('edit.html.twig', array(
            'chapter' => $chapter,
            'form' => $form->createView(),
        ));
    } 
}
<?php

namespace Controller;
use Entity\Contact;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller {
    
    public function contactAction($id) {
        $em = $this->getDoctrine();
        $contact = $em->getRepository("Entity\Contact")->find($id);
        $contact->setArchive('1');
        $em->flush();
        $form = $this->getFormFactory()->create();
        $request = $this->getRequest();
        
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()){
            $contact->setArchive('0');
            $em->flush();
            return $this->redirect('admin');
          }  
        
         return $this->render('contact.html.twig', array('contact' => $contact, 'form' => $form->createView(),));
    }
    
    public function unreadAction($id) {
        $em = $this->getDoctrine();
        $contact = $em->getRepository("Entity\Contact")->find($id);
        $contact->setArchive('0');
        $em->flush();
        return $this->redirect('admin');
    }
}
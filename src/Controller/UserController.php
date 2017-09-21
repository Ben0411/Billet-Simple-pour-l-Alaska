<?php

namespace Controller;

use Framework\Controller;
use Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Form\LoginType;

class UserController extends Controller {
    
    /**
     * login
     */
    public function loginAction() {
      
        $form = $this->getFormFactory()->create(LoginType::class);
        $request = $this->getRequest();
       
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
           $formData = $form->getData();
           $em = $this->getDoctrine();
           $user = $em->getRepository('Entity\User')->findOneBy(array("username"=>$formData['username'], "password"=>sha1($formData['password']) ));
           if($user){
               $this->getRequest()->getSession()->set('AUTH',$user->getId());
               return $this->redirect('admin');
               
           }else{
               echo '<h2 class="log_error"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Login ou mot de passe incorrect</h2>';
           }
        }
       return $this->render('login.html.twig', [ 'form' => $form->createView()]);        
    }
    
    /**
     * logout
     */
    public function logoutAction() {
        session_unset('AUTH');
        return $this->redirect('login');
    }
}
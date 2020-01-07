<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\SecurityForgottenPasswordType;
use App\Form\SecurityRegistrationType;
use App\Form\SecurityResetPasswordType;
use App\Repository\UsersRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("", name="security:app")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route({
     *  "en": "/register",
     *  "fr": "/inscription"
     * }, name=":register", methods={"HEAD","GET","POST"})
     */
    public function register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request, /*SwiftMailer $mailer,*/ UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // 1. Check if user is already loged in
        // --

        if ($this->getUser()) 
        {
            return $this->redirectToRoute('homepage');
        }


        // 2. Init Entities
        // --

        $user = new Users();
        // $message = new \Swift_Message();

        // 3. Form management
        // --

        // Create new form based on the User Entity
        $form = $this->createForm(SecurityRegistrationType::class, $user);
        
        // Handle the Request (request method === post)
        $form->handleRequest($request);
        
        // On form submit
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // 1. Retrieve form data
            // --

            // PlainText Password
            $plainPassword = $form->get('plainPassword')->getData();


            // 2. Data Manipulation / Generation
            // --

            // Encode the plain password
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $plainPassword
            );

            // Generate the Activation Token
            // $activationTokenPart1 = md5(
            //     $user->getEmail().
            //     $user->getDatetimeRegistration()->format('Y-m-d H:i:s')
            // );
            // $activationTokenPart2 = md5($activationTokenPart1);
            // $activationToken = $activationTokenPart1.$activationTokenPart2;

            // Activation URL
            // $activationUrl = $this->generateUrl(
            //     'account:app:activate',
            //     [
            //         'address' => $user->getEmail(),
            //         'token' => $activationToken
            //     ],
            //     UrlGenerator::ABSOLUTE_URL
            // );


            // 3. Set and Persist data
            // --

            $user->setPassword($encodedPassword);
            // $user->setTokenActivation($activationToken);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            // 4. Send the activation email
            // --

            // // Email data definition
            // $data = [
            //     'firstname' => $user->getFirstname(),
            //     'url' => $activationUrl
            // ];

            // // SwiftMail Message Builder
            // $message
            //     ->setSubject( "Account verification" )
            //     ->setFrom( $this->getParameter('emailSender') )
            //     ->setTo( $user->getEmail() )
            //     ->setBody( $this->renderView("security/emails/verification/verification.html.twig", $data), 'text/html' )
            //     ->addPart( $this->renderView("security/emails/verification/verification.txt.twig", $data), 'text/plain' )
            // ;

            // // Send the email
            // $sent = $mailer->send($message);


            // 5.a. Redirect user to the login page
            // --

            $this->addFlash('success', 'Your account is now created, check your mailbox to active.');
            return $this->redirectToRoute('security:app:login');


            // 5.b. Proceed to login and redirect the user
            // --

            // return $guardHandler->authenticateUserAndHandleSuccess(
            //     $user,
            //     $request,
            //     $authenticator,
            //     'main'
            // );
        }

        // Create the form view
        $form = $form->createView();

        return $this->render('security/partials/register.html.twig', [
            'form' => $form,
        ]);
    }
    
    /**
     * @Route({
     *  "en": "/login",
     *  "fr": "/connexion"
     * }, name=":login", methods={"HEAD","GET","POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/partials/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name=":logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/forgotten-password", name=":forgotten-password", methods={"HEAD","GET","POST"})
     */
    public function forgottenPassword(Request $request, /*SwiftMailer $mailer,*/ UsersRepository $user): Response
    {
        // Get parameters
        $tokenRules = $this->getParameter('token');

        // Create new form based on the User Entity
        $form = $this->createForm(SecurityForgottenPasswordType::class);
        
        // Handle the Request (request method === post)
        $form->handleRequest($request);
        
        // On form submit
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // 1. Retrieve the email address from the form
            // --

            $email = $form->getData();


            // 2. Get user by email
            // --

            $user = $user->findOneBy([
                'email' => $email,
                'isDeleted' => false
            ]);


            // 3. Check User
            // --

            if (!$user) 
            {
                $this->addFlash('warning', 'No account found.');
                return $this->redirectToRoute('security:app:forgotten-password');
            }


            // 4. Generate the Reste Password Token
            // --

            // // Token Expiration
            // $tokenExpire = new \DateTime();
            // $tokenExpire->modify('+'.$tokenRules['expiration'].' minutes');
            // $tokenExpireText = $tokenExpire->format('Y-m-d H:i:s');

            // // Token String
            // $tokenPart1 = md5($user->getEmail());
            // $tokenPart2 = md5($tokenExpireText);
            // $tokenPart3 = md5($tokenPart1.$tokenPart2);
            // $tokenPart4 = md5(\uniqid());
            // $token = $tokenPart3.$tokenPart4;


            // 5. Update user entity
            // --
    
            // $user->setTokenPassword($token);
            // $user->setDatetimeTokenPasswordExpiration($tokenExpire);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            // 6. Send the Reset Password Link by eMail
            // --

            // $resetPasswordUrl = $this->generateUrl(
            //     'security:app:reset-password',
            //     ['token' => $token],
            //     UrlGenerator::ABSOLUTE_URL
            // );

            // $data = [
            //     'firstname' => $user->getFirstname(),
            //     'url' => $resetPasswordUrl
            // ];

            // $message = new \Swift_Message();
            // $message
            //     ->setSubject( "Reset password" )
            //     ->setFrom( $this->getParameter('emailSender') )
            //     ->setTo( $user->getEmail() )
            //     ->setBody( $this->renderView("security/emails/reset-password/reset-password.html.twig", $data), 'text/html' )
            //     ->addPart( $this->renderView("security/emails/reset-password/reset-password.txt.twig", $data), 'text/plain' )
            // ;

            // $sent = $mailer->send($message);


            // 7. Redirect user to the login page
            // --
            
            $this->addFlash('success', 'A link to reset your password was sent to your mailbox.');
            return $this->redirectToRoute('security:app:login');
        }

        // Create the form view
        $form = $form->createView();

        // TODO: forgotten password
        return $this->render('security/partials/forgotten-password.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/reset-password", name=":reset-password", methods={"HEAD","GET","POST"})
     */
    public function resetPassword(Request $request, UsersRepository $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // Get parameters
        $tokenRules = $this->getParameter('token');


        // 1. Retrieve token from URL parameters
        // --
        
        $token = $request->query->get('token');
        $invalidToken = false;


        // 2. Check the Token
        // --

        if (!preg_match($tokenRules['regex'], $token))
        {
            $this->addFlash('danger', 'The token is not valid.');
            return $this->redirectToRoute('security:app:forgotten-password');
        }


        // 3. Retrieve user in database
        // --

        $user = $user->findOneBy([
            'tokenPassword' => $token,
        ]);

        if (!$user)
        {
            $this->addFlash('danger', 'The token is not valid.');
            return $this->redirectToRoute('security:app:forgotten-password');
        }


        // 4. Check the token validity (expiration datetime)
        // --

        // $tokenExpiration = $user->getDatetimeTokenPasswordExpiration();
        // $now = new \DateTime();
        // $interval = $tokenExpiration->diff($now);

        // $intervalMinutes = $interval->days * 24 * 60;
        // $intervalMinutes+= $interval->h * 60;
        // $intervalMinutes+= $interval->i;

        // if ($intervalMinutes > $tokenRules['expiration'])
        // {
        //     $this->addFlash('danger', 'The token validity has expired.');
        //     return $this->redirectToRoute('security:app:forgotten-password');
        // }


        // 6. Create Reset Password form
        // --

        // Create new form based on the User Entity
        $form = $this->createForm(SecurityResetPasswordType::class);
        
        // Handle the Request (request method === post)
        $form->handleRequest($request);
        
        // On form submit
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // 7. Retrieve data from the form
            // --

            $plainPassword = $form->get('password')->getData();


            // 8. Data Manipulation / Generation
            // --

            // Encode the plain password
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $plainPassword
            );


            // 9. Set and Persist data
            // --

            $user->setPassword($encodedPassword);
            // $user->setTokenPassword(null);
            // $user->setDatetimeTokenPasswordExpiration(null);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            // 10. Send the confirmation email
            // --

            // Email data definition
            $data = [
                'firstname' => $user->getFirstname(),
            ];

            // SwiftMail Message Builder
            // $message = new \Swift_Message();
            // $message
            //     ->setSubject( "Reset Password Confirmation" )
            //     ->setFrom( $this->getParameter('emailSender') )
            //     ->setTo( $user->getEmail() )
            //     ->setBody( $this->renderView("security/emails/reset-confirmation/reset-confirmation.html.twig", $data), 'text/html' )
            //     ->addPart( $this->renderView("security/emails/reset-confirmation/reset-confirmation.txt.twig", $data), 'text/plain' )
            // ;

            // // Send the email
            // $sent = $mailer->send($message);


            // 11. Redirect user to the login page
            // --

            $this->addFlash('success', 'Your password has just been successfuly changed.');
            return $this->redirectToRoute('security:app:login');
        }

        // Create the form view
        $form = $form->createView();

        return $this->render('security/partials/reset-password.html.twig', [
            'form' => $form,
        ]);
    }
}

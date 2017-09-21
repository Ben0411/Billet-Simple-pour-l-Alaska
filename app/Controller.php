<?php
namespace Framework;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Form\Forms;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Csrf\TokenStorage\NativeSessionTokenStorage;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Validator\Validation;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Controller
{
    private $twig;
    private $doctrine = null;
    private $formFactory = null;
    private $request;
    private $routeName;
    private $routeCollection;
    private $config;
    private $session;

    public function __construct($request, $routeCollection, $config, $routeName)
    {
        
        $this->request = $request;
        $this->config = $config;
        $this->routeCollection = $routeCollection;

        $this->cacheFilesystem = new FilesystemAdapter();
        $assetsVersion = $this->cacheFilesystem->getItem('assets.version');

        $versionStrategy = new StaticVersionStrategy('v'.$assetsVersion->get(), '%s?version=%s');
        $package = new PathPackage('assets', $versionStrategy);

        $loader = new \Twig_Loader_Filesystem([__DIR__.'/../src/View',__DIR__.'/../vendor/symfony/twig-bridge/Resources/views/Form']);
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => false,
        ));
        $this->twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use ($package){
			return $package->getUrl($asset);
		}));
    }
    
    protected function getSession()
    {
        return $this->session;
    }

    protected function getRequest()
    {
        return $this->request;
    }

    protected function getFormFactory()
    {
        if($this->formFactory === null) {
           
            $csrfGenerator = new UriSafeTokenGenerator();
            $csrfStorage = new NativeSessionTokenStorage();
            $csrfManager = new CsrfTokenManager($csrfGenerator, $csrfStorage);

            $defaultFormTheme = isset($this->config["form"]["twig"]) ? $this->config["form"]["twig"] : 'form_div_layout.html.twig';

            $vendorDir = realpath(__DIR__.'/../vendor');
            $vendorFormDir = $vendorDir.'/symfony/form';
            $vendorValidatorDir = $vendorDir.'/symfony/validator';

            $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
            $vendorTwigBridgeDir = dirname($appVariableReflection->getFileName());

            $viewsDir = realpath(__DIR__.'/../src/views');

            $formEngine = new TwigRendererEngine(array($defaultFormTheme), $this->twig);
            $this->twig->addRuntimeLoader(new \Twig_FactoryRuntimeLoader(array(
                TwigRenderer::class => function () use ($formEngine, $csrfManager) {
                    return new TwigRenderer($formEngine, $csrfManager);
                },
            )));

            $validator = Validation::createValidator();


            $translator = new Translator('fr');
            $translator->addLoader('xlf', new XliffFileLoader());

            $translator->addResource(
                'xlf',
                $vendorFormDir.'/Resources/translations/validators.fr.xlf',
                'fr',
                'validators'
            );

            $translator->addResource(
                'xlf',
                $vendorValidatorDir.'/Resources/translations/validators.fr.xlf',
                'fr',
                'validators'
            );

            $this->twig->addExtension(new FormExtension());
            $this->twig->addExtension(new TranslationExtension($translator));

            $this->formFactory = Forms::createFormFactoryBuilder()
                ->addExtension(new ValidatorExtension($validator))
                ->addExtension(new CsrfExtension($csrfManager))
                ->addExtension(new HttpFoundationExtension())
                ->getFormFactory();
        }
        return $this->formFactory;
    }

    protected function getDoctrine()
    {
        if($this->doctrine === null) {
            $dbParams = array(
                'driver'   => 'pdo_mysql',
                'user'     => $this->config["doctrine"]["user"],
                'password' => $this->config["doctrine"]["password"],
                'dbname'   => $this->config["doctrine"]["dbname"],
                'charset' => 'utf8',
                
            );
            $cachedir = __DIR__."/cache";
            $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/Entity"), false, $cachedir);
            $config->setAutoGenerateProxyClasses(true);
            $this->doctrine = EntityManager::create($dbParams, $config);
        }
        return $this->doctrine;
    }

    protected function render($filename,$data)
    {
        $template = $this->twig->load($filename);
        $response = new Response($template->render($data));
        $response->send();
    }

    protected function json($data)
    {
        $response = new JsonResponse($data);
        $response->send();
    }

    protected function redirect($route,$args = array())
    {
        $context = new RequestContext('');
        $generator = new UrlGenerator($this->routeCollection, $context);
        $response = new RedirectResponse($generator->generate($route,$args));
        $response->send();
    }
    
   protected function getUser() {   
       if($this->user === null){
           if($this->request->getSession()->has("AUTH")){       
               $this->user = $this->doctrine->getRepository("Entity\User")>find($this->request->getSession()->get("AUTH"));
           }         
        }   
           return $this->user;
        }
    }

<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        } else {
            FactoryLocator::add(
                'Table',
                (new TableLocator())->allowFallbackClass(false)
            );
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
			Configure::write('DebugKit.forceEnable', true);	// ??
			//$this->addPlugin('DebugKit');
        }

        // Load more plugins here
		$this->addPlugin('JeffAdmin');
		//$this->addPlugin('JeffAdmin', ['routes' => true]);
        $this->addPlugin('CakePdf');

        $this->addPlugin(\CakeDC\Users\Plugin::class);
        // Uncomment the line below to load your custom users.php config file
		Configure::write('Users.config', ['users']);

        //$this->addPlugin('CakeDC/Auth');

    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {

	// 	csrf kikapcsolása csak egy-egy modulra:
	// Ezt kell beállítani alább: ->add($csrf); // tekerj lejjebb
	//

		$csrf = new CsrfProtectionMiddleware();

		//debug($csrf); die();

		$csrf->skipCheckCallback(function ($request) {
			$prefix 	= $request->getParam('prefix');
			$controller	= $request->getParam('controller');
			$action 	= $request->getParam('action');

			$allowedPrefix 		= ['Api', 'api', 'Apidev', 'apidev'];
			$allowedControllers = ['Simplepays', 'simplepays'];
			$allowedActions 	= ['Simplepay', 'simplepay', 'Test', 'test'];

			file_put_contents(LOGS . 'request.log', 'prefix: ' . $prefix . "\n", FILE_APPEND);
			file_put_contents(LOGS . 'request.log', 'controller: ' . $controller . "\n", FILE_APPEND);
			file_put_contents(LOGS . 'request.log', 'action: ' . $action . "\n", FILE_APPEND);

			if( in_array($prefix, $allowedPrefix) ) {
				file_put_contents(LOGS . 'request.log', 'IN PREFIX' . "\n", FILE_APPEND);
			}
			if( in_array($controller, $allowedControllers) ) {
				file_put_contents(LOGS . 'request.log', 'IN CONTROLLER' . "\n", FILE_APPEND);
			}
			if( in_array($action, $allowedActions) ) {
				file_put_contents(LOGS . 'request.log', 'IN ACTION' . "\n", FILE_APPEND);
			}

			if( in_array($prefix, $allowedPrefix) && in_array($controller, $allowedControllers) && in_array($action, $allowedActions) ) {

				file_put_contents(LOGS . 'request.log', 'ALLOWED' . "\n", FILE_APPEND);

				return true;
			}

			file_put_contents(LOGS . 'request.log', 'DISABLED' . "\n", FILE_APPEND);

			return false;
		});


		// Ensure routing middleware is added to the queue before CSRF protection middleware.


        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // Add routing middleware.
            // If you have a large number of routes connected, turning on routes
            // caching in production could improve performance. For that when
            // creating the middleware instance specify the cache config name by
            // using it's second constructor argument:
            // `new RoutingMiddleware($this, '_cake_routes_')`
            ->add(new RoutingMiddleware($this))

            // Parse various types of encoded request bodies so that they are
            // available as array through $request->getData()
            // https://book.cakephp.org/4/en/controllers/middleware.html#body-parser-middleware
            ->add(new BodyParserMiddleware())

            // Cross Site Request Forgery (CSRF) Protection Middleware
            // https://book.cakephp.org/4/en/controllers/middleware.html#cross-site-request-forgery-csrf-middleware

			->add($csrf); // Ha ki van kapcsolva a csrf egy-egy modulra, akkor ezt kell alkalmazni. Az eredeti alább:

            //->add(new CsrfProtectionMiddleware([
            //    'httponly' => true,
            //]));

		//$middlewareQueue->add($csrf);

        return $middlewareQueue;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
    }

    /**
     * Bootstrapping for CLI application.
     *
     * That is when running commands.
     *
     * @return void
     */
    protected function bootstrapCli(): void
    {
        $this->addOptionalPlugin('Cake/Repl');
        $this->addOptionalPlugin('Bake');

        $this->addPlugin('Migrations');

        // Load more plugins here
    }
}

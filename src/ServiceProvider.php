<?php

namespace Neurony\Redirects;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Neurony\Redirects\Models\Redirect;
use Illuminate\Contracts\Foundation\Application;
use Neurony\Redirects\Middleware\RedirectRequests;
use Neurony\Redirects\Contracts\RedirectModelContract;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * Create a new service provider instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->router = $router;

        $this->publishConfigs();
        $this->publishMigrations();
        $this->registerMiddleware();
        $this->registerRouteBindings();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * @return void
     */
    protected function publishConfigs()
    {
        $this->publishes([
            __DIR__.'/../config/redirects.php' => config_path('redirects.php'),
        ], 'config');
    }

    /**
     * @return void
     */
    protected function publishMigrations()
    {
        if (empty(File::glob(database_path('migrations/*_create_redirects_table.php')))) {
            $timestamp = date('Y_m_d_His', time());
            $migration = database_path("migrations/{$timestamp}_create_redirects_table.php");

            $this->publishes([
                __DIR__.'/../database/migrations/create_redirects_table.php.stub' => $migration,
            ], 'migrations');
        }
    }

    /**
     * @return void
     */
    protected function registerMiddleware()
    {
        $this->router->aliasMiddleware('redirect.requests', RedirectRequests::class);
    }

    /**
     * @return void
     */
    protected function registerRouteBindings()
    {
        Route::model('redirect', RedirectModelContract::class);
    }

    /**
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind(RedirectModelContract::class, $this->config['revisions']['revision_model'] ?? Redirect::class);
        $this->app->alias(RedirectModelContract::class, 'revision.model');
    }
}

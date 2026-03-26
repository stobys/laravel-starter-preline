<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('layout.paginator');

        $this -> bootRequestMacros();

        // $this->configureSecureUrls();

        // $this->bootViewComposers();

        // $this->bootBladeDirectives();
    }

    protected function bootRequestMacros(): void
    {
        // Add any request macros here if needed
        Request::macro('sortUrl', function ($field, $order = 'asc') {
            $params = request()->query();
            $params['sf'] = $field;
            $params['so'] = $order;

            return request()->fullUrlWithQuery($params);
        });
    }

	protected function bootViewComposers(): void
    {
        View::composer([
            'layout.first.partials.sidebar',
            'layout.flowbite.partials.sidebar',
        ], AppSidebarComposer::class);

        View::composer([
            'layout.first.partials.header',
            'layout.flowbite.partials.header',
        ], AppHeaderComposer::class);
    }

    protected function bootBladeDirectives(): void
    {
        Blade::directive('transfb', function ($expression) {
            // Rozdzielamy argumenty przekazane do dyrektywy
            // Oczekujemy formatu: 'klucz.tlumaczenia', 'Wartość domyślna'
            list($key, $fallback) = explode(',', $expression, 2);

            // Zwracamy kod PHP, który zostanie wykonany w widoku
            return "<?php echo Lang::has({$key}) ? trans({$key}) : {$fallback}; ?>";
        });
    }

    protected function configureSecureUrls()
    {
        // Determine if HTTPS should be enforced
        $enforceHttps = $this->app->environment(['production', 'staging'])
            && !$this->app->runningUnitTests();

        // Force HTTPS for all generated URLs
        URL::forceHttps($enforceHttps);

        // Ensure proper server variable is set
        if ($enforceHttps) {
            $this->app['request']->server->set('HTTPS', 'on');
        }

        // Set up global middleware for security headers
        if ($enforceHttps) {
            $this->app['router']->pushMiddlewareToGroup('web', function ($request, $next){
                $response = $next($request);

                return $response->withHeaders([
                    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
                    'Content-Security-Policy' => "upgrade-insecure-requests",
                    'X-Content-Type-Options' => 'nosniff'
                ]);
            });
        }
    }
}

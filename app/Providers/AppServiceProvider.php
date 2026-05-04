<?php

namespace App\Providers;

use App\Services\ServiceTaskRegistry;
use App\View\Composers\AppHeaderComposer;
use App\View\Composers\AppSidebarComposer;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // -- Register any application services.
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
		Paginator::defaultView('layout.paginator');

        $this -> bootRequestMacros();

		$this -> bootViewComposers();

        // $this->bootBladeDirectives();

		$this->bootCarconMacros();

		// $this->bootBuilderMacros();

        // $this->configureSecureUrls();

		$this->app->singleton(ServiceTaskRegistry::class);
    }

 	protected function bootPolicies(): void
	{
		Gate::policy(App\Models\Training::class, App\Policies\TrainingPolicy::class);
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

		Blade::if('debug', function () {
            return env('APP_DEBUG', false);
        });

		Blade::if('superAdmin', function () {
            return auth()->user()?->isSuperAdmin();
        });
    }

	protected function bootCarconMacros(): void
	{
        Carbon::macro('getWeekOfYearLeadingZeros', function () {
            return str_pad($this->weekOfYear, 2, '0', STR_PAD_LEFT);
        });

        Carbon::macro('getFiscalYear', function () {
            $schoolYear = self::this()->year;

            if ($this->month > 9) {
                $schoolYear++;
            }

            return $schoolYear;
        });

        Carbon::macro('isPastWeek', function () {
            if ($this->weekOfYear < $this->clone()->now()->weekOfYear) {
                return true;
            }

            return false;
        });
	}

	protected function bootBuilderMacros(): void
	{
		Builder::macro('addSubSelect', function($column, $query) {
            if (is_null($this->getQuery()->columns)) {
                $this->select($this->getQuery()->from .'.*');
            }

            return $this->selectSub($query->limit(1)->getQuery(), $column);
        });

		/*
         * Orders sub-query results.
         *
         * @author @reinink
         *
         * @param Builder $query
         * @param        $direction
         *
         * @return Builder
         */
        Builder::macro('orderBySub', function ($query, $direction='asc', $nullPosition=null) {
            if (!in_array($direction, ['asc', 'desc'])) {
                throw new Exception('Not a valid direction.');
            }

            if (!in_array($nullPosition, [null, 'first', 'last'], true)) {
                throw new Exception('Not a valid null position.');
            }

            return $this->orderByRaw(
                implode('', ['(', $query->limit(1)->toSql(), ') ', $direction, $nullPosition ? ' NULLS ' . strtoupper($nullPosition) : null]),
                $query->getBindings()
            );
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

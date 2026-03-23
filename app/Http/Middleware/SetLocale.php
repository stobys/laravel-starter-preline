<?php
// app/Http/Middleware/SsoAuthenticate.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if(! $request->user()) {
            return $next($request);
        }

        // -- fetch locale somehow (session, db)
        $lang = session()->get('locale');

        if (isset($lang)) {
            app()->setLocale($lang);
        }

        return $next($request);

    }
}

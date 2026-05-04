<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lab404\Impersonate\Services\ImpersonateManager;

class ImpersonateController extends Controller
{
    /** @var ImpersonateManager */
    protected $manager;

    /**
     * ImpersonateController constructor.
     */
    public function __construct()
    {
        $this->manager = app()->make(ImpersonateManager::class);

        $guard = $this->manager->getDefaultSessionGuard();
        $this->middleware('auth:' . $guard)->only('take');
    }

    /**
     * @param int         $id
     * @param string|null $guardName
     * @return  RedirectResponse
     * @throws  \Exception
     */
    public function take(Request $request, $id, $guardName = null)
    {
        $guardName = $guardName ?? $this->manager->getDefaultSessionGuard();

        // -- cannot impersonate yourself
        if ($id == $request->user()->getAuthIdentifier() && ($this->manager->getCurrentAuthGuardName() == $guardName)) {
            abort(403, 'Cannot impersonate yourself');
        }

        // -- cannot impersonate again if you're already impersonate a user
        if ($this->manager->isImpersonating()) {
            abort(403, 'Cannot impersonate while you are already impersonating a user');
        }

        $userToImpersonate = $this->manager->findUserById($id, $guardName);

        // -- cannot impersonate built-in account
        if ( $userToImpersonate->isBuiltIn() ) {
            abort(403, 'Cannot impersonate built-in account');
        }


        if (!$request->user()->canSubstitute($id)) {
            abort(401, 'No active delegation for users "' . $request->user()->username . '" -> "' . $userToImpersonate->username . '"');
        }

        if ($userToImpersonate->canBeImpersonated($request->user()->id)) {
            if ($this->manager->take($request->user(), $userToImpersonate, $guardName)) {
                $takeRedirect = $this->manager->getTakeRedirectTo();
                if ($takeRedirect !== 'back') {
                    return redirect()->to($takeRedirect);
                }
            }
        }

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function leave()
    {
        if (!$this->manager->isImpersonating()) {
            abort(403);
        }

        $this->manager->leave();

        $leaveRedirect = $this->manager->getLeaveRedirectTo();
        if ($leaveRedirect !== 'back') {
            return redirect()->to($leaveRedirect);
        }
        return redirect()->back();
    }
}

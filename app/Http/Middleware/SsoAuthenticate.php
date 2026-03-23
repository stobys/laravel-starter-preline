<?php
// app/Http/Middleware/SsoAuthenticate.php
namespace App\Http\Middleware;

use App\Jobs\UpdateUserInfoFromActiveDirectory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class SsoAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Sprawdź, czy użytkownik nie jest już zalogowany w sesji Laravel
        if ( !Auth::check() ) {
            // Sprawdź, czy serwer WWW przekazał uwierzytelnionego użytkownika
            $remoteUser = $request->server('REMOTE_USER');

            if ($remoteUser) {
                // -- Wytnij część z domeną, np. z 'jkowalski@FIRMA.LOCAL' zrób 'jkowalski'
                $username = explode('\\', $remoteUser)[1];

                $user = User::firstOrCreate(
                    ['username' => $username], // Warto mieć kolumnę 'username' lub 'samaccountname'
                    [
                        'first_name' => $username, // Uzupełnij dane, np. z LDAP
                        'last_name' => $username, // Uzupełnij dane, np. z LDAP
                        'email' => $username .'adient.com', // Lub inny unikalny email
                        'password' => bcrypt(Str::random(16)) // Hasło jest bez znaczenia przy SSO
                    ]
                );

				if ($user->wasRecentlyCreated) {
					$ldapUser = LdapUser::findByOrFail('samaccountname', $username);

					$user -> first_name = $ldapUser->getFirstAttribute('givenname');
					$user -> last_name = $ldapUser->getFirstAttribute('sn');
					$user -> email = $ldapUser->getFirstAttribute('mail');
					$user -> save();

					// UpdateUserInfoFromActiveDirectory::dispatch($username);
				}

                // -- zaloguj użytkownika do sesji Laravel
                Auth::login($user);
            }
        }

        return $next($request);
    }
}

// -> title" => "IT Administrator"
// -> cn" => "atobyss"
// -> sn" => "Tobys"
// -> givenname" => "Sławomir"
// -> department" => "Gracjan Krasiński"
// -> company" => "Adient Poland sp. z o.o."
// -> userprincipalname" => "atobyss@adient.com"
// -> mail" => "slawomir.tobys@adient.com"
// -> manager" => "CN=akrasig,OU=Users,OU=8014-Poland-Swiebodzin,OU=Facilities,DC=autoexpr,DC=com"
// -> mobile" => "+48 660 767 498"
// -> thumbnailphoto
// -> manageruniqueid" => "U2733964"
// -> jcihrmanageruniqueid" => "U2733145"
// -> jcihrmanager" => "CN=acale,OU=Users,OU=8014-Poland-Swiebodzin,OU=Facilities,DC=autoexpr,DC=com"
// -> ipphone" => "U3171921"
// -> getdn() = "CN=atobyss,OU=Users,OU=8014-Poland-Swiebodzin,OU=Facilities,DC=autoexpr,DC=com"


// -> jcibusinesstitledescription   => "IT Operator"
// -> jcihrcity" => "Swiebodzin"
// -> memberof
// -> mobile      => "+48 660 767 498"
// -> postalcode" => "66200"
// -> physicaldeliveryofficename" => "Swiebodzin"
// -> telephonenumber" => "+48683820498"
// -> provstatus" => "active"
// -> hrstatus" => "A"
// -> jcihrtelecomid" => "8014"

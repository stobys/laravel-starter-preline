<?php

namespace App\Models\LDAP;

use App\Models\User;
use LdapRecord\Models\Model;
use LdapRecord\Query\Model\Builder;

// class GlobalID extends Entry
class GlobalID extends Model
{
    public static array $objectClasses = [
        'top',
        'person',
        'organizationalperson',
        'user',
    ];

    public function newQuery(): Builder
    {
        $query = parent::newQuery();

		return $query->select([
            'cn',                           // -- global id
            'samaccountname',               // -- global id (samaccountname)
            'givenname',                    // -- first name
            'sn',                           // -- last name
            'title',                        // -- job title
            'telephonenumber',              // -- phone number
            'distinguishedname',            // -- CN=,OU=,DC=,DC=
            'displayname',                  // -- display name (first name + last name)
            // 'memberof',
            'department',                   // -- department ; managers display name
            'userprincipalname',            // -- globalid@adient.com
            'mail',                         // -- email
            'manager',                      // -- manager's CN=,OU=,DC=,DC=
			'mobile',
		]);
    }

    public function sync()
    {
        // T_PRAC: prac_id, imie, imie_2, nazwisko, nr_ew, data_zatr, data_rozw, plec, guid
        $model = [
			'is_domain_user'	=> true,
            'first_name'    	=> mb_ucfirst(mb_strtolower($this -> getFirstAttribute('givenname'))),
            'last_name'   		=> mb_ucfirst(mb_strtolower($this -> getFirstAttribute('sn'))),
            'username'     		=> $this -> getFirstAttribute('samaccountname') ?? $this->getFirstAttribute('cn'),
            'email'  			=> $this -> getFirstAttribute('mail'),
        ];

		$user = User::whereUsername($model['username'])->first();
		if( $user )
		{
			$user->update($model);
		}
		else {
			User::updateOrCreate([
				'first_name' => $model['first_name'],
				'last_name' => $model['last_name'],
			], $model);
		}

		// -- fetch thumbnailPhoto
		// $this -> fetchThumbnailPhoto();
    }


	public function fetchThumbnailPhoto()
	{
		$savePath = public_path('img/avatars');
		if (!is_dir($savePath)) {
            mkdir($savePath, 0775, true);
        }

		$username = $this->getFirstAttribute('samaccountname');
		$photo    = $this->getFirstAttribute('thumbnailphoto');

		if (!$username) {
			return false;
		}

		if (!$photo) {
			return false;
		}

		$filename = strtolower($username) . '.jpg';
		$fullPath = $savePath . DIRECTORY_SEPARATOR . $filename;

		return file_put_contents($fullPath, $photo); // return number of bytes written or false on failure
	}

}

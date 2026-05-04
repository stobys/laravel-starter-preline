<?php

namespace App\Models\LDAP;

use LdapRecord\Models\Model;

class __LdapUser extends Model
{
    /**
     * The object classes of the LDAP model.
     */
    public static array $objectClasses = [
        'top',
        'person',
        'organizationalperson',
        'user',
    ];

    /**
     * The attributes of the LDAP model.
     */
    public array $attributes = [
        'dn',
        'cn',
        'sn',
        'givenname',
        'mail',
        'telephonenumber',
        'userprincipalname',
    ];

}

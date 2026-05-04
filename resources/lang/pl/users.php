<?php

return [
    'labels'    => [
        'index-title'        		=> 'Użytkownicy',
        'index-title-helper' 		=> 'Lista Użytkowników',
        'create-title'        		=> 'Użytkownicy: Tworzenie',
        'create-title-helper' 		=> 'Formularz tworzenia Użytkownika',
        'edit-title'        		=> 'Użytkownicy: Edycja',
        'edit-title-helper' 		=> 'Formularz edycji Użytkownika',
        'show-title'        		=> 'Użytkownicy: Podgląd',
        'show-title-helper' 		=> 'Podgląd Użytkownika',
		'import-title'				=> 'Importowanie Użytkowników',
		'import-title-helper'		=> 'Formularz importowania Użytkowników',
		'settings-title'			=> 'Ustawienia Użytkownika',
		'settings-title-helper'		=> 'Formularz ustawień Użytkownika',
		'validation-errors-title'	=> 'Wystąpiły błędy walidacji', // There are some validation errors.'

		'password-divider'			=> 'Hasło (opcjonalnie)',
    ],

    'actions' => [
        'add-new' 		=> 'Dodaj Użytkownika',
        'sync-teta' 	=> 'Synchronizuj z TETA',
		'syncing-teta'	=> 'Synchronizowanie ...',

        'sync-ldap' 	=> 'Synchronizuj z AD',
		'syncing-ldap'	=> 'Synchronizowanie ...',

		'impersonate-take'	=> 'Podszyj się',
		'impersonate-leave'	=> 'Opuść Rolę',
    ],

    'th' => [
        'id' 					=> 'ID',
        'department'			=> 'Dział',
		'manager'				=> 'Przełożony',
        'username'				=> 'Global ID',
        'email'					=> 'Email',
        'first-name'			=> 'Imię',
        'last-name'				=> 'Nazwisko',
        'name'					=> 'Nazwa',
        'status'				=> 'Status',
        'roles'					=> 'Role',
        'password-age'			=> 'Wiek Hasła',
        'password'				=> 'Hasło',
        'password-confirmation'	=> 'Potwierdzenie Hasła',
        'created_at'			=> 'Data Utworzenia',
    ],

	'validation'	=> [
		'own-manager'	=> 'Użytkownik nie może być swoim własnym przełożonym',
	],

];

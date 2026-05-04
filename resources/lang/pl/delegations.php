<?php

return [
    'labels'    => [
        'index-title'        		=> 'Zastępstwa',
        'index-title-helper' 		=> 'Zastępstwa : Lista',
        'create-title'        		=> 'Zastępstwa : Tworzenie',
        'create-title-helper' 		=> 'Formularz tworzenia Zastępstwa',
        'edit-title'        		=> 'Zastępstwa : Edycja',
        'edit-title-helper' 		=> 'Formularz edycji Zastępstwa',
		'validation-errors-title'	=> 'Wystąpiły błędy walidacji', // There are some validation errors.'

		'incoming'					=> 'Otrzymane zastępstwa', // Incoming Delegations
		'outgoing'					=> 'Udzielone zastępstwa', // Outgoing Delegations
    ],

    'actions' => [
        'add-new' 		=> 'Dodaj Zastępstwo',
    ],

    'th' => [
        'id' 					=> 'ID',
        'principal'				=> 'Zastępowany',
		'substitute'			=> 'Zastępca',
        'valid_from'			=> 'Ważne Od',
        'valid_to'				=> 'Ważne Do',
        'comment'				=> 'Komentarz',
        'created_at'			=> 'Data Utworzenia',
    ],

	'validation'	=> [
		'own-manager'	=> 'Użytkownik nie może być swoim własnym przełożonym',
	],

];

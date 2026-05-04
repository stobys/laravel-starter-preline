<?php

return [
    'labels'    => [
		'index-title'			=> 'Szkolenia',
		'index-title-helper'	=> 'Zarządzaj szkoleniami',

		'index-trainings-title'	=> 'Szkolenia',
		'index-trainings-title-helper'	=> 'Zarządzaj szkoleniami',

		'index-participants-title'	=> 'Uczestnicy Szkoleń',
		'index-participants-title-helper'	=> 'Zarządzaj szkoleniami',

		'create-title'			=> 'Szkolenia: Tworzenie',
		'create-title-helper'	=> 'Formularz dodawania szkolenia',

		'edit-title'			=> 'Szkolenia: Edycja',
		'edit-title-helper'		=> 'Formularz edycji szkolenia',

		'show-title'			=> 'Szkolenia: Podgląd',
		'show-title-helper'		=> 'Pogląd szkolenia',

		'import-title'			=> 'Importowanie Szkoleń',
		'import-title-helper'	=> 'Formularz importu szkoleń',

        'participants-list'     => 'Lista Uczestników',
        'trainings-list'        => 'Lista Szkoleń',

        'trainings_list_helper' => 'Zarzadzaj istniejącymi szkoleniami lub dodaj nowe',
        'evaluation' 			=> 'Ocena',
        'evaluation_helper' 	=> 'Odpowiedz na kilka prostych pytań',

		'training-info-tab'			=> 'Informacje',
		'training-participants-tab'	=> 'Uczestnicy',
		'training-attachments-tab'	=> 'Załączniki',
		'training-reviews-tab'		=> 'Oceny Pracowników',
		'training-evaluations-tab'	=> 'Transfer Wiedzy',
		'training-audit-tab'		=> 'Audyt',

		'planned_training'		=> 'Zabudżetowane',
		'unplanned_training'	=> 'Nieplanowane',

		'training_included_in_the_budget'		=> 'Uzględnione w&nbsp;budżecie',
		'training_not_included_in_the_budget'	=> '_NIE_ uzględnione w&nbsp;budżecie',

		'select-participant'		=> 'Wybierz Uczestnika ...',
		'add-participant'			=> 'Dodaj Uczestnika',

		'uploading_files'			=> 'Przesyłanie plików ...',
		'click_to_add_files'		=> 'Kliknij, aby dodać pliki',
		'or_drag_and_drop_files'	=> 'lub przeciągnij je tutaj',
		'multiple_files_with_max_size' => 'Wiele plików jednocześnie • max :size MB każdy',
		'saved_attachments'				=> 'Zapisane załączniki',
		'no_saved_attachments'			=> 'Brak załączników',
		'to_be_deleted'					=> 'do usunięcia',
		'new_to_be_added'				=> 'Nowe, do dodania',
		'add_files_above'				=> 'Dodaj pliki powyżej',

    ],

    'actions' => [
		'add-new'		=> 'Dodaj Szkolenie',

		'submit_for_approval'	=> 'Wyślij do akceptacji',
		'withdraw'	=> 'Wycofaj',
		'approve'	=> 'Zaakceptuj',
		'reject'	=> 'Odrzuć',
		'mark_no_show'	=> 'Uczestnik nie pojawił się',

		'mark_completed'	=> 'Oznacz jako Wykonane',
		'mark_not_completed'	=> 'Oznacz jako Niewykonane',

        'review' 							=> 'Oceń',
        'submit_review' 					=> 'Zapisz Ocenę',

        'evaluate' 							=> 'Oceń',
        'submit_evaluation' 				=> 'Zapisz Ocenę',
        'cancel_evaluation' 				=> 'Anuluj',

        'submit_effectiveness_evaluation' 	=> 'Zapisz Ocenę',
        'cancel_effectiveness_evaluation' 	=> 'Anuluj',

        'mark_as_realized_tooltip' => 'Oznacz jako Zrealizowane',
        'mark_as_realized_prompt' => 'Czy na pewno oznaczyc to szkolenie jako Zrealizowane?',
        'training_evaluate_tooltip' => 'Oceń Szkolenie',
        'training_evaluate_prompt' => 'Czy na pewno ocenić szkolenie?',
        'effectiveness_evaluate' => 'Oceń Efektywność',
        'effectiveness_evaluate_prompt' => 'Czy na pewno ocenić Efektywność Szkolenia?',

		'save_attachments'		=> 'Zapisz załączniki',
    ],

    'th' => [
        'id' => 'ID',
        'provider' => 'Dostawca',
        'participant' => 'Uczestnik',
        'department' => 'Dział',
        'title' => 'Szkolenie',
        'type' => 'Typ',
        'budget' => 'Budżet',

		'evaluation_average'	=> 'Średnia Ocena',

        'actual_cost' => 'Rzeczywisty Koszt',
        'planned_cost' => 'Planowany Koszt / PO',
        'planned_date' => 'Planowana Data',
        'fiscal_year' => 'Rok Fiskalny',
        'fiscal_quarter' => 'Kwartał',
        'po_number' => 'Nr Zamówienia / PO',

        'user' => 'Pracownik',
        'state' => 'Stan',
        'status' => 'Status',
        'period' => 'Okres',
        'starts_at' => 'Początek',
        'ends_at' => 'Koniec',
        'scheduled_at' => 'Planowana Data',
        'submitted_at' => 'Data Wysłania',
        'submitted_by' => 'Wysłane Przez',

		'attachment_note'	=> 'Notatka',

        'actions' => 'Akcje',
        'created_at' => 'Data Utworzenia',
    ],

    'state' => [
        'any' => 'Dowolne',
        'draft' => 'Szkic',
        'planned' => 'Zaplanowane',
        'pending' => 'Oczekujące',
        'approved' => 'Zaakceptowane',
        'rejected' => 'Odrzucone',
        'completed' => 'Zrealizowane',
        'not_completed' => 'Nie Zrealizowane',
		'reviewed' => 'Ocenione',
		'closed' => 'Zakończone',
		'withdrawn' => 'Wycofane',
    ],

    'type' => [
        'any' => 'Dowolny',
        'on-site' => 'W Zakładzie',
        'off-site' => 'Poza Zakładem',
        'online' => 'Online',
    ],

    'status' => [
        'any' => 'Dowolne',
        'pending_approval' => 'Oczekuje Akceptacji',
        'planned' => 'Zaplanowane',
        'realized' => 'Zrealizowane',
        'mark_as_realized_tooltip' => 'Oznacz jako Zrealizowane',
        'mark_as_realized_prompt' => 'Czy na pewno oznaczyc to szkolenie jako Zrealizowane?',
        'cancelled' => 'Anulowane',
        'evaluated' => 'Ocenione',
        'finished' => 'Zakończone',

        'training_evaluated' => 'Ocenione',
        'effectiveness_evaluated' => 'Oceniona Efektywność',
        'evaluate_tooltip' => 'Evaluate',
        'evaluate_prompt' => '',
    ],

	'training_evaluate_tooltip' => 'Oceń Szkolenie',
	'training_evaluate_prompt' => 'Czy na pewno ocenić to szkolenie?',
	'effectiveness_evaluate_tooltip' => 'Oceń Efektywność',
	'effectiveness_evaluate_prompt' => 'Czy na pewno ocenić to efektywność szkolenia?',

    'reviews' => [
		'title'			=> 'Ocena Szkolenia',
		'title-helper'	=> 'Formularz oceny szkolenia',

        'review_of_meeting_expectations' => 'Program szkolenia spełnił moje oczekiwania.',
        'review_of_application_of_acquired_information_at_work' => 'Jestem pewny zastosowania nowo nabytych informacji w mojej pracy.',
        'review_of_the_use_of_training_time' => 'Czas przeznaczony na szkolenie został efektywnie wykorzystany.',
        'review_of_recommendations_for_other_employees' => 'Z pewnością polecę to szkolenie innym pracownikom.',
        'review_of_instructor_prepatation_to_conduct' => 'Prowadzący był doskonale przygotowany do przeprowadzenia szkolenia.',
        'review_of_local_and_technical_conditions' => 'Warunki lokalowe i techniczne były zdecydowanie dobre.',
        'review_of_overall_preparation' => 'Szkolenie było przygotowane bardzo dobrze pod każdym względem.',
        'review_of_training_materials_and_their_use_at_work' => 'Otrzymane materiały szkoleniowe są na odpowiednim poziomie i z pewnością będą pomocne w mojej pracy.',
        'review_stronly_disagree' => 'Bardzo Się Nie Zgadzam',
        'review_disagree' => 'Nie Zgadzam Się',
        'review_neutral' => 'Neutralnie',
        'review_agree' => 'Zgadzam Się',
        'review_stronly_agree' => 'Bardzo Się Zgadzam',
		'review_comment' => 'Komentarz',
    ],

	'evaluations'	=> [
		'title'			=> 'Efektywność Szkolenia',
		'title-helper'	=> 'Formularz oceny efektywności szkolenia',
		'eval_yes'  => 'Tak',
		'eval_no'   => 'Nie',

		'evaluation_of_use_of_knowledge' => 'Czy wiedza zdobyta podczas szkolenia jest wykorzystywana w pracy?',
		'evaluation_of_use_of_knowledge_details_yes' => 'W jakim zakresie? W jaki sposób widoczne jest wykorzystanie wiedzy?',
		'evaluation_of_use_of_knowledge_details_no' => 'Dlaczego wiedza zdobyta podczas szkolenia nie jest wykorzystywana?',

		'evaluation_of_need_for_further_training' => 'Czy konieczne jest dalsze szkolenie w tym zakresie?',
		'evaluation_of_need_for_further_training_details_yes' => 'W jakich obszarach i w jakim zakresie?',
	],


    'validation'    => [
        'import-file-required'   => 'Załącz plik tekstowy',
        'import-file-mimes'   => 'Tylko pliki csv lub txt są dozwolone',
        'import-file-max'   => 'Maksymalny rozmiar pliku to 1MB',
    ],

];

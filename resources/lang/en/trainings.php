<?php

return [
    'labels' => [
		'index-title'			=> 'Trainings',
		'index-title-helper'	=> 'Manage Trainings',

		'index-trainings-title'	=> 'Trainings',
		'index-trainings-title-helper'	=> 'Manage Trainings',

		'index-participants-title'	=> 'Training Participants',
		'index-participants-title-helper'	=> 'Manage Trainings',

		'create-title'			=> 'Trainings: Create',
		'create-title-helper'	=> 'Training Create Form',

		'edit-title'			=> 'Trainings: Edit',
		'edit-title-helper'		=> 'Training Edit Form',

		'show-title'			=> 'Trainings: Preview',
		'show-title-helper'		=> 'Training Preview Form',

		'import-title'			=> 'Trainings Import',
		'import-title-helper'	=> 'Training Import Form',

        'participants-list'     => 'Participants List',
        'trainings-list'        => 'Trainings List',

        'trainings_list_helper' => 'Manage all your trainings or add a new one',
        'evaluation' => 'Evaluation',
        'evaluation_helper' => 'Answer few simple questions',

		'training-info-tab'			=> 'General Info',
		'training-participants-tab'	=> 'Participants',
		'training-attachments-tab'	=> 'Attachments',
		'training-reviews-tab'		=> 'Reviews',
		'training-evaluations-tab'	=> 'Evaluation',
		'training-audit-tab'		=> 'Audit',

		'planned_training'		=> 'Planned',
		'unplanned_training'	=> 'Not Planned',

		'training_included_in_the_budget'		=> 'Included in the budget',
		'training_not_included_in_the_budget'	=> '_NOT_ included in the budget',

		'select-participant'		=> 'Select Participant ...',
		'add-participant'			=> 'Add Participant',

		'uploading_files'			=> 'Uploading files ...',
		'click_to_add_files'		=> 'Click here to choose files',
		'or_drag_and_drop_files'	=> 'or drag&drop them here',
		'multiple_files_with_max_size' => "Multiple files • max :size MB each",
		'saved_attachments'				=> 'Saved attachments',
		'no_saved_attachments'			=> 'No attachments',
		'to_be_deleted'					=> 'to be deleted',
		'new_to_be_added'				=> 'New, to be added',
		'add_files_above'				=> 'Add files above',

    ],

    'actions' => [
		'add-new'		=> 'Add Training',

		'submit_for_approval'	=> 'Submit for Approval',
		'withdraw'	=> 'Withdraw',
		'approve'	=> 'Approve',
		'reject'	=> 'Reject',
		'mark_no_show'	=> 'Participant didn\'t show up',

		'mark_completed'	=> 'Mark Completed',
		'mark_not_completed'	=> 'Mark Not Completed',

        'review' => 'Review',
        'evaluate' => 'Evaluate',
        'submit_review' => 'Submit',
        'submit_evaluation' => 'Submit',
        'cancel_evaluation' => 'Cancel',
        'submit_effectiveness_evaluation' => 'Submit',
        'cancel_effectiveness_evaluation' => 'Cancel',

        'mark_as_realized_tooltip' => 'Mark as Realized',
        'mark_as_realized_prompt' => 'Are you sure you want to mark this Training as Realized?',
        'training_evaluate_tooltip' => 'Evaluate Training',
        'training_evaluate_prompt' => 'Are you sure you want to Evaluate this Training?',
        'effectiveness_evaluate_tooltip' => 'Evaluate Effectiveness',
        'effectiveness_evaluate_prompt' => 'Are you sure you want to Evaluate this Effectiveness?',

		'save_attachments'		=> 'Save attachments',
    ],

    'th' => [
        'id' => 'ID',
        'actions' => 'Actions',
        'provider' => 'Provider',
        'participant' => 'Participant',
        'department' => 'Department',
        'title' => 'Title',
        'type' => 'Type',
		'budget' => 'Budget',

		'evaluation_average'	=> 'Avg Eval',

        'actual_cost' => 'Actual Cost',
        'planned_cost' => 'Planned Cost / PO',
        'planned_date' => 'Planned Date',
        'fiscal_year' => 'Planned Fiscal Year',
        'fiscal_quarter' => 'Planned Quarter',
        'po_number' => 'Purchase Order / PO',

		'user'	=> 'Employee',
        'state' => 'Approval State',
        'status' => 'Status',
        'period' => 'Period',
        'starts_at' => 'Starts At',
        'ends_at' => 'Ends At',
        'scheduled_at' => 'Scheduled At',
        'submitted_at' => 'Submitted At',
        'submitted_by' => 'Submitted By',

		'attachment_note'	=> 'Note',

        'actions' => 'Actions',
        'created_at' => 'Creation Date',
    ],

    'state' => [
        'any' => 'Any',
        'draft' => 'Draft',
        'planned' => 'Planned',
        'pending' => 'Pending Approval',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
		'completed'	=> 'Completed',
		'not_completed'	=> 'Not Completed',
		'reviewed' => 'Reviewed',
		'closed' => 'Closed',
        'withdrawn' => 'Withdrawn',
    ],

    'type' => [
        'any' => 'Any',
        'on-site' => 'On-Site',
        'off-site' => 'Off-Site',
        'online' => 'Online',
    ],

    'status'    => [
        'any' => 'Any',
        'pending_approval' => 'Pending Approval',
        'planned' => 'Planned',
        'realized' => 'Realized',
        'mark_as_realized_tooltip' => 'Mark as Realized',
        'mark_as_realized_prompt' => 'Are you sure you want to mark this Training as Realized?',
        'cancelled' => 'Cancelled',
        'evaluated' => 'Evaluated',
		'finished' => 'Finished',

        'training_evaluated' => 'Training Evaluated',
        'effectiveness_evaluated' => 'Effectiveness Evaluated',
        'evaluate_tooltip' => 'Evaluate',
        'evaluate_prompt' => '',
    ],

	'training_evaluate_tooltip' => 'Evaluate Training',
	'training_evaluate_prompt' => 'Are you sure you want to evaluate this training?',
	'effectiveness_evaluate_tooltip' => 'Evaluate Effectiveness',
	'effectiveness_evaluate_prompt' => 'Are you sure you want to evaluate effectiveness?',

	'reviews' => [
		'title'			=> 'Training Review',
		'title-helper'	=> 'Training Review Form',

		'review_of_meeting_expectations' => 'The training program met my expectations.',
		'review_of_application_of_acquired_information_at_work' => 'I am confident in applying the newly acquired information in my work.',
		'review_of_the_use_of_training_time' => 'The time allocated for training was used effectively.',
		'review_of_recommendations_for_other_employees' => 'I will certainly recommend this training to others employees.',
		'review_of_instructor_prepatation_to_conduct' => 'The instructor was perfectly prepared to conduct the training.',
		'review_of_local_and_technical_conditions' => 'The local and technical conditions were definitely good.',
		'review_of_overall_preparation' => 'The training was prepared very well in every respect.',
		'review_of_training_materials_and_their_use_at_work' => 'The training materials I received are of an appropriate standard and will certainly be helpful in my work.',
		'review_stronly_disagree' => 'Strongly Disagree',
		'review_disagree' => 'Disagree',
		'review_neutral' => 'Neutral',
		'review_agree' => 'Agree',
		'review_stronly_agree' => 'Strongly Agree',
		'review_comment' => 'Comment',
	],

	'evaluations' => [
		'title'			=> 'Effectiveness Evaluation',
		'title-helper'	=> 'Effectiveness Evaluation Form',

		'eval_yes'  => 'Yes',
		'eval_no'   => 'No',

		'evaluation_of_use_of_knowledge' => 'Was knowledge acquired during training used in my work?',
		'evaluation_of_use_of_knowledge_details_yes' => 'To what extent? How visible is the use of knowledge?',
		'evaluation_of_use_of_knowledge_details_no' => 'Why is the knowledge acquired during training not used?',

		'evaluation_of_need_for_further_training' => 'Is further training necessary in this area?',
		'evaluation_of_need_for_further_training_details_yes' => 'In what areas and to what extent?',
	],

    'validation'    => [
        'import-file-required' => 'Please upload a plain text file',
        'import-file-mimes' => 'Only csv or txt files are allowed',
        'import-file-max' => 'Maximum allowed size is 1MB',
    ],

];


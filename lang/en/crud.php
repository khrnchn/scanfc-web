<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'attendances' => [
        'name' => 'Attendances',
        'index_title' => 'Attendances List',
        'new_title' => 'New Attendance',
        'create_title' => 'Create Attendance',
        'edit_title' => 'Edit Attendance',
        'show_title' => 'Show Attendance',
        'inputs' => [
            'student_id' => 'Student',
            'classroom_id' => 'Classroom',
            'status' => 'Status',
        ],
    ],

    'classes' => [
        'name' => 'Classes',
        'index_title' => 'Classes List',
        'new_title' => 'New Class',
        'create_title' => 'Create Class',
        'edit_title' => 'Edit Class',
        'show_title' => 'Show Class',
        'inputs' => [
            'subject_id' => 'Subject',
            'section_id' => 'Section',
            'lecturer_id' => 'Lecturer',
            'name' => 'Name',
            'start_at' => 'Start At',
            'end_at' => 'End At',
        ],
    ],

    'faculties' => [
        'name' => 'Faculties',
        'index_title' => 'Faculties List',
        'new_title' => 'New Faculty',
        'create_title' => 'Create Faculty',
        'edit_title' => 'Edit Faculty',
        'show_title' => 'Show Faculty',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'lecturers' => [
        'name' => 'Lecturers',
        'index_title' => 'Lecturers List',
        'new_title' => 'New Lecturer',
        'create_title' => 'Create Lecturer',
        'edit_title' => 'Edit Lecturer',
        'show_title' => 'Show Lecturer',
        'inputs' => [
            'staff_id' => 'Staff Id',
            'user_id' => 'User',
            'faculty_id' => 'Faculty',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'phone_no' => 'Phone No',
        ],
    ],

    'subjects' => [
        'name' => 'Subjects',
        'index_title' => 'Subjects List',
        'new_title' => 'New Subject',
        'create_title' => 'Create Subject',
        'edit_title' => 'Edit Subject',
        'show_title' => 'Show Subject',
        'inputs' => [
            'name' => 'Name',
            'faculty_id' => 'Faculty',
        ],
    ],

    'students' => [
        'name' => 'Students',
        'index_title' => 'Students List',
        'new_title' => 'New Student',
        'create_title' => 'Create Student',
        'edit_title' => 'Edit Student',
        'show_title' => 'Show Student',
        'inputs' => [
            'matrix_id' => 'Matrix Id',
            'nfc_tag' => 'Nfc Tag',
            'user_id' => 'User',
            'faculty_id' => 'Faculty',
            'is_active' => 'Is Active',
        ],
    ],

    'sections' => [
        'name' => 'Sections',
        'index_title' => 'Sections List',
        'new_title' => 'New Section',
        'create_title' => 'Create Section',
        'edit_title' => 'Edit Section',
        'show_title' => 'Show Section',
        'inputs' => [
            'subject_id' => 'Subject',
            'name' => 'Name',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];

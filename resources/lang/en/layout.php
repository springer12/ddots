<?php

return [
    'footer_app' => 'Copyright © 2005-2016, Молодёжное научное общество "Q-BIT" <br>
                тех. поддержка: Н.А. Арзубов <br>
                При использовании материалов сайта ссылка на dots.org.ua обязательна.', //@todo
    'footer_main' => 'Copyright © 2005-2016, Молодёжное научное общество "Q-BIT" <br>
            тех. поддержка: Н.А. Арзубов <br>
            При использовании материалов сайта ссылка на dots.org.ua обязательна.',
    'footer_2' => '
            Copyright © 2005-:date, Молодёжное научное общество "Q-BIT" <br>
            тех. поддержка: Н.А. Арзубов <br>
            При использовании материалов сайта ссылка на dots.org.ua обязательна.',
    'description_main_1' => 'С 16 февраля 2016 тестирующая система DOTS доступна для преподавателей информатики Харькова
                        и Харьковской области. Теперь все, кто преподаёт программирование, сможет зарегистрировать в
                        системе своих учеников, объединять их в группы и проводить практикумы по программированию с
                        использованием тестирующей системы.',
    'description_main_2' => '          <b>Dots</b> - это тестирующая система для dots.org.ua, написаная на Python, sh и C и
                            интенсивно
                            использующая все возможности Docker контейнеров и Cgroup подсистемы ядра, запуская
                            компиляторы и
                            тестируя пользовательские решения в отдельных Docker контейнерах. Такой подход делает DDots
                            максимально гибкой и модульной системой. <br> <br>

                            Один DDots обрабатывает одно решение в единицу времени и предзагружает два решения в очередь
                            для
                            уменьшения задержек, связанных с сетью. Таким образом, для нагрузки нескольких ядер
                            рекомендуется запускать N контейнеров DDots (это делается автоматически, Makefile
                            автоматически
                            определяет количество доступных ядер и использует все возможности). <br><br>',
    'description_2' => 'Практикум по програмированию',
    'email_nickname' => 'Email / nickname',
    'password' => 'Password',
    'remember_me' => 'Remember Me',
    'forgot_password' => 'Forgot Your Password?',
    'latest_news' => 'Latest news',
    'supported_by' => 'Project was supported by',
    'all_sponsors' => 'All sponsors',
    'sub_teachers_mentors' => 'Subdomains teachers and mentors',
    'all_teachers_mentors' => 'All teachers and mentors',
    'all_subdomains' => 'All subdomains',
    'upgrade' => 'Upgrade',
    'update' => 'Update',
    'years_old' => 'Years old',
    'with_us' => 'with us',
    'day' => [
        'first_form' => 'day',
        'second_form' => 'days',
        'third_form' => 'days',
    ],
    'profession' => 'Profession',
    'place_of_study' => 'Place of study',
    'primary_language' => 'Primary language',
    'full_name' => 'Full Name',
    'nickname' => 'Nickname',
    'birthday' => 'Birthday',
    'programming_language' => 'Programming Language',
    'not_selected' => 'Not selected',
    'vk' => 'VK',
    'vk_link' => 'Link to vk profile',
    'fb' => 'Facebook',
    'fb_link' => 'Link to facebook profile',
    'email' => 'Email',
    'email_verification' => 'You will be sent a verification email.',
    'avatar' => 'Avatar',
    'description' => 'Description',
    'my_teachers' => 'My teachers',
    'my_teacher' => 'My teacher',
    'all_teachers' => 'All teachers',
    'request_is_sent' => 'request is sent',
    'actions' => 'Actions',
    'volumes' => 'Volumes',
    'date' => 'Date',
    'dots_root' => 'DOTS ROOT',
    'dots_caps' => 'DOTS',
    'reset' => 'Reset',
    'name' => 'Name',
    'cancel' => 'Cancel',
    'save' => 'Save',
    'id' => 'ID',
    'created_date' => 'Created Date',
    'updated_date' => 'Updated Date',
    'deleted_date' => 'Deleted Date',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'restore' => 'Restore',
    'error_page' => 'Be right back',
    'cancel_warn' => 'Are you sure you want to leave the page? The changes won\'t be saved.',
    'confirm_password' => 'Confirm Password',
    'leave_page' => 'Leave the page',
    'group' => [
        'create' => 'Create Group',
        'edit' => 'Edit Group',
        'add' => 'Add Group',
        'delete_warn' => 'Are you sure you want to delete this group from the system?',
        'restore_warn' => 'Are you sure you want to restore this group?',
    ],
    'volume' => 'Volume',
    'search' => 'Search',
    'teacher_requests_expended' => 'You have expended your allowed requests',
    'register_action' => 'Register',
    'ended' => 'ended'
];
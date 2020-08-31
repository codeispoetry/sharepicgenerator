<?php
namespace Deployer;

require 'recipe/common.php';
require 'recipe/rsync.php';


// Project name
set('application', 'develop.sharepicgenerator.de');

// Project repository
set('repository', 'git@github.com:codeispoetry/sharepicgenerator.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys 
set('shared_files', [
    'ini/config.ini',
    'passwords.php'
    ]);
set('shared_dirs', [
    'tmp',
    'persistent/user',
    ]);

// Writable dirs by web server 
set('writable_dirs', []);

set('rsync',[
    'exclude'      => [
        '.git',
        'deploy.php',
    ],
    'exclude-file' => 'deployment/exclude-list.txt',
    'include'      => [],
    'include-file' => false,
    'filter'       => [],
    'filter-file'  => false,
    'filter-perdir'=> false,
    'flags'        => 'rz', // Recursive, with compress
    'options'      => ['delete'],
    'timeout'      => 60,
]);

// Hosts
host('develop.sharepicgenerator.de')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->set('deploy_path','/var/www/develop.sharepicgenerator.de')
    ->set('rsync_src', 'code/dist')
    ->set('rsync_dest','{{release_path}}');


// Tasks
desc('Deploy sharepicgenerator');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'rsync',
    'deploy:shared',
    'deploy:writable',
   // 'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');



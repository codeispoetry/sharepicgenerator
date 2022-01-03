<?php
namespace Deployer;

require 'recipe/common.php';
require 'vendor/deployer/recipes/recipe/rsync.php';


// Project name
set('application', 'sharepicgenerator.de');

// Shared files/dirs between deploys
set('shared_files', [
    'ini/config.ini',
    'ini/passwords.php',
    'log/.htusers'
]);
set('shared_dirs', [
    'tmp',
    'persistent',
    'wordpress',
    'tenants/federal/gallery/img',
    'tenants/frankfurt/gallery/img',
    'tenants/federal/pictures/img',
    'tenants/frankfurt/pictures/img',
    'tenants/bw/pictures/img',
    'tenants/bw/gallery/img',
    'tenants/rlp/pictures/img',
    'tenants/rlp/gallery/img',
    'tenants/basic/pictures/img',
    'tenants/basic/gallery/img',
    'tenants/lsa/gallery/img',
    'tenants/lsa/gallery/img',
    'tenants/einigungshilfe/pictures/img',
    'tenants/einigungshilfe/gallery/img',
    'tenants/niedersachsen/pictures/img',
    'tenants/niedersachsen/gallery/img',
    'tenants/btw21/gallery/img',
    'tenants/btw21/pictures/img',
    'tenants/berlin/gallery/img',
    'tenants/berlin/pictures/img',
    'tenants/nrw/gallery/img',
    'tenants/nrw/pictures/img',
    'tenants/sh/gallery/img',
    'tenants/sh/pictures/img',

    'log/logs',
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
host('develop')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->user('tom')
    ->hostname('sharepicgenerator.de')
    ->set('deploy_path','/var/www/develop.sharepicgenerator.de')
    ->set('rsync_src', 'code/dist')
    ->set('rsync_dest','{{release_path}}');

host('production')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->user('tom')
    ->hostname('sharepicgenerator.de')
    ->set('deploy_path','/var/www/sharepicgenerator.de')
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
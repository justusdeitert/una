<?php
namespace Deployer;

require 'recipe/common.php';
require 'recipe/slack.php';

// Require all files in deployer folder
// ------------------------------------------->
foreach (new \DirectoryIterator(dirname(__FILE__) . '/deployer') as $fileinfo) {
    if (!$fileinfo->isDot()) {
        require $fileinfo->getPathname();
    }
}

// Uploads all files (and directories) from local machine to remote server.
// Overwrites existing files on server with updated local files and uploads new files.
// Locally deleted files are not deleted on server.
// deployer/sync-dirs.php
// ----------------->
set('sync_dirs', [
    dirname(__FILE__) . '/bedrock/web/app/uploads/' => '{{deploy_path}}/shared/bedrock/web/app/uploads/',
]);

// Configure Theme Path
set( 'theme_path', 'theme' );

// Project name
set('application', 'una-moehrke');

// Project repository
// set('branch', 'master');
set('repository', 'git@lab.justusdeitert.de:JD/una-moehrke.git');

// Number of releases to keep. -1 for unlimited releases. Default to 5.
set('keep_releases', 2);

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
set('shared_files', [
    'bedrock/.env',
    'bedrock/web/.htaccess'
]);

set('shared_dirs', [
    'bedrock/web/app/uploads'
]);

// Writable dirs by web server
// set('writable_dirs', []);
// set('allow_anonymous_stats', false);

set('default_stage', 'production');

// Hosts
host('justusdeitert.de')
    ->stage('staging')
    ->set('deploy_path', '~/una-moehrke.justusdeitert.de')
    ->set( 'sites', [
        'una-moehrke.main' => 'una-moehrke.justusdeitert.de',
    ]);

host('una-moehrke.de')
    ->stage('production')
    ->set('deploy_path', '~/una-moehrke.de')
    ->set( 'sites', [
        'una-moehrke.main' => 'una-moehrke.de',
    ]);

// Tasks
// https://deployer.org/docs/advanced/deploy-strategies.html
desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    // 'deploy:update_code',
    'upload:repository',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// after('deploy:update_code', 'npm:install');

after('upload:repository', 'upload:dist'); // New Upload Task with local production Build for Server without Node.js!!
after('upload:repository', 'composer:install');

// Push and Pull DB Commands!
// ----------------->
desc('Push Project DB & Uploads Folder');
task('push', [
    'push:db',
    'push:files'
]);

desc('Pull Project DB & Uploads Folder');
task('pull', [
    'pull:db',
    'pull:files'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Set Deployer Recipe Slack Messages
// ------------------------>
// https://deployer.org/recipes/slack.html
// Username Variable is From Deployer, not from Slack Receipe
set('user', 'Justus Deitert'); // TODO: set username from git: https://deployer.org/doc/*s/configuration
// -------------------------->
set('slack_webhook', 'SLACK_WEBHOOK_REMOVED');
set('slack_title', ''); // We don't need to show title in this channel
set('slack_text', '_{{user}}_ deploying `{{branch}}` to *{{target}}*');
set('slack_success_text', 'Deploy to *{{target}}* successful');
set('slack_success_text', 'Successfully Deployed to *{{application}}.{{target}}*');
set('slack_failure_text', 'Deploy to *{{target}}* failed');

// Fire Slack Notifications on
// Only Notifies if deployment was Successfull
// ------------->
// before('deploy', 'slack:notify');
after('success', 'slack:notify:success');
// after('deploy:failed', 'slack:notify:failure');

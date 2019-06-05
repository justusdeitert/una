<?php

namespace Deployer;

// Set Binarys for Composer install

// set('bin/php', function () {
//     return 'php';
//     // return run('which php');
// });
//
// set('bin/composer', function () {
//     // return 'composer';
//     return run('which composer');
// });
//
// // Important for Production
// set('install_option', 'install --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader');
//
// // Adding tasks
// desc('Installing vendors');
// task('composer:install', function () {
//     writeln('Installing Composer for Bedrock: {{release_path}}/bedrock');
//     run('cd {{release_path}}/bedrock && {{bin/composer}} {{install_option}}');
//
//     writeln('Installing Composer for Sage Theme: {{release_path}}/{{theme_path}}');
//     run('cd {{release_path}}/{{theme_path}} && {{bin/composer}} {{install_option}}');
// });

namespace Deployer;

set('bin/composer', function () {
    return run('which composer');
});

desc('Install Composer packages in Bedrock');
task('composer:install:bedrock', function () {
    writeln('Install Composer packages in Bedrock');
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/bedrock/vendor ]')) {
            run('cp -R {{previous_release}}/bedrock/vendor {{release_path}}/bedrock');
        }
    }
    run("cd {{release_path}}/bedrock && {{bin/composer}} update");
});

desc('Install Composer packages in Sage');
task('composer:install:sage', function () {
    writeln('Install Composer packages in Sage');
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/sage/vendor ]')) {
            run('cp -R {{previous_release}}/sage/vendor {{release_path}}/sage');
        }
    }
    run("cd {{release_path}}/sage && {{bin/composer}} update");
});

desc('Composer install');
task('composer:install', [
    'composer:install:bedrock',
    'composer:install:sage',
]);

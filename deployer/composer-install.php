<?php

namespace Deployer;

set('bin/composer', function () {
    // return run('which composer');
    return 'php ~/composer.phar';
});

// TODO: Define Multiple Array for Composer Paths in the Future!
// -------------------------------->
desc('Install Composer packages in Bedrock');
task('composer:install:bedrock', function () {
    writeln('Install Composer packages in Bedrock');
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/bedrock/vendor ]')) {
            run('cp -R {{previous_release}}/bedrock/vendor {{release_path}}/bedrock');
        }
    }
    run("cd {{release_path}}/bedrock && {{bin/composer}} install");
});

desc('Install Composer packages in Sage');
task('composer:install:sage', function () {
    writeln('Install Composer packages in Sage');
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/sage/vendor ]')) {
            run('cp -R {{previous_release}}/sage/vendor {{release_path}}/sage');
        }
    }
    run("cd {{release_path}}/sage && {{bin/composer}} install");
});

desc('Composer install');
task('composer:install', [
    'composer:install:bedrock',
    'composer:install:sage',
]);

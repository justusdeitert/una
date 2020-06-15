<?php

namespace Deployer;

// set('bin/composer', function () {
//     // return run('which composer');
//     return 'php ~/composer.phar';
// });
//
// // TODO: Define Multiple Array for Composer Paths in the Future!
// // -------------------------------->
// desc('Install Composer packages in Bedrock');
// task('composer:install:bedrock', function () {
//     writeln('Install Composer packages in Bedrock');
//
//     // TODO: Makes Error
//     // ------------------------------->
//     // if (has('previous_release')) {
//     //     if (test('[ -d {{previous_release}}/bedrock/vendor ]')) {
//     //         run('cp -R {{previous_release}}/bedrock/vendor {{release_path}}/bedrock');
//     //     }
//     // }
//     run("cd {{release_path}}/bedrock && {{bin/composer}} install");
// });
//
// desc('Install Composer packages in Sage');
// task('composer:install:sage', function () {
//     writeln('Install Composer packages in Sage');
//
//     // if (has('previous_release')) {
//     //     if (test('[ -d {{previous_release}}/sage/vendor ]')) {
//     //         run('cp -R {{previous_release}}/sage/vendor {{release_path}}/sage');
//     //     }
//     // }
//     run("cd {{release_path}}/sage && {{bin/composer}} install");
// });
//
// desc('Composer install');
// task('composer:install', [
//     'composer:install:bedrock',
//     'composer:install:sage',
// ]);

namespace Deployer;

desc('Install Composer packages in Bedrock');
task('composer:install', function () {

    foreach (get('composer_paths') as $key => $value) {

        // if (has('previous_release')) {
        //     if (test("[ -d {{previous_release}}/{$value}/vendor ]")) {
        //         writeln("Copy Composer Packages in from {{previous_release}}/{$value}/vendor to {{release_path}}/{$value}");
        //         run("cp -R {{previous_release}}/{$value}/vendor {{release_path}}/{$value}", ['timeout' => 600]);
        //     }
        // }

        // writeln("Update Composer Packages in {{release_path}}/{$value}");
        // run("cd {{release_path}}/{$value} && {{bin/composer}} update", ['timeout' => 600]);

        writeln("Install Composer Packages in {$value}");
        run("cd {{release_path}}/{$value} && {{bin/composer}} install", ['timeout' => 600]);
    }
});

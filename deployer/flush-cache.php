<?php

namespace Deployer;

// set('bin/npm', function () {
//     return run('which npm');
// });

desc('Flush Cache after update');
task('flush_cache', function () {

    // ----------------------------------->
    // Installing Themes Node Modules
    // ----------------------------------->
    writeln('Flushing uploads/cache... {{deploy_path}}');
    run("cd {{deploy_path}}/shared/bedrock/web/app/uploads && rm -R cache");

    // ----------------------------------->
    // Theme - Lichtfee
    // ----------------------------------->
    // writeln('run npm build production in {{release_path}}/{{themes_path}}/{{theme_name}}');
    // run("cd {{release_path}}/{{themes_path}}/{{theme_name}} && {{bin/npm}} run build:production");

    // ----------------------------------->
    // Theme - KP-Business-Solutions
    // ----------------------------------->
    // run("cd {{release_path}}/{{themes_path}}/kp-business-solutions && {{bin/npm}} run build:production");
    // writeln('run npm build production in {{release_path}}/{{themes_path}}/kp-business-solutions');
});


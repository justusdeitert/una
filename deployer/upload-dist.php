<?php

namespace Deployer;

// Build Production Local
// ------------------->
task('build:production', function () {
    run('cd ./theme && yarn build:production');
})->local();

// Upload Dist!
// ------------------->
task('upload:dist', function () {
    writeln('Upload: ' . __DIR__ . "/theme/dist");
    writeln('Destination: ' . "{{release_path}}/theme/dist");
    upload(__DIR__ . "/theme/dist", '{{release_path}}/theme');
});

task('upload', [
    'build:production',
    'upload:dist'
]);

<?php

namespace Deployer;

// Build Production Local
// ------------------->
task('build:production', function () {
    run('cd {{local_path}}/theme && yarn build:production');
})->local();

// Upload Dist!
// ------------------->
task('upload:dist_folder', function () {
    writeln('Upload: {{local_path}}/theme/dist');
    writeln('Destination: ' . "{{release_path}}/theme/dist");
    upload('{{local_path}}/theme/dist', '{{release_path}}/theme');
});

task('upload:dist', [
    'build:production',
    'upload:dist_folder'
]);

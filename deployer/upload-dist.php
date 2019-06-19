<?php

namespace Deployer;

// Build Production Local
// ------------------->
task('build:production', function () {
    run('cd {{local_path}}/sage && yarn build:production');
})->local();

// Upload Dist!
// ------------------->
task('upload:dist_folder', function () {
    writeln('Upload: {{local_path}}/sage/dist');
    writeln('Destination: ' . "{{release_path}}/sage/dist");
    upload('{{local_path}}/sage/dist', '{{release_path}}/sage');
});

task('upload:dist', [
    'build:production',
    'upload:dist_folder'
]);

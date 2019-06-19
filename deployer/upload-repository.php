<?php

namespace Deployer;

// Build Production Local
// ------------------->
task('zip:repository', function () {
    // http://gitready.com/intermediate/2009/01/29/exporting-your-repository.html
    run('cd {{local_path}} && git archive HEAD --format=zip > release.zip');
})->local();

// Upload Repository
// ------------------->
task('upload:repository_zip', function () {
    // writeln('Upload: ' . __DIR__ . '/release.zip');
    writeln('Upload: {{local_path}}/release.zip');
    writeln('Destination: {{release_path}}/release.zip');
    upload("{{local_path}}/release.zip", '{{release_path}}');
});

// Unzip Repository!
task('unzip:repository_zip', function () {
    writeln('Unzip: ' . "{{release_path}}/release.zip");
    run('cd {{release_path}} && unzip -o release.zip');
    run('cd {{release_path}} && rm release.zip');
});

task('remove:zip', function () {
    // http://gitready.com/intermediate/2009/01/29/exporting-your-repository.html
    run('cd {{local_path}} && rm release.zip');
})->local();

task('upload:repository', [
    'zip:repository',
    'upload:repository_zip',
    'unzip:repository_zip',
    'remove:zip'
]);

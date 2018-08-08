#!/bin/bash

# v1.0.0, v1.5.2, etc.
versionLabel=v$1

# establish branch and tag name variables
devBranch=develop
masterBranch=master
releaseBranch=master

# create the release branch from the -develop branch
git checkout $releaseBranch

versionFile="VERSION"

# find version number assignment ("= v1.5.5" for example)
# and replace it with newly specified version number
echo "$versionLabel" > $versionFile

git merge --no-ff --no-commit $devBranch

git add -f VERSION CHANGELOG.md

# build codebase
grunt --force

# cd web/sites/all/libraries/mgmt-api-php-sdk
# composer install
# cd ../../../../../

# Package for deployment
grunt package

rm -rf web

mv build/packages/package web

git add -f web

mkdir -p web/sites/default/files
rm -rf web/sites/default/files
cd web/sites/default/
ln -s ../../../files/drupal/default/public files
cd ../../../
git add -f web/sites/default/files

git commit -am "chore(release): Build $versionLabel"

# merge release branch with the new version number into master
# git checkout $masterBranch
# git merge --squash $releaseBranch
#
# git commit -m "chore(release): Release $versionLabel"

# merge release branch with the new version number back into develop
git checkout $devBranch

# remove release branch
# git branch -D $releaseBranch

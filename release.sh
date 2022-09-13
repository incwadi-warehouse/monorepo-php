#!/bin/bash

PROJECTS="extra-bundle api-bundle"
TMP_DIR="/tmp/test-split"

if [ "$1" == "" ];
then
  echo -e "\e[31mNo tag submitted!\e[0m"

  exit 1
fi

if [[ $(git status -s) ]];
then
  echo -e "\e[31mGit repo has uncommitted changes.\e[0m"
  git status -s;

  exit 1
fi

VERSION=$1

# Tag the project
echo -e "\e[34mTag the project\e[0m"

git tag -a "v${VERSION}" -m "v${VERSION}";
git push origin --follow-tags

# Tag the components
echo -e "\e[34mTag the components\e[0m"

for PROJECT in $PROJECTS
do
  REPO="git@github.com:abaldeweg/$PROJECT.git"

  echo -e "\e[34m$REPO\e[0m"

  rm -rf $TMP_DIR;
  mkdir $TMP_DIR;

  (
    cd $TMP_DIR || exit 1;

    git clone $REPO .

    git tag -a "v${VERSION}" -m "v${VERSION}";
    git push origin --follow-tags
  )
done

echo -e "\e[32mReleased version $VERSION!\e[0m"

exit 0

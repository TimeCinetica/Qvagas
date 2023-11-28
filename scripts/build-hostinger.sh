#!/bin/bash

# Prepare files
dest="build/src"

echo "Cleaning older files..."
rm -rf $dest
rm -f build/*.zip

echo "Coping files..."
mkdir -p $dest/app

cp -r app/* $dest/app
cp -r bootstrap $dest
cp -r config $dest
cp -r database $dest
cp -r public $dest
cp -r resources $dest
cp -r routes $dest
if [[ "$1" == "vendor" ]]; then 
    cp -r vendor $dest 
fi
cp artisan $dest
cp composer.json $dest
cp composer.lock $dest
cp server.php $dest
cp webpack.mix.js $dest
cp .htaccess $dest
cp package.json $dest

# Zip
echo "Zipping files..."
version=$(grep -oP '(?<="version": ")[^"]*' ./package.json)
jar -cMf build/qvagas-plataforma-$version.zip build/src/

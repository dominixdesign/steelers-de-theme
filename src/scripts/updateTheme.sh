cd ../src/

rm -rf steelers-de-theme/

# checkout the latest theme files
git clone https://github.com/dominixdesign/steelers-de-theme.git

cd steelers-de-theme/src/scripts/

# copy theme files at the right position
node copyFiles.js

cd ../../../../

vendor/bin/contao-console contao:maintenance-mode enable
composer dump-autoload
composer install -o
rm -rf var/cache/prod
vendor/bin/contao-console cache:clear --no-warmup
vendor/bin/contao-console cache:warmup
vendor/bin/contao-console contao:maintenance-mode disable

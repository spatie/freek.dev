@setup
$branch = 'main';
$server = "161.35.192.60";
$userAndServer = 'forge@'. $server;
$repository = "spatie/freek.dev";
$baseDir = "/home/forge/freek.dev";
$releasesDir = "{$baseDir}/releases";
$persistentDir = "{$baseDir}/persistent";
$currentDir = "{$baseDir}/current";
$newReleaseName = date('Ymd-His');
$newReleaseDir = "{$releasesDir}/{$newReleaseName}";
$user = get_current_user();
echo $userAndServer;
@endsetup

@servers(['local' => '127.0.0.1', 'remote' => $userAndServer])

@macro('deploy')
startDeployment
cloneRepository
runComposer
generateAssets
updateSymlinks
optimizeInstallation
backupDatabase
migrateDatabase
blessNewRelease
cleanOldReleases
finishDeploy
@endmacro

@macro('deploy-code')
deployOnlyCode
@endmacro

@task('startDeployment', ['on' => 'local', 'emoji' => '🏃'])
git checkout {{ $branch }}
git pull origin {{ $branch }}
@endtask

@task('cloneRepository', ['on' => 'remote', 'emoji' => '🌀'])
[ -d {{ $releasesDir }} ] || mkdir {{ $releasesDir }};
[ -d {{ $persistentDir }} ] || mkdir {{ $persistentDir }};
[ -d {{ $persistentDir }}/uploads ] || mkdir {{ $persistentDir }}/uploads;
[ -d {{ $persistentDir }}/admin-uploads ] || mkdir {{ $persistentDir }}/admin-uploads;
[ -d {{ $persistentDir }}/storage ] || mkdir {{ $persistentDir }}/storage;
[ -d {{ $persistentDir }}/storage/avatars ] || mkdir {{ $persistentDir }}/storage/avatars;

cd {{ $releasesDir }};

mkdir {{ $newReleaseDir }};

git clone --depth 1 git@github.com:{{ $repository }} --branch {{ $branch }} {{ $newReleaseName }}

cd {{ $newReleaseDir }}
git config core.sparsecheckout true
echo "*" > .git/info/sparse-checkout
echo "!storage" >> .git/info/sparse-checkout
echo "!public/build" >> .git/info/sparse-checkout
git read-tree -mu HEAD

cd {{ $newReleaseDir }}
echo "{{ $newReleaseName }}" > public/release-name.txt
@endtask

@task('runComposer', ['on' => 'remote', 'emoji' => '🚚'])
cd {{ $newReleaseDir }};
ln -nfs {{ $baseDir }}/.env .env;

cd {{ $newReleaseDir }};
ln -nfs {{ $baseDir }}/auth.json auth.json;
composer install --prefer-dist --no-scripts --no-dev -q -o;
@endtask

@task('generateAssets', ['on' => 'remote', 'emoji' => '🌅'])
cd {{ $newReleaseDir }};
npm ci --audit false
npm run build
rm -rf node_modules
@endtask

@task('updateSymlinks', ['on' => 'remote', 'emoji' => '🔗'])
rm -rf {{ $newReleaseDir }}/storage;
cd {{ $newReleaseDir }};
ln -nfs {{ $baseDir }}/persistent/storage storage;

rm -rf {{ $newReleaseDir }}/public/uploads;
cd {{ $newReleaseDir }};
ln -nfs {{ $baseDir }}/persistent/uploads public/uploads;

rm -rf {{ $newReleaseDir }}/public/admin-uploads;
cd {{ $newReleaseDir }};
ln -nfs {{ $baseDir }}/persistent/storage/admin-uploads public/admin-uploads;

rm -rf {{ $newReleaseDir }}/public/avatars;
cd {{ $newReleaseDir }};
ln -nfs {{ $baseDir }}/persistent/storage/avatars public/avatars;

ln -nfs {{ $baseDir }}/persistent/fonts/884760 {{ $newReleaseDir }}/public/fonts/884760;
@endtask

@task('optimizeInstallation', ['on' => 'remote', 'emoji' => '✨'])
cd {{ $newReleaseDir }};
php artisan clear-compiled;
@endtask

@task('backupDatabase', ['on' => 'remote', 'emoji' => '📀'])
cd {{ $newReleaseDir }}
php artisan backup:run
@endtask

@task('migrateDatabase', ['on' => 'remote', 'emoji' => '🙈'])
cd {{ $newReleaseDir }};
php artisan migrate --force;
@endtask

@task('blessNewRelease', ['on' => 'remote', 'emoji' => '🙏'])
ln -nfs {{ $newReleaseDir }} {{ $currentDir }};
cd {{ $newReleaseDir }}
php artisan horizon:terminate
php artisan config:clear
php artisan view:clear
php artisan cache:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan event:cache
php artisan responsecache:clear
php artisan cloudflare:purge-cache

sudo service php8.5-fpm restart
sudo supervisorctl restart all
php artisan schedule:sync
php artisan health:check
@endtask

@task('cleanOldReleases', ['on' => 'remote', 'emoji' => '🚾'])
cd {{ $releasesDir }}
ls -dt {{ $releasesDir }}/* | tail -n +4 | xargs -d "\n" sudo chown -R forge .;
ls -dt {{ $releasesDir }}/* | tail -n +4 | xargs -d "\n" rm -rf;
@endtask

@task('purgeCloudflareCache', ['on' => 'remote', 'emoji' => '🌐'])
cd {{ $currentDir }}
php artisan cloudflare:purge-cache
@endtask

@task('finishDeploy', ['on' => 'local', 'emoji' => '🚀'])
echo "Application deployed!"
@endtask

@task('deployOnlyCode', ['on' => 'remote', 'emoji' => '💻'])
cd {{ $currentDir }}
git pull origin {{ $branch }}
php artisan config:clear
php artisan view:clear
php artisan cache:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan event:cache
php artisan responsecache:clear
php artisan cloudflare:purge-cache
php artisan horizon:terminate
sudo service php8.5-fpm restart
php artisan health:check
php artisan schedule:sync
@endtask

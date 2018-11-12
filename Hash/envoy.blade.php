@servers(['web' => ['deploy@proj309-ad-02.misc.iastate.edu']])

@setup
	$release = date('YmdHis');
	$repository = 'git@git.linux.iastate.edu:cs309/Fall2018/AD_2_HashPages.git';
	$releases = '/vwh/proj309-ad-02.misc.iastate.edu/projects';
	$root = '/vwh/proj309-ad-02.misc.iastate.edu';
	$clone = $releases .'/'. $release;
	$app = $releases .'/'. $release . '/Hash';
@endsetup

@story('deploy')
	clone_repository
	run_composer
	update_symlinks
@endstory

@task('clone_repository')
	echo 'Cloning repository'
	[ -d {{ $releases }} ] || mkdir {{ $releases }}
	git clone --depth 1 {{ $repository }} {{ $clone }}
@endtask

@task('run_composer')
	echo "Starting deployment ({{ $release }})"
	cd {{ $app }}
	composer install --prefer-dist --no-scripts --no-ansi --no-dev -o
@endtask

@task('update_symlinks')
	echo "Linking storage directory"
	rm -rf {{ $app }}/storage
	ln -nfs {{ $root }}/storage {{ $app }}/storage

	echo 'Linking .env file'
	ln -nfs {{ $root }}/.env {{ $app }}/.env

	echo 'Linking current release'
	ln -nfs {{ $app }}/public {{ $root }}/www
@endtask
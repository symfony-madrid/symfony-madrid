#-----------------------------------------------------------
# General
#-----------------------------------------------------------

set :application, 'Symfony Madrid'

set :domain,      'root@server2.desarrolla2.com'
set :user,        'root'
set :deploy_to,   '/var/www/symfony-madrid.es'
set :branch,      'master'

role :web,                              domain
role :app,                              domain
role :db, domain,                       :primary => true

set :keep_releases,                     1
set :use_composer,                      true
set :dump_assetic_assets,               true
set :model_manager,                     'doctrine'
set :deploy_via,                        :remote_cache
set :vendors_mode,                      'reinstall'

set :php_bin,                           '/usr/bin/php'
set :composer_bin,                      '/usr/local/bin/composer'

#-----------------------------------------------------------
# Users and permission
#-----------------------------------------------------------

set :webserver_user,                    'www-data'
set :group_writable,                    true
set :permission_method,                 :chown
set :use_sudo,                          false
set :writable_dirs,                     ['app/cache', 'app/logs']
set :shared_files,                      ['app/config/parameters.yml','app/config/security.yml']
set :shared_children,                   [ app_path + '/logs']

ssh_options[:forward_agent] =           true

after "deploy:finalize_update" do
  run "sudo chown -R www-data:www-data #{latest_release}/#{cache_path}"
  run "sudo chown -R www-data:www-data #{latest_release}/#{log_path}"
  run "sudo chmod -R 777 #{latest_release}/#{cache_path}"
end

#-----------------------------------------------------------
# Git
#-----------------------------------------------------------

set :repository,                        'git@github.com:desarrolla2/symfony-madrid.git'
set :scm,                               :git

#-----------------------------------------------------------
# Copy vendors
#-----------------------------------------------------------

before 'symfony:composer:install', 'composer:copy_vendors'
before 'symfony:composer:update', 'composer:copy_vendors'

namespace :composer do
  task :copy_vendors, :except => { :no_release => true } do
    puts "--> Copy vendor file from previous release"
    run "vendorDir=#{current_path}/vendor; if [ -d $vendorDir ] || [ -h $vendorDir ]; then cp -a $vendorDir #{latest_release}/vendor; fi;"
    puts "finish"
  end
end

#-----------------------------------------------------------
# Clean
#-----------------------------------------------------------
after "deploy:update", "deploy:cleanup"

after 'deploy:restart' do   
    run 'varnishadm -S /etc/varnish/secret -T localhost:6082 "ban req.http.host == symfony-madrid.es"'
end

#-----------------------------------------------------------
# Output
#-----------------------------------------------------------

# IMPORTANT = 0
# INFO      = 1
# DEBUG     = 2
# TRACE     = 3
# MAX_LEVEL = 3
logger.level = Logger::MAX_LEVEL
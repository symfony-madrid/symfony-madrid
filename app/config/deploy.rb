set :application,           'Symfony Madrid'
set :domain,                'root@server2.desarrolla2.com'
set :deploy_to,             '/var/www/symfony-madrid.es'

set :php_bin,               '/usr/bin/php'
set :keep_releases,         15
set :use_composer,          true

set :permission_method,     ':chmod'
set :user,                  'www-data'
set :webserver_user,        'www-data'
set :group_writable,        true

set :repository,            'git@github.com:desarrolla2/symfony-madrid.git'
set :scm,                   :git
set :scm_command, "/usr/bin/git"
set :deploy_via,            :remote_cache

set :dump_assetic_assets,   true

set :writable_dirs,         ['app/cache', 'app/logs']
set :shared_files,          ['app/config/parameters.yml', 'app/config/security.yml']
set :shared_children,       [ app_path + '/logs']

set :model_manager,         'doctrine'
set :use_sudo,              false

ssh_options[:forward_agent] = true

role :web,                  domain
role :app,                  domain
role :db,                   domain, :primary => true

before 'symfony:composer:install', 'composer:copy_vendors'
before 'symfony:composer:update', 'composer:copy_vendors'

namespace :composer do
  task :copy_vendors, :except => { :no_release => true } do
    pretty_print "--> Copy vendor file from previous release"

    run "vendorDir=#{current_path}/vendor; if [ -d $vendorDir ] || [ -h $vendorDir ]; then cp -a $vendorDir #{latest_release}/vendor; fi;"
    puts_ok
  end
end

logger.level = Logger::IMPORTANT
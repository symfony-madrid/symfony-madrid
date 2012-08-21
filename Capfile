load 'deploy' if respond_to?(:namespace) # cap2 differentiator
Dir['vendor/**/Resources/recipes/*.rb'].each { |bundle| load(bundle) }
load Gem.find_files('symfony2.rb').last.to_s

after 'deploy:restart' do
  run 'varnishadm -S /etc/varnish/secret -T localhost:6082 "ban req.http.host == symfony-madrid.es"'
end

load 'app/config/deploy'
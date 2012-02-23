set :application, "Macau Social Entreprise"
set :domain,      "skyveostudio.com"
set :deploy_to,   "/Users/marcoleong/www/www.mgcse.org.mo"
set :app_path,    "app"

set :repository,  "skyveostudio.com:/git/www.mgcse.org.mo.git"
set :scm,         :rsync_with_remote_cache
set :use_sudo,     false

# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, `subversion` or `none`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Rails migrations will run

set  :keep_releases,  3

set :app_path, "app"
set :web_path, "web"
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     ["vendor"]

set :user, "marcoleong"

set :update_vendors, true


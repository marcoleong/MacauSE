set :application, "Macau Social Entreprise"
set :domain,      "skyveostudio.com"
set :deploy_to,   "/Users/marcoleong/www/www.mgcse.org.mo"
set :app_path,    "app"

set :repository,  "skyveostudio.com:/git/www.mgcse.org.mo.git"
set :scm,         :git
set :use_sudo,     false

# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, `subversion` or `none`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Rails migrations will run

set  :keep_releases,  3

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     ["vendor"]


set :update_vendors, false


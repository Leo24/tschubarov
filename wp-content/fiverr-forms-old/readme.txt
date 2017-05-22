1. copy templates from folder twenty-template to you theme.
2. create page with permalink 'fiverr' 
3. assign this page to template 'Fiverr Form'
4. Create any form on the page /wp-admin/admin.php?page=fiverr-forms
5. on page /wp-admin/admin.php?page=admin-fiverr-orders you will see the links to this page with this form.


to run checks of links you should first install gearman daemon http://gearman.org/getting-started/
you need to run it as "gearmand" for test and "gearman -d" as daemon
you need to install gearman pecl_extension http://php.net/manual/en/gearman.installation.php
you need to install https://github.com/brianlmoon/GearmanManager, just clone the code and use next config for this project

=======curl_config.ini==========
[GearmanManager]

; workers can be found in this dir
; separate multiple dirs with a comma
; multiple dirs only supported by pecl workers
worker_dir=/var/www/html/youngceaser.com/youngceaser_tschubarov/wp-content/plugins/fiverr-forms/workers

; All workers in worker_dir will be loaded
include=*

; 10 workers will do all jobs
count=20

; Each job will have minimum 1 worker
; that does only that job
dedicated_count=1

; Workers will only live for 1 hour
max_worker_lifetime=300

; Reload workers as new code is available
auto_update=1

; Timeout n seconds for all jobs before work is reissued to another worker
timeout=300

log_file=/var/www/html/youngceaser.com/youngceaser_tschubarov/wp-content/plugins/fiverr_curl.log




=======end curl_config.ini==========

gearman manager will run workers from fiver plugin folder "/var/www/html/youngceaser.com/youngceaser_tschubarov/wp-content/plugins/fiverr-forms/workers". change it if needed
run gearmanager like this "php bin/pecl_manager.php -c curl_config.ini -d" to run it in daemon mode

To run regularry task for backlinks checking you need toset cronjob for root 
"*/1 * * * * /usr/bin/php /var/www/html/youngceaser.com/youngceaser_tschubarov/wp-content/plugins/fiverr-forms/backlinks-checker/checker.php >/dev/null 2>&1" 
to run client for gearman

================================================


to be sure in correct file rights make thiese commands in the console

chown -R youngcaesar:apache /var/www/html/youngceaser.com/youngceaser_tschubarov/wp-content/plugins/fiverr-forms
chmod -R g+w /var/www/html/youngceaser.com/youngceaser_tschubarov/wp-content/plugins/fiverr-forms
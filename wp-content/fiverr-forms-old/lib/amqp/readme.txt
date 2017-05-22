STEPS TO RUN
============
//code based on http://mac-blog.org.ua/php-amqplib/

1) install rabbitmq and run it(if it has management interface - will be visible http://localhost:15672/)
2) install redis and make sure it's working(you can install redis-stat to see what was added)
3) ech_send_mass.php send 150+ urls to check - example client
4) echo_worker is example worker - you can run few in parallel - it will take url, check it and put result to redis(you can do to database in another case, if needed)

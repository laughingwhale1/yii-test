To start up:
1. _docker compose up -d_
2. docker-compose exec php bash
3. composer install
4. Run migrations: _php yii migrate_. If you have problem like this:
   ##### _/usr/bin/env: 'php\r': No such file or directory
   ##### /usr/bin/env: use -[v]S to pass options in shebang lines_
   ### Try running: _sed -i 's/\r$//' yii_ and try again

5. Seed database: _php yii seed/basic_ 
6. Generate schedule: _php yii schedule-generator/generate_

7. Before test, run: _php tests/bin/yii migrate_
8. Then run test: _vendor/bin/codecept run functional SeedControllerCest_

9. To illustrate the result: run: _php yii schedule-generator/draw_
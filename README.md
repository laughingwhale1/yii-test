To start up:
1. _docker compose up -d_
2. _docker ps && docker exec -it **basic-php-1** bash_
3. Seed database: 
- _yii seed/basic_ 
4. Generate schedule: 
- _yii schedule-generator/generate_

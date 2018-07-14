# Как запустить

1. git clone `https://github.com/dionisiy13/testFreelancehunt.git {folder}`

2. выполнить `composer update`

3. импорт файла /db.sql в бд

4. настроить `/config/local.config.php`

5. импортировать данные с файла в дб в консоли `php index.php sync`

6. наверное тесты запустить

Настроить юрл проекта в файлах ` /tests/*.yml`
    
приемочные тесты - `.\vendor\bin\codecept run acceptance --steps`

юнит тесты - `.\vendor\bin\codecept run unit --steps`

апи тесты - `.\vendor\bin\codecept run api --steps`
 
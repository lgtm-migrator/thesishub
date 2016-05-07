# ThesisHub 

Power by Yii2 

# DIRECTORY STRUCTURE

```
  assets/             contains assets definition
  commands/           contains console commands (controllers)
  config/             contains application configurations
  controllers/        contains Web controller classes
  mail/               contains view files for e-mails
  models/             contains model classes
  runtime/            contains files generated during runtime
  tests/              contains various tests for the basic application
  vendor/             contains dependent 3rd-party packages
  views/              contains view files for the Web application
  web/                contains the entry script and Web resources
```

# Installation

1. Step 1
    ```
    git clone https://github.com/duyetdev/thesis-manager-yii2.git thesis
    cd thesis/basic 
    
    sudo apt-get install php5 php5-mcrypt php5-curl mysql-server phpmyadmin 
    
    # Run self-buid PHP server 
    php -S 0.0.0.0:8888
    ```
    
    Go: [http://0.0.0.0:8888/requirements.php](http://0.0.0.0:8888/requirements.php)
    
    `sudo apt-get install php5-***`

2. Step 2
  Import DB 

3. Install composer package
  
  ```sh
  sudo chmod +x ./composer.phar
  php ./composer.phar install 
  ```
4. Start server 

  ```sh
  php ./yii serve 
  php ./yii -h # for help
  ```

# Note

- How to write migration: http://www.yiiframework.com/doc-2.0/guide-db-migrations.html

- Run migrate 

  ```sh
  php ./yii migrate
  ```
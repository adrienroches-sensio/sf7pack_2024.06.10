Install
=======

Clone this repository

```bash
$ git clone git@github.com:adrienroches-sensio/sf7pack_2024.06.10.git
$ cd ./sf7pack_2024.06.10
```

Run the following commands :

```bash
$ symfony composer install
$ symfony console importmap:install
$ symfony console doctrine:migration:migrate -n
$ symfony console doctrine:fixtures:load -n
```

Then start the server with :

```bash
$ symfony serve -d
```

Then you can log in with :
* user / user [ROLE_USER]
* website / website [ROLE_WEBSITE]
* volunteer / volunteer [ROLE_VOLUNTEER]
* organizer / organizer [ROLE_ORGANIZER]
* admin / admin [ROLE_ADMIN]

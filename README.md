Demo Application
-----------------------------

- A simple Laravel app demonstrating a RESTFUL users API, with Pest tests.
```bash
260412.120135 { pd@p561:..demo1 } main »
$ sail artisan test

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                                                                                                                                                             0.01s

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                                                                                                                                                 0.42s

   PASS  Tests\Feature\UsersApiTest
  ✓ api: users.list → it returns results                                                                                                                                                                                                          0.04s
  ✓ api: users.show → it returns user object                                                                                                                                                                                                      0.02s
  ✓ api: users.store → it creates user object                                                                                                                                                                                                     0.05s
  ✓ api: users.update → it updates user object                                                                                                                                                                                                    0.03s
  ✓ api: users.destroy → it deletes user object                                                                                                                                                                                                   0.03s

  Tests:    7 passed (23 assertions)
  Duration: 0.69s
```



Development Environment
-----------------------------

- This dev env utilizes the Laravel Sail wrapper of docker-compose to run a PostgreSQL and Web Server
- It will generate local/untracked `.env` and `compose.yaml` files.


Installation 
-----------------------------
1. Install [Docker Desktop](https://www.docker.com/products/docker-desktop)
1. The following BASH command's are intended for MacOS terminal or Windows WSL Terminal (Do NOT use Windows Powershell or VsCode)
1. Make sure Windows does not convert new lines
    ```bash
    git config --global core.autocrlf false
    ```
1. Clone repo and enter new directory
    ```bash
    PROJECT="demo_"`date +'%y%m%d'` 
    git clone git@github.com:phdsrc/demo1.git "$PROJECT" && cd "$PROJECT"
    ```

1. Source the aliases and init functions
    ```bash
    source _helpers
    ```
1. Use x.php84 function to pull packages and init ENV
    ```bash
    x.php84 composer run dev-prep
    ```
1. Bring the containers UP
    ```bash
    sail up -d
    ```
1. Initialize database and npm
    ```bash
    sail composer run dev-install
    ```
1. Run tests
    ```bash
    sail artisan test
    ```
1. Web frontend
    ```bash
    http://localhost/api/users
    ```
1. Bring the containers DOWN
    ```bash
    sail down
    ```


Misc Commands
```bash
sail psql
sail artisan tinker
sail ps
sail logs
sail bash
sail npm run dev
```

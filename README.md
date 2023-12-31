Project was built as a SPA with frontend Vuejs 3 and Laravel 10.39.0

Steps to be followed to run the project


Create a database & set the credentials in .env file as illustrated below
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=<db_name_created>
DB_USERNAME=<db_username>
DB_PASSWORD=<db_pw>

In terminal run below commands
composer install
composer dump-autoload
php artisan key:generate
php artisan config:cache
php artisan migrate
npm install
npm run dev
php artisan serve

The system will run at http://127.0.0.1:8000/

Project contains four input fields
1. Loan Amount
2. Annual Interest Rate
3. Loan Term(Years)
4. Repayment amount(If applicable)

Field no. 4 is not required field, could be entered to view amortization schedule with repayment


Sample Input fields

To view amortization schedule without repayment

1. Loan Amount => 200000
2. Annual Interest Rate => 3
3. Loan Term(Years) => 4


To view amortization schedule including repayment

1. Loan Amount => 200000
2. Annual Interest Rate => 3
3. Loan Term(Years) => 4
4. Repayment amount(If applicable) => 5000


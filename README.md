# Code sample - invoice system
Code sample is project for representing of my skills and programmer habits.

Simple invoice system with customer evidence. After sign in with valid credentials you can create customers. 
Customer has values as name, surname, company registration number, tax number, etc.
You can create invoice where you must specify name, description and customer that invoice belongs to. 
Invoices ID is generated automatically in form YYMMDDCCC(YY -year, MM - month, DD - day, CCC -sequence number).
After invoice creation you can generate PDF output with automatically prefilled values from database.
Global search field is in page header. You can search customers and invoices too by name, surname or email.

**Try demo here:**
```
http://bpavol.eu/code-sample
```

Login crendetials:
```
Email: test@test.com
Password: 123456
```

## Prerequisites
Apache >=2.4.18
PHP >=7.0.4
MySQL >=5.7.11
Composer >=1.2.0
NPM >=3.10.3

## Installation
Follow installation steps.

### 1. Run commands in application root directory:
```
composer update
cd www/
npm install
```

### 2. Import install.sql into database.

### 3. Set database credentials in file app/config/config.neon:
```
database:
	dsn: 'mysql:host=127.0.0.1;port=3306;dbname=code-sample'
	user: 'my-username'
	password: 'my-password'
	conventions: discovered
	options:
		charset: utf8mb4
		lazy: true	
```

### 4. Set **writing permissions** for directories:
* temp
* log
* www/webtemp

### 5. Login credentials:
```
Email: test@test.com
Password: 123456
```

Main index.php is in www directory but .htaccess should take care of redirection if modrewrite is installed.

## Used technologies, libraries and software
Apache, PHP, MySQL, JavaScript, jQuery, Bootstrap, Font Awesome, [Select2](https://select2.github.io/), HTML, CSS, LESS, Nette, Composer, NPM, GitHub, [mPDF](https://mpdf.github.io/), [janmarek/webloader](https://github.com/janmarek/WebLoader)

## Conventions
PSR-2: Coding Style Guide, PSR-4: Autoloader

## Time log of project development
In square brackets how much time I was spent on creation of specific modules of web application.

### Day 1\[4h\] 
* Installation
* Configuration of Nette sandbox
* Installation of PHP packages
* Installation of JS packages
* Create basic template

### Day 2\[4h\] 
* Designing a database table of users
* Authentication implementation
* Designing a database table of customers
* Displaying customers in data grid with option of arranging and mass removing
* Form for creating and modifying customers

### Day 3\[5h\]
* Designing a database table of invoices
* Displaying invoices in data grid with option of arranging and mass removing
* Installation and integration of [Select2](https://select2.github.io/) selectbox for ajax selection of users in invoice form
* Form for creating and modifying invoices
* Generation of invoices in PDF format
* Fulltext searchbox for both, customers and invoices
* Displaying invoices in customer editation form, that belongs to him

### Day 4\[2h 30m\]
* Embeding on production server
* Fixing minor bugs
* Last tests

Total: **15 hours and 30 minutes**
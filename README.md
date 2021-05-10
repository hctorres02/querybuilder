# QueryBuilder
A simple SQL query builder

## Configuration
QueryBuilder needs an environment variable named `database` containing the data from the `.env.example` file.\
You can make it available through a variable manager or using the `parse_ini_file` function.

```php
$parse = parse_ini_file('.env', true);
$_ENV['database'] = $parse['database'];
```

## Usage

### Select
```php
use HCTorres02\QueryBuilder\Database as DB;

// select * from posts
DB::table('posts')->fetchAll();

// select id, title, body from posts
DB::table('posts')
  ->select('id', 'title', 'body')
  ->fetchAll();

// Get SQL query
DB::table('posts')
  ->select('id', 'title', 'body')
  ->getSql();
```

### Insert
```php
use HCTorres02\QueryBuilder\Database as DB;

$lastId = DB::table('posts')
  ->insert([
    'title' => 'Lorem Ipsum',
    'body' => 'Lorem ipsum etc...'
  ])
  ->lastInsertId();

$post = DB::table('posts')
          ->where('id', $lastId)
          ->fetch();
```

### Update
```php
use HCTorres02\QueryBuilder\Database as DB;

DB::table('posts')
  ->update(1, [
    'title' => 'Ex machina'
  ])
  ->rowCount();
```

### Delete
```php
use HCTorres02\QueryBuilder\Database as DB;

DB::table('posts')
  ->delete(1)
  ->rowCount();
```

### Execute raw SQL
```php
use HCTorres02\QueryBuilder\Database as DB;

DB::execute('select * from posts')->fetchAll();
```

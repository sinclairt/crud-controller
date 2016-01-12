# Crud Controller

The Crud Controller is built to minimise the amount of code you need to write to get a resource off the ground. It is coupled with the Magic Views packed which get the views for these methods created in a cinch.

### Installation

Add the following repository to your ``` composer.json ```. You will have access as long as you belong to the Sterling team on Bitbucket.

``` sh
  "repositories": [
    {
      "type": "composer",
      "url": "http://satis.sterling-design.co.uk"
    }
  ]
```

``` composer require sterling/crud-controller```

``` composer install ```

Add the service provider to your ``` app/config ```

```sh
Sterling\MagicViews\MagicViewsServiceProvider::class
```

``` composer dump-autoload ```

### Usage

All you need to do is create a controller and use the CrudController trait, ensure a the ``` setUp ``` method is called inside your construct and you good to go! 

#### Repositories
The repository should extend ``` Sterling\CrudController\Repositories\Repository ```, but will at least need to implement ``` Sterling\CrudController\Contracts\Repository ```.

All the methods inside the repository use methods from the ``` Illuminate\Database\Eloquent\Model ``` class, so make sure if you are going to use something other than this in your repository you implement ``` Sterling\CrudController\Contracts\Repository ``` and implement ths methods as necessary.

### Magic Views

Please refer to the documentation for Magic Views for more information.
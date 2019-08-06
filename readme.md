# Description

This package ensures that your models get their own storage directories.

# Install

## Get the package

    composer require oncampus/model-repositories

## Extend the subjected model classes

    use Oncampus\ModelRepositories\Traits\PublicRepository; // for public repositories
    use Oncampus\ModelRepositories\Traits\PrivateRepository; // for private repositories

All models can have both repository types!

Inside the model classes you have to use the traits.

    use PublicRepository, PrivateRepository;

## Migration

    php artisan migrate


# Usage

## Functions

The private and public repository has almost all the storage functions that the Laravel Framework provides.

Example for the Laravel standard:

    Storage::put($file, $content);

Example for this Model repositories package:

    Auth::user()->privateRepository->put($file, $content);


Some functions must have different names due to the inheritance hierarchies.
The following storage function calls have the following names via this repository package:

    Storage::append()   -->     $repository->appendContent()
    Storage::prepend()  -->     $repository->prependContent()
    Storage::delete()   -->     $repository->remove()

Some functions (for example move() or rename()) are not implemented yet.
Feel free to implement them and make a pull request.

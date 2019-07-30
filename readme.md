Some functions must have different names due to the inheritance hierarchies. The following storage function calls have the following names via the repository object:

    Storage::append() --> $repository->appendContent()
    Storage::prepend() --> $repository->prependContent()
    Storage::delete() --> $repository->remove()

Some functions (for example move() or rename()) are not implemented yet.
Feel free to implement them.
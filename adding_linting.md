# Adding linting

How to add linting to a new bitanami project.

## Clone our arc extensions submodule (this one)

We keep everything arc-related inside this repo and just
share it with all of our projects.

```
git submodule add git@github.com:Bitnami/arcanist-extensions.git .arcanist-extensions
```

## Load extensions

You need to tell arc to load the extensions in the .arcconfig

```
{
  "phabricator.uri" : "http://phabricator.bitnami.com:8080/",
  "project.name" : "Awesome bitnami project",
  "load": [
    ".arcanist-extensions/rubocop_linter",
    ".arcanist-extensions/scss_lint_linter"
  ]
}
```

Note: if anything you get unexpected errors double check you
are loading all required extensions in this file.

## Symlink lint files

From the home directory symlink all lint files from .arcanist-extensions.

```
ln -fsv .arcanist-extensions/.jshintrc . &&
ln -fsv .arcanist-extensions/.scss-lint.yml . &&
ln -fsv .arcanist-extensions/.rubocop.yml . &&
ln -fsv .arcanist-extensions/.arclint .
```

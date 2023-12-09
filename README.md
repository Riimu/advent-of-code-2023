# Advent of Code 2023 solutions

This repository contains my solutions for the Advent of Code 2023. Explore at
your own peril.

## Usage

The solutions are written in PHP and require PHP to be available on your
system to run.

In order to list all the implemented task commands, you may run:

```shell
php bin/console list
```

### Running tasks

All the task commands are in the format of `task:DayNPartN` and take path to
the input file as the argument. For example:

```shell
php bin/console task:Day5Part2 input/day-5-input.txt
```

### Generating new task files from template

To quickly generate new files for a task from the templates, you can use the
following command

```shell
php bin/console generate-task <day-number>
```

## Copyright

This library is Copyright (c) 2023 Riikka Kalliomäki.

See LICENSE for license and copying information.


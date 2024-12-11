<div align="center">

# PHP Matrix

[![Packagist Version](https://img.shields.io/packagist/v/typisttech/php-matrix)](https://packagist.org/packages/typisttech/php-matrix)
[![PHP Version Require](https://img.shields.io/packagist/dependency-v/typisttech/php-matrix/php)](https://github.com/typisttech/php-matrix/blob/readme/composer.json)
[![Test](https://github.com/typisttech/php-matrix/actions/workflows/test.yml/badge.svg)](https://github.com/typisttech/php-matrix/actions/workflows/test.yml)
[![codecov](https://codecov.io/gh/typisttech/php-matrix/graph/badge.svg?token=HV5UDLPMMQ)](https://codecov.io/gh/typisttech/php-matrix)
[![License](https://img.shields.io/github/license/typisttech/php-matrix.svg)](https://github.com/typisttech/php-matrix/blob/master/LICENSE)
[![Follow @TangRufus on X](https://img.shields.io/badge/Follow-TangRufus-15202B?logo=x&logoColor=white)](https://x.com/tangrufus)
[![Follow @TangRufus.com on Bluesky](https://img.shields.io/badge/Bluesky-TangRufus.com-blue?logo=bluesky)](https://bsky.app/profile/tangrufus.com)
[![Sponsor @TangRufus via GitHub](https://img.shields.io/badge/Sponsor-TangRufus-EA4AAA?logo=githubsponsors)](https://github.com/sponsors/tangrufus)
[![Hire Typist Tech](https://img.shields.io/badge/Hire-Typist%20Tech-778899)](https://typist.tech/contact/)

<p>
  <strong>List PHP versions that satisfy the given constraint.</strong>
  <br />
  <br />
  Built with ♥ by <a href="https://typist.tech/">Typist Tech</a>
</p>

</div>

---

## Usage

```console
$ php-matrix "^7 || ^8"
{
    "constraint": "^7 || ^8",
    "versions": [
        "7.4",
        "7.3",
        "7.2",
        "7.1",
        "7.0",
        "8.4",
        "8.3",
        "8.2",
        "8.1",
        "8.0"
    ],
    "lowest": "7.0",
    "highest": "8.4"
}

$ php-matrix --mode=full  "~7.4.29 || ~8.1.29"
{
    "constraint": "~7.4.29 || ~8.1.29",
    "versions": [
        "7.4.33",
        "7.4.32",
        "7.4.30",
        "7.4.29",
        "8.1.31",
        "8.1.30",
        "8.1.29"
    ],
    "lowest": "7.4.29",
    "highest": "8.1.31"
}

$ php-matrix --mode=minor-only  ">=7.2 <8.4"
{
    "constraint": ">=7.2 <8.4",
    "versions": [
        "7.4",
        "7.3",
        "7.2",
        "8.3",
        "8.2",
        "8.1",
        "8.0"
    ],
    "lowest": "7.2",
    "highest": "8.3"
}
```

### Options

#### `--mode`

| Value                  | Description                                                  |
|------------------------|--------------------------------------------------------------|
| `minor-only` (default) | Report `MAJOR.MINOR` versions only                           |
| `full`                 | Report all satisfying versions in `MAJOR.MINOR.PATCH` format |

#### `--source`

| Value            | Description                                                                                                 |
|------------------|-------------------------------------------------------------------------------------------------------------|
| `auto` (default) | Use `offline` in `minor-only` mode. Otherwise, fetch from [php.net](https://www.php.net/releases/index.php) |
| `php.net`        | Fetch releases information from [php.net](https://www.php.net/releases/index.php)                           |
| `offline`        | Use [hardcoded releases](resources/all-versions.json) information                                           |

## Installation

### Composer Global

```bash
composer global require typisttech/php-matrix
php-matrix --help
```

### Composer Project

```bash
composer create-project typisttech/php-matrix
cd php-matrix
php-matrix --help
```

## Credits

[`PHP Matrix`](https://github.com/typisttech/php-matrix) is a [Typist Tech](https://typist.tech) project and
maintained by [Tang Rufus](https://x.com/TangRufus), freelance developer for [hire](https://typist.tech/contact/).

Full list of contributors can be found [here](https://github.com/typisttech/php-matrix/graphs/contributors).

## Copyright and License

This project is a [free software](https://www.gnu.org/philosophy/free-sw.en.html) distributed under the terms of
the MIT license. For the full license, see [LICENSE](./LICENSE).

## Contribute

Feedbacks / bug reports / pull requests are welcome.

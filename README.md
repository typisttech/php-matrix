<div align="center">

# PHP Matrix

[![GitHub Release](https://img.shields.io/github/v/release/typisttech/php-matrix)](https://github.com/typisttech/php-matrix/releases)
[![Test](https://github.com/typisttech/php-matrix/actions/workflows/test.yml/badge.svg)](https://github.com/typisttech/php-matrix/actions/workflows/test.yml)
[![codecov](https://codecov.io/gh/typisttech/php-matrix/graph/badge.svg?token=HV5UDLPMMQ)](https://codecov.io/gh/typisttech/php-matrix)
[![License](https://img.shields.io/github/license/typisttech/php-matrix.svg)](https://github.com/typisttech/php-matrix/blob/master/LICENSE)
[![Follow @TangRufus on X](https://img.shields.io/badge/Follow-TangRufus-15202B?logo=x&logoColor=white)](https://x.com/tangrufus)
[![Follow @TangRufus.com on Bluesky](https://img.shields.io/badge/Bluesky-TangRufus.com-blue?logo=bluesky)](https://bsky.app/profile/tangrufus.com)
[![Sponsor @TangRufus via GitHub](https://img.shields.io/badge/Sponsor-TangRufus-EA4AAA?logo=githubsponsors)](https://github.com/sponsors/tangrufus)
[![Hire Typist Tech](https://img.shields.io/badge/Hire-Typist%20Tech-778899)](https://typist.tech/contact/)

<p>
  <strong>List PHP versions that satisfy the required PHP constraint in <code>composer.json</code>.</strong>
  <br>
  <br>
  Built with ♥ by <a href="https://typist.tech/">Typist Tech</a>
</p>

</div>

---

> [!TIP]
> **Hire Tang Rufus!**
>
> I am looking for my next role, freelance or full-time.
> If you find this tool useful, I can build you more weird stuff like this.
> Let's talk if you are hiring PHP / Ruby / Go developers.
>
> Contact me at https://typist.tech/contact/

---

## GitHub Actions Usage

For generating PHP version matrix in GitHub Actions, use [PHP Matrix Action](https://github.com/marketplace/actions/php-matrix).

<details>

<summary>Example</summary>

```yml
name: Test

on:
  push:

jobs:
  php-matrix:
    runs-on: ubuntu-latest
    outputs:
      versions: ${{ steps.php-matrix.outputs.versions }}
    steps:
      - uses: actions/checkout@v7
        with:
          sparse-checkout: composer.json
          sparse-checkout-cone-mode: false

      - uses: typisttech/php-matrix-action@v3
        id: php-matrix

  test:
    runs-on: ubuntu-latest
    needs: php-matrix
    strategy:
      matrix:
        php-version: ${{ fromJSON(needs.php-matrix.outputs.versions) }}
    steps:
      - uses: actions/checkout@v7
      - uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php-version }}
      - run: composer install
      - run: composer test
```

</details>

## CLI Usage

### List PHP versions that satisfy the required PHP constraint in `composer.json`

```console
$ cat ./composer.json
{"require":{"php":"^7 || ^8"}}

$ php-matrix composer
{
    "constraint": "^7 || ^8",
    "versions": [
        "7.0",
        "7.1",
        "7.2",
        "7.3",
        "7.4",
        "8.0",
        "8.1",
        "8.2",
        "8.3",
        "8.4"
    ],
    "lowest": "7.0",
    "highest": "8.4"
}
```

```console
$ cat ./some/path/to/the.json
{"require":{"php":"~7.4.29 || ~8.1.29"}}

$ php-matrix composer --source=php.net --mode=full ./some/path/to/the.json
{
    "constraint": "~7.4.29 || ~8.1.29",
    "versions": [
        "7.4.29",
        "7.4.30",
        "7.4.32",
        "7.4.33",
        "8.1.29",
        "8.1.30",
        "8.1.31",
        "8.1.32",
        "8.1.33"
    ],
    "lowest": "7.4.29",
    "highest": "8.1.33"
}
```

```console
$ php-matrix composer --help
Description:
  List PHP versions that satisfy the required PHP constraint in composer.json

Usage:
  composer [options] [--] [<path>]

Arguments:
  path                  Path to composer.json file. [default: "./composer.json"]

Options:
      --source=SOURCE   Available sources:
                        - auto: Use offline in minor-only mode. Otherwise, fetch from php.net
                        - php.net: Fetch releases information from php.net
                        - offline: Use hardcoded releases information
                         [default: "auto"]
      --mode=MODE       Available modes:
                        - full: Report all satisfying versions in MAJOR.MINOR.PATCH format
                        - minor-only: Report MAJOR.MINOR versions only
                         [default: "minor-only"]
  -h, --help            Display help for the given command. When no command is given display help for the list command
      --silent          Do not output any message
  -q, --quiet           Only errors are displayed. All other output is suppressed
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

### List PHP versions that satisfy the given constraint

```console
$ php-matrix constraint '^7 || ^8'
{
    "constraint": "^7 || ^8",
    "versions": [
        "7.0",
        "7.1",
        "7.2",
        "7.3",
        "7.4",
        "8.0",
        "8.1",
        "8.2",
        "8.3",
        "8.4"
    ],
    "lowest": "7.0",
    "highest": "8.4"
}
```

```console
$ php-matrix constraint --source=php.net --mode=full '~7.4.29 || ~8.1.29'
{
    "constraint": "~7.4.29 || ~8.1.29",
    "versions": [
        "7.4.29",
        "7.4.30",
        "7.4.32",
        "7.4.33",
        "8.1.29",
        "8.1.30",
        "8.1.31",
        "8.1.32",
        "8.1.33"
    ],
    "lowest": "7.4.29",
    "highest": "8.1.33"
}
```

```console
$ php-matrix constraint --help
Description:
  List PHP versions that satisfy the given constraint

Usage:
  constraint [options] [--] <constraint>

Arguments:
  constraint            The version constraint.

Options:
      --source=SOURCE   Available sources:
                        - auto: Use offline in minor-only mode. Otherwise, fetch from php.net
                        - php.net: Fetch releases information from php.net
                        - offline: Use hardcoded releases information
                         [default: "auto"]
      --mode=MODE       Available modes:
                        - full: Report all satisfying versions in MAJOR.MINOR.PATCH format
                        - minor-only: Report MAJOR.MINOR versions only
                         [default: "minor-only"]
  -h, --help            Display help for the given command. When no command is given display help for the list command
      --silent          Do not output any message
  -q, --quiet           Only errors are displayed. All other output is suppressed
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

### Options

#### `--mode`

Available modes:

- `minor-only` *(default)*: Report `MAJOR.MINOR` versions only
- `full`: Report all satisfying versions in `MAJOR.MINOR.PATCH` format

#### `--source`

Available sources:

- `auto` *(default)*: Use `offline` in
  `minor-only` mode. Otherwise, fetch from [php.net](https://www.php.net/releases/index.php)
- `php.net`: Fetch releases information from [php.net](https://www.php.net/releases/index.php)
- `offline`: Use [hardcoded releases](./data/all-versions.json) information

> [!TIP]
> **Hire Tang Rufus!**
>
> There is no need to understand any of these quirks.
> Let me handle them for you.
> I am seeking my next job, freelance or full-time.
>
> If you are hiring PHP / Ruby / Go developers,
> contact me at https://typist.tech/contact/

### Dump Shell Completion Scripts

For shell completions, follow the instructions from:

```console
$ php-matrix completion --help
```

If you installed `PHP Matrix` [via Homebrew](#homebrew-macos--linux-recommended), completion scripts are managed by Homebrew.
Read more at https://docs.brew.sh/Shell-Completion

## Installation

### Homebrew (macOS / Linux) (Recommended)

```bash
brew install typisttech/tap/php-matrix
```

### Linux (Debian & Alpine)

Follow the instructions on https://broadcasts.cloudsmith.com/typisttech/oss

![Cloudsmith](https://img.shields.io/badge/OSS%20hosting%20by-cloudsmith-blue?logo=cloudsmith&style=flat-square&link=https%3A%2F%2Fcloudsmith.com)

Package repository hosting is graciously provided by [Cloudsmith](https://cloudsmith.com).
Cloudsmith is the only fully hosted, cloud-native, universal package management solution, that
enables your organization to create, store and share packages in any format, to any place, with total
confidence.

### Pre-built `.deb` & `.apk`

> [!WARNING]
> If you install the `.deb` or `.apk` file manually, you have to updating them manually.

Download the latest `.deb` or `.apk` file from [GitHub Releases](https://github.com/typisttech/php-matrix/releases/latest), or via [`gh`](https://cli.github.com/).

Then, install it via `dpkg -install` or `apk add`.

### Pre-built Binaries

> [!WARNING]
> If you install the binaries manually, you have to updating them manually.

Download the latest `.tar.gz` file from [GitHub Releases](https://github.com/typisttech/php-matrix/releases/latest), or via [`gh`](https://cli.github.com/).

Then, unarchive and move the binary into `$PATH`.

## People Also Use

- [PHP Matrix Action](https://github.com/typisttech/php-matrix-action)
  Generate PHP version matrix according to `composer.json` for GitHub Actions
- [Composer Audit to SARIF Action](https://github.com/typisttech/composer-audit-to-sarif-action)
  Convert Composer audit reports to SARIF files in GitHub Actions
- [WP Sec Adv](https://github.com/typisttech/wpsecadv)
  Composer repository for WordPress security advisories
- [WP Org Closed Plugin](https://github.com/typisttech/wp-org-closed-plugin)
  Composer plugin to mark packages as abandoned if closed on WordPress.org

## Credits

[`PHP Matrix`](https://github.com/typisttech/php-matrix) is a [Typist Tech](https://typist.tech) project and maintained by [Tang Rufus](https://x.com/TangRufus), freelance developer [for hire](https://typist.tech/contact/).

Full list of contributors can be found [on GitHub](https://github.com/typisttech/php-matrix/graphs/contributors).

## Copyright and License

This project is a [free software](https://www.gnu.org/philosophy/free-sw.en.html) distributed under the terms of the MIT license.
For the full license, see [LICENSE](./LICENSE).

## Contribute

Feedbacks / bug reports / pull requests are welcome.

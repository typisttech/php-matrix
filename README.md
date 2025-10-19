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
  <strong>List PHP versions that satisfy the given constraint.</strong>
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
> If you find this tool useful, I can build you more weird stuffs like this.
> Let's talk if you are hiring PHP / Ruby / Go developers.
>
> Contact me at https://typist.tech/contact/

---

## Usage

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

```sh
brew tap typisttech/tap
brew install typisttech/tap/php-matrix
```

### `apt-get` (Debian based distributions, for example: Ubuntu)

```sh
curl -1sLf 'https://dl.cloudsmith.io/public/typisttech/oss/setup.deb.sh' | sudo -E bash
sudo apt-get install php-matrix
```

Instead of the automatic setup script, you can manually configure the repository with the instructions on [Cloudsmith](https://cloudsmith.io/~typisttech/repos/oss/setup/#formats-deb).

### Manual `.deb` (Debian based distributions, for example: Ubuntu)

> [!WARNING]
> If you install the `.deb` file manually, you have to take care of updating it by yourself.

Download the latest `.deb` file from [GitHub Releases](https://github.com/typisttech/php-matrix/releases/latest), or via [`gh`](https://cli.github.com/):

```sh
# Both arm64 (aarch64) and amd64 (x86_64) architectures are available.
gh release download --repo 'typisttech/php-matrix' --pattern 'php-matrix_linux_arm64.deb'
```

**Optionally**, verify the `.deb` file:

```sh
gh attestation verify --repo 'typisttech/php-matrix' 'php-matrix_linux_arm64.deb'
```

Finally, install the package:

```sh
sudo dpkg -i php-matrix_linux_arm64.deb
```

## Manual Binary

> [!WARNING]
> If you install the binary manually, you have to take care of updating it by yourself.

Download the latest `.tar.gz` file from [GitHub Releases](https://github.com/typisttech/php-matrix/releases/latest), or via [`gh`](https://cli.github.com/):

```sh
# Both darwin (macOS) and linux operating systems are available.
# Both arm64 (aarch64) and amd64 (x86_64) architectures are available.
gh release download --repo 'typisttech/php-matrix' --pattern 'php-matrix_darwin_arm64.tar.gz'
```

**Optionally**, verify the `.tar.gz` file:

```sh
gh attestation verify --repo 'typisttech/php-matrix' 'php-matrix_darwin_arm64.tar.gz'
```

Finally, unarchive and move the binary into `$PATH`:

```sh
tar -xvf 'php-matrix_darwin_arm64.tar.gz'

# Or, move it to any directory under `$PATH`
mv php-matrix /usr/local/bin
```

## Credits

[`PHP Matrix`](https://github.com/typisttech/php-matrix) is a [Typist Tech](https://typist.tech) project and maintained by [Tang Rufus](https://x.com/TangRufus), freelance developer [for hire](https://typist.tech/contact/).

Full list of contributors can be found [on GitHub](https://github.com/typisttech/php-matrix/graphs/contributors).

## Copyright and License

This project is a [free software](https://www.gnu.org/philosophy/free-sw.en.html) distributed under the terms of the MIT license.
For the full license, see [LICENSE](./LICENSE).

## Contribute

Feedbacks / bug reports / pull requests are welcome.

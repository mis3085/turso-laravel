# Hard-fork identity: republish as mis3085/turso-laravel under the Mis3085\Turso namespace

Upstream richan-fongdasen/turso-laravel has been dormant since November 2024 and its community PR adding Laravel 12/13 support sat unreviewed for months, so we maintain this fork independently and publish it on Packagist as `mis3085/turso-laravel`. We renamed the PHP namespace from `RichanFongdasen\Turso` to `Mis3085\Turso` at v2.0.0 while there were zero downstream users, because after the package gains users the rename becomes a breaking change. We accepted losing trivial upstream merge-ability in exchange for a clean identity in class names, stack traces and docs; upstream fixes will be cherry-picked by hand if they ever appear.

## Considered Options

- **Keep the upstream namespace** — minimal diff and easy merges from upstream, but users would install our package while seeing another vendor's name everywhere.
- **Rename now (chosen)** — one-time mechanical cost before any users exist; upstream appears permanently dormant so future merges are unlikely to matter.

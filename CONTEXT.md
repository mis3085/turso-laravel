# Turso Laravel

A Laravel database driver that talks to Turso/LibSQL database servers over HTTP instead of PDO.

## Language

**Turso**:
The hosted LibSQL database service; the remote server this driver communicates with over HTTP.
_Avoid_: cloud database, remote DB

**LibSQL**:
A fork of SQLite that can run embedded or behind an HTTP server (sqld); the storage engine behind Turso.
_Avoid_: SQLite (they are not interchangeable here)

**Embedded Replica**:
A local read-only copy of a remote Turso database stored in a local file; reads are served locally, writes go to the remote server. Configured via `db_replica`.
_Avoid_: local cache, mirror

**Sync**:
The act of pulling remote changes into an embedded replica; exposed as the `turso:sync` artisan command, a queued job, and `DB::sync()` / `DB::backgroundSync()`.
_Avoid_: refresh, pull

**Access Token**:
The credential sent with every HTTP request to authorize access to a Turso database server.
_Avoid_: password, API key

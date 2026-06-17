# Coding Standards (Binding)

Status: binding for all new and refactored code paths.
Scope: PHP backend (`public/php/**`), SQL in PHP strings and `database/**`, JS API integration (`public/js/**`).

## 1. Naming Convention

1. Source code identifiers (`function`, variable, class, file names in PHP/JS) use English.
2. PHP function names use `camelCase`.
3. JS constants use `glPascalCaseLikeThis` for global constants (existing project style) and `camelCase` for locals.
4. Database object names keep snake_case (`nov_user`, `activation_code`, `nov_mode`).
5. New public API action names (`functionname`) use English verbs and nouns, e.g. `getUser`, `saveUserSettings`.

## 2. SQL Style Convention

1. SQL keywords are uppercase (`SELECT`, `FROM`, `WHERE`, `UPDATE`, `INSERT`, `JOIN`, `GROUP BY`, `ORDER BY`, `LIMIT`).
2. Table and column names are written exactly as defined in schema (snake_case, lowercase).
3. Every dynamic value uses prepared statements with bind parameters (`?` placeholders).
4. No string concatenation for SQL values.
5. Keep one SQL statement per logical operation when practical; if multiple statements are required, use transactions.
6. Always include explicit ordering when top-N or deterministic order is expected.

## 3. API Response Convention

1. New and refactored backend endpoints return JSON objects.
2. Response shape for success:
   - `ok: true`
   - payload fields (domain-specific)
3. Response shape for errors:
   - `ok: false`
   - `error_code`
   - `error_message`
4. Legacy responses (`"Y"`, `"N"`, `"ok"`) are tolerated only for unchanged legacy endpoints and must not be introduced in new code.

## 4. Logging Convention

1. Do not log credentials, secrets, token values, SQL query text with user inputs, or internal DB names from request payloads.
2. Use short, structured messages with operation and result status.
3. Error logs may include technical context but no sensitive data.

## 5. Migration Rule

1. Existing legacy code is migrated incrementally during touch/refactor work.
2. Any file touched for functional changes must align with these rules in the changed code region.

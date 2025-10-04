-- ✅ SAFE TO DELETE - Role assignments have been migrated
-- All user-role assignments now reference the 'roles' table
-- Spatie is configured to use 'roles' and 'permissions' tables

DROP TABLE IF EXISTS spatie_roles;
DROP TABLE IF EXISTS spatie_permissions;

-- Optional: Also drop related pivot tables if they exist
-- DROP TABLE IF EXISTS spatie_role_has_permissions;
-- DROP TABLE IF EXISTS spatie_model_has_roles;
-- DROP TABLE IF EXISTS spatie_model_has_permissions;

-- Drop old Spatie tables that are no longer needed
-- Run this after verifying everything works correctly

DROP TABLE IF EXISTS spatie_role_has_permissions;
DROP TABLE IF EXISTS spatie_model_has_roles;
DROP TABLE IF EXISTS spatie_model_has_permissions;
DROP TABLE IF EXISTS spatie_roles;
DROP TABLE IF EXISTS spatie_permissions;

# Full Migration Guide - Consolidating to Single Tables

## Current Situation

You have **duplicate tables** with **different schemas**:

### Roles Tables:
- `roles` (4 records) - ✅ Your main table
- `spatie_roles` (6 records) - ❌ Old Spatie table

### Permissions Tables:
- `permissions` (12 records) - Custom schema with display_name, description
- `spatie_permissions` (71 records) - Spatie schema with guard_name

## Problem

The tables have **incompatible schemas**, making direct migration difficult.

## RECOMMENDED SOLUTION

Since the schemas are incompatible and you have a working custom permission system, I recommend:

### **Keep your custom tables, configure Spatie to use them**

## Implementation Steps

### ✅ Step 1: Already Done - Roles
- Config updated to use `roles` table
- Role assignments migrated
- `spatie_roles` can be deleted

### ⚠️ Step 2: Permissions - Manual SQL Migration

Run this SQL to migrate permissions properly:

```sql
-- Insert missing permissions from spatie_permissions to permissions
INSERT INTO permissions (name, display_name, description, created_at, updated_at)
SELECT 
    sp.name,
    REPLACE(REPLACE(INITCAP(sp.name), '-', ' '), '_', ' ') as display_name,
    COALESCE(sp.description, CONCAT('Permission for ', sp.name)) as description,
    COALESCE(sp.created_at, NOW()) as created_at,
    COALESCE(sp.updated_at, NOW()) as updated_at
FROM spatie_permissions sp
WHERE NOT EXISTS (
    SELECT 1 FROM permissions p WHERE p.name = sp.name
);

-- Create a mapping table temporarily
CREATE TEMPORARY TABLE perm_id_map AS
SELECT 
    sp.id as old_id,
    p.id as new_id
FROM spatie_permissions sp
JOIN permissions p ON p.name = sp.name;

-- Update role_has_permissions to use new IDs
UPDATE role_has_permissions rhp
JOIN perm_id_map m ON rhp.permission_id = m.old_id
SET rhp.permission_id = m.new_id;

-- Verify
SELECT 'Permissions in permissions table:' as info, COUNT(*) as count FROM permissions
UNION ALL
SELECT 'Permissions in spatie_permissions:', COUNT(*) FROM spatie_permissions
UNION ALL
SELECT 'Records in role_has_permissions:', COUNT(*) FROM role_has_permissions;
```

### Step 3: Drop Old Tables

After verification:

```sql
DROP TABLE IF EXISTS spatie_roles;
DROP TABLE IF EXISTS spatie_permissions;
```

## Alternative: Use Spatie Tables

If the SQL migration is too complex, you can:

1. **Revert config** to use Spatie tables:
```php
// config/permission.php
'roles' => 'spatie_roles',
'permissions' => 'spatie_permissions',
```

2. **Migrate your custom data** to Spatie tables instead

## Current Status

✅ Roles: Migrated successfully  
⚠️ Permissions: Schema incompatibility - needs SQL migration  
✅ Config: Updated to use main tables  

## Next Action

**Choose one:**

**Option A:** Run the SQL migration above (Recommended)
- Migrates all 71 permissions
- Updates all references
- Clean single-table structure

**Option B:** Keep both permission systems
- Use `permissions` for custom system
- Use `spatie_permissions` for Spatie
- Update config accordingly

**Option C:** Revert to Spatie tables
- Change config back
- Simpler but loses custom schema

## Files Created

- `FULL_MIGRATION_SCRIPT.php` - Comprehensive migration (had schema issues)
- `AUTO_MIGRATE.php` - Simplified version (had errors)
- `SAFE_TO_DELETE_SPATIE_TABLES.sql` - For cleanup after migration
- This guide

## Recommendation

Run the SQL migration manually in your database tool (phpMyAdmin, MySQL Workbench, etc.) as it handles the schema differences better than PHP scripts.

-- ACCESS CONTROL TABLES RENAME
-- Execute these commands in your database

-- Rename tables with ac_ prefix
RENAME TABLE `users` TO `ac_users`;
RENAME TABLE `user_roles` TO `ac_user_roles`;  
RENAME TABLE `role_permissions` TO `ac_role_permissions`;
RENAME TABLE `permissions` TO `ac_permissions`;
RENAME TABLE `spatie_roles` TO `ac_roles`;

-- Verify the rename was successful
SELECT 'ac_users' as table_name, COUNT(*) as record_count FROM ac_users
UNION ALL
SELECT 'ac_user_roles', COUNT(*) FROM ac_user_roles  
UNION ALL
SELECT 'ac_role_permissions', COUNT(*) FROM ac_role_permissions
UNION ALL
SELECT 'ac_permissions', COUNT(*) FROM ac_permissions
UNION ALL
SELECT 'ac_roles', COUNT(*) FROM ac_roles;

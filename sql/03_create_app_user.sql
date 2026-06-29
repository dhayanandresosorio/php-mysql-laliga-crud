-- 03_create_app_user.sql
-- Sustituir CHANGE_ME_DB_PASSWORD por una contraseña local antes de ejecutar.

CREATE USER IF NOT EXISTS 'laliga_app'@'localhost'
IDENTIFIED BY 'CHANGE_ME_DB_PASSWORD';

GRANT ALL PRIVILEGES ON laliga.* TO 'laliga_app'@'localhost';

FLUSH PRIVILEGES;

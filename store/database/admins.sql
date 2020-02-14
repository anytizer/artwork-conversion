CREATE TABLE "admins" (
	"admin_id"	TEXT NOT NULL,
	"admin_name"	TEXT NOT NULL,
	"admin_email"	TEXT NOT NULL UNIQUE,
	"admin_password"	TEXT NOT NULL,
	"admin_code"	TEXT NOT NULL,
	"admin_active"	INTEGER NOT NULL,
	PRIMARY KEY("admin_id")
);
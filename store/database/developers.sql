CREATE TABLE "developers" (
	"developer_id"	TEXT NOT NULL,
	"developer_name"	TEXT NOT NULL,
	"developer_email"	TEXT NOT NULL UNIQUE,
	"developer_password"	TEXT NOT NULL,
	"developer_code"	TEXT NOT NULL,
	"developer_active"	INTEGER NOT NULL DEFAULT 0,
	"developer_onboarded"	INTEGER NOT NULL DEFAULT 0,
	PRIMARY KEY("developer_id")
);
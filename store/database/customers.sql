CREATE TABLE "customers" (
	"customer_id"	TEXT NOT NULL,
	"customer_name"	TEXT NOT NULL,
	"customer_email"	TEXT NOT NULL UNIQUE,
	"customer_password"	TEXT NOT NULL,
	"customer_code"	TEXT NOT NULL,
	"customer_active"	INTEGER NOT NULL,
	PRIMARY KEY("customer_id")
);
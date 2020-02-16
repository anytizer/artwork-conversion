CREATE TABLE "projects" (
	"project_id"	TEXT NOT NULL,
	"customer_id"	TEXT NOT NULL,
	"project_name"	TEXT NOT NULL,
	"project_date"	TEXT NOT NULL,
	"project_budget"	NUMERIC NOT NULL DEFAULT 0.00,
	"project_paid"	NUMERIC NOT NULL DEFAULT 0.00,
	"project_active"	INTEGER NOT NULL DEFAULT 0,
	"project_terminated"	INTEGER NOT NULL DEFAULT 0,
	PRIMARY KEY("project_id"),
    FOREIGN KEY(customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE ON UPDATE CASCADE
);